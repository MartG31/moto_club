<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface; // Connexion a la base de données
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Respect\Validation\Validator as v;
use Intervention\Image\ImageManagerStatic as Image;

//use App\Repository\ReunionsRepository;

use App\Entity\Utilisateurs;
use App\Entity\Reunions;
use App\Entity\ComptesRendus;


class ReunionsController extends MasterController
{

    ///////attributs
    public $typesReu = array(
        'Bureau' => 'Réunion du bureau', 
        'AG' => 'Assemblée Générale', 
        'Autre' => 'Autre', 
    );

    /**
     * @Route("/reunions", name="reunions")
     */
    
    public function indexReunion() {

        // if($this->restrictAccess('adherent')) { return $this->redirectToRoute('accueil'); }

    	// Récupération de la liste des réunions
        $entityManager = $this->getDoctrine()->getManager();
        // Permet de chercher les réunions via le repository
        $reuFound = $entityManager->getRepository(Reunions::class)->findAll();
        $reuNotPass = $entityManager->getRepository(Reunions::class)->findAllNotPast();
        $reuPass = $entityManager->getRepository(Reunions::class)->findAllPast();

        $reuWithoutCr = [];
        foreach ($reuPass as $reu) {
            // Vérifie si un CR existe et l'ajoute a mon tableau
            $crFound = $entityManager->getRepository(ComptesRendus::class)->findOneBy([
                'reu' => $reu
            ]);
            if(empty($crFound)){
                $reuWithoutCr[] = $reu;
            }
        }

        return $this->render('reunions/index.html.twig', [
            'reunionsPassees'  => $reuPass, 
            'reusNonPassees'   => $reuNotPass,
            'reusSansCr'       => $reuWithoutCr,
            'reusSansCr'       => $reuWithoutCr,
            //'reunionsTrouvees' => $newReus, 
            //'crTrouves' => $crFound,
        ]);
    }

    public function indexBackReunion() {

        if($this->restrictAccess('adherent')) { return $this->redirectToRoute('accueil'); }

        // Récupération de la liste des réunions
        $entityManager = $this->getDoctrine()->getManager();
        // Permet de chercher les réunions via le repository
        $reuFound = $entityManager->getRepository(Reunions::class)->findAll();
        $reuNotPass = $entityManager->getRepository(Reunions::class)->findAllNotPast();
        $reuPass = $entityManager->getRepository(Reunions::class)->findAllPast();

        $reuWithoutCr = [];
        foreach ($reuPass as $reu) {
            // Vérifie si un CR existe et l'ajoute a mon tableau
            $crFound = $entityManager->getRepository(ComptesRendus::class)->findOneBy([
                'reu' => $reu
            ]);
            if(empty($crFound)){
                $reuWithoutCr[] = $reu;
            }
        }

        return $this->render('reunions/indexBackReunion.html.twig', [
            'reunionsPassees'  => $reuPass, 
            'reusNonPassees'   => $reuNotPass,
            'reusSansCr'       => $reuWithoutCr,
            //'crTrouve'         => $crFound,
            //'reunionsTrouvees' => $newReus, 
        ]);
    }

    public function viewReunion($id) {

        // if($this->restrictAccess('adherent')) { return $this->redirectToRoute('accueil'); }

    	// Récupération de la liste des réunions
            $entityManager = $this->getDoctrine()->getManager();
            // Permet de chercher les réunions via le repository
            $reuFound = $entityManager->getRepository(Reunions::class)->find($id);
            $crFound = $entityManager->getRepository(ComptesRendus::class)->findOneBy([
                'reu' => $reuFound
            ]);
            //$crFound = $entityManager->getRepository(ComptesRendus::class)->find(getReu()->$id);
            //$crFound = $entityManager->getRepository(ComptesRendus::class)->findOneBy(['reu'];

        return $this->render('reunions/viewReu.html.twig', [
            'reunionTrouvee' => $reuFound, 
            'crTrouve'       => $crFound,
        ]);
    }


    public function viewBackReunion($id) {

        if($this->restrictAccess('adherent')) { return $this->redirectToRoute('accueil'); }


        // Récupération de la liste des réunions
            $entityManager = $this->getDoctrine()->getManager();
            // Permet de chercher les réunions via le repository 
            $reuFound = $entityManager->getRepository(Reunions::class)->find($id);
            $crFound = $entityManager->getRepository(ComptesRendus::class)->findOneBy([
                'reu' => $reuFound
            ]);

            $showBtn = false;
            if($reuFound->getDatetimeReu() > new \DateTime('now')){
                $showBtn = true;
            }

            

        return $this->render('reunions/viewBackReu.html.twig', [ 
            'crTrouve'          => $crFound,
            'reunionTrouvee'    => $reuFound,
            'bouton'            => $showBtn        
        ]);
    }

    public function addReunion() {

        if($this->restrictAccess('bureau')) { return $this->redirectToRoute('accueil'); }

        // Utilisation de la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(Utilisateurs::class)->find($this->session->get('id'));
        

        if(!empty($_POST)){

            $safe = array_map('trim', array_map('strip_tags', $_POST));

            //pas de controle d'unicité de la réunion : il s'agira d'une modération manuelle
            #$entityManager = $this->getDoctrine()->getManager();
            #$userFound = $entityManager->getRepository(Reunions::class)->findByEmail($safe['email']);
            //var_dump($userFound);
            
           ///////////////////////////////////////// tableau d'erreur

            $errors = [                                                      
            (!v::notEmpty()->stringType()->length(3, 80)->validate($safe['titre'])) ? 'L\'intitulé de la réunion doit faire entre 3 et 80 caractères' : null,
            (!v::notEmpty()->stringType()->length(3, 80)->validate($safe['lieu'])) ? 'Le lieu de réunion doit faire entre 3 et 80 caractères' : null,
            (!v::notEmpty()->stringType()->in(array_keys($this->typesReu))->validate($safe['type'])) ? 'Merci de choisir le type de réunion parmis les choix proposés' : null,
            (!v::notEmpty()->stringType()->length(3)->validate($safe['contenu'])) ? 'Le contenu doit faire au moins 3 caractères' : null,
            (!v::notEmpty()->date()->validate($safe['date_reu'])) ? 'La réunion doit être une date valide' : null,
            (!v::notEmpty()->validate($safe['time_reu'])) ? 'L\'heure de la réunion doit être renseignée' : null,
            (!$this->checkTime($safe['time_reu'])) ? 'L\'heure de la réunion doit être une heure valide' : null,            
            ];

            $errors = array_filter($errors);

            if(count($errors) == 0 ){
                   /////////////////////////////////////////// ajout bdd ////////////////////////////////////              
                $reunion = new Reunions();
                $reunion->setTitre($safe['titre'])
                        ->setLieuReu($safe['lieu'])
                        ->setTypeReu($safe['type'])
                        ->setContenu($safe['contenu'])
                        //->setUser($_SESSION['user'])
                        ->setDatetimeReu($this->mergeDateTime($safe['date_reu'], $safe['time_reu']))
                        ->setDatetimePost(new \DateTime('now'))
                        ->setUser($user);
                

                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($reunion);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();
                $success = true;

                if ($safe['type'] == 'Bureau') {
                    // Envoi du mail
                    $users = $this->getDoctrine()->getRepository(Utilisateurs::class)->findAll();
                    $bureauMin = [];
                    foreach ($users as $user) {
                        if($user->getAcces() == 'bureau' || $user->getAcces() == 'admin') {
                            $bureauMin[] = $user->getEmail();
                        }
                    }

                    $receivers = $bureauMin;
                    $subject = 'Amicale BMW Moto 38 - Nouvelle réunion Bureau : '.date("d/m/Y", strtotime($safe['date_reu'])).' - '.$safe['titre'];
                    $content = '<h2>Nouvelle réunion ('.$safe['type'].') le '.date("d/m/Y", strtotime($safe['date_reu'])).' : '.$safe['titre'].'</h2>
                                <p>Bonjour, nous vous informons qu\'une réunion Bureau a été ajoutée sur le site de l\'Amicale BMW Moto 38.<br>
                                Cette réunion ('.$safe['type'].') a pour sujet <strong>"'.$safe['titre'].'"</strong> et se déroulera le <strong>'.date("d/m/Y", strtotime($safe['date_reu'])).'</strong> à <strong>'.$safe['lieu'].'</strong><br>
                                Vous pouvez consulter les <a href="http://127.0.0.1:8000/reunions/details/'.$reunion->getId().'">détails</a> de cette réunion.</p>';

                    $this->sendingMails($receivers, $subject, $content);
                }

                else {
                    // Envoi du mail
                    $users = $this->getDoctrine()->getRepository(Utilisateurs::class)->findAll();
                    $adherentsMin = [];
                    foreach ($users as $user) {
                        if($user->getAcces() != 'membre') {
                            $adherentsMin[] = $user->getEmail();
                        }
                    }

                    $receivers = $adherentsMin;
                    $subject = 'Amicale BMW Moto 38 - Nouvelle réunion : '.date("d/m/Y", strtotime($safe['date_reu'])).' - '.$safe['titre'];
                    $content = '<h2>Nouvelle réunion ('.$safe['type'].') le '.date("d/m/Y", strtotime($safe['date_reu'])).' : '.$safe['titre'].'</h2>
                                <p>Bonjour, nous vous informons qu\'une réunion a été ajoutée sur le site de l\'Amicale BMW Moto 38.<br>
                                Cette réunion ('.$safe['type'].') a pour sujet <strong>"'.$safe['titre'].'"</strong> et se déroulera le <strong>'.date("d/m/Y", strtotime($safe['date_reu'])).'</strong> à <strong>'.$safe['lieu'].'</strong><br>
                                Vous pouvez consulter les <a href="http://127.0.0.1:8000/reunions/details/'.$reunion->getId().'">détails</a> de cette réunion.</p>';

                    $this->sendingMails($receivers, $subject, $content);
                }
            }
            else {
                $errorsForm = implode('<br>', $errors);
            }
  
        }

       return $this->render('reunions/addReu.html.twig', [
           'success'            => $success ?? false,
           'errors'             => $errorsForm ?? [],
           'donnees_saisies'    => $safe ?? [],
           'typesReu'           => $this->typesReu,
           //'maxSizeFile'          => $this->maxSizeFile,

                   
        ]);     
    }

    public function editReunion($id) {

        if($this->restrictAccess('bureau')) { return $this->redirectToRoute('accueil'); }

        // Utilisation de la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $reuFound = $entityManager->getRepository(Reunions::class)->find($id);
        

        if(!empty($_POST)){

            $safe = array_map('trim', array_map('strip_tags', $_POST));
            
           ///////////////////////////////////////// tableau d'erreur

            $errors = [                                                      
            (!v::notEmpty()->stringType()->length(3, 80)->validate($safe['titre'])) ? 'L\'intitulé de la réunion doit faire entre 3 et 80 caractères' : null,
            (!v::notEmpty()->stringType()->length(3, 80)->validate($safe['lieu'])) ? 'Le lieu de réunion doit faire entre 3 et 80 caractères' : null,
            (!v::notEmpty()->in(array_keys($this->typesReu))->validate($safe['type'])) ? 'Merci de choisir le type de réunion parmis les choix proposés' : null,
            (!v::notEmpty()->stringType()->length(3)->validate($safe['contenu'])) ? 'Le contenu doit faire au moins 3 caractères' : null,
            (!v::notEmpty()->date()->validate($safe['date_reu'])) ? 'La réunion doit être une date valide' : null,
            (!v::notEmpty()->validate($safe['time_reu'])) ? 'L\'heure de la réunion doit être renseignée' : null,
            (!$this->checkTime($safe['time_reu'])) ? 'L\'heure de la réunion doit être une heure valide' : null, 
            
            ];

            $errors = array_filter($errors);

            if(count($errors) == 0 ){

                   /////////////////////////////////////////// ajout bdd ////////////////////////////////////              
                $reuFound->setTitre($safe['titre'])
                        ->setLieuReu($safe['lieu'])
                        ->setTypeReu($safe['type'])
                        ->setContenu($safe['contenu'])
                        ->setDatetimeReu($this->mergeDateTime($safe['date_reu'], $safe['time_reu']))
                        ->setDatetimePost(new \DateTime('now'));
                

                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($reuFound);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();
                $success = true;

                if ($safe['type'] == 'Bureau') {
                    // Envoi du mail
                    $users = $this->getDoctrine()->getRepository(Utilisateurs::class)->findAll();
                    $bureauMin = [];
                    foreach ($users as $user) {
                        if($user->getAcces() == 'bureau' || $user->getAcces() == 'admin') {
                            $bureauMin[] = $user->getEmail();
                        }
                    }

                    $receivers = $bureauMin;
                    $subject = 'Amicale BMW Moto 38 - Modification d\'une réunion : '.date("d/m/Y", strtotime($safe['date_reu'])).' - '.$safe['titre'];
                    $content = '<h2>Modification sur la réunion ('.$safe['type'].') du '.date("d/m/Y", strtotime($safe['date_reu'])).' : '.$safe['titre'].'</h2>
                            <p>Bonjour, nous vous informons qu\'une modification a été apportée sur la réunion.<br>
                            Vous pouvez consulter les <a href="http://127.0.0.1:8000/reunions/details/'.$reuFound->getId().'">détails</a> de cette réunion.</p>';

                    $this->sendingMails($receivers, $subject, $content);
                }

                else {
                    // Envoi du mail
                    $users = $this->getDoctrine()->getRepository(Utilisateurs::class)->findAll();
                    $adherentsMin = [];
                    foreach ($users as $user) {
                        if($user->getAcces() != 'membre') {
                            $adherentsMin[] = $user->getEmail();
                        }
                    }

                    $receivers = $adherentsMin;
                    $subject = 'Amicale BMW Moto 38 - Modification d\'une réunion : '.date("d/m/Y", strtotime($safe['date_reu'])).' - '.$safe['titre'];
                    $content = '<h2>Modification sur la réunion ('.$safe['type'].') du '.date("d/m/Y", strtotime($safe['date_reu'])).' : '.$safe['titre'].'</h2>
                            <p>Bonjour, nous vous informons qu\'une modification a été apportée sur la réunion.<br>
                            Vous pouvez consulter les <a href="http://127.0.0.1:8000/reunions/details/'.$reuFound->getId().'">détails</a> de cette réunion.</p>';

                    $this->sendingMails($receivers, $subject, $content);
                }
            }
            else {
                $errorsForm = implode('<br>', $errors);
            }
        }

        return $this->render('reunions/editReu.html.twig', [
            'success'        => $success ?? false,
            'errors'         => $errorsForm ?? [],
            'reunionTrouvee' => $reuFound,
            'typesReu'       => $this->typesReu,
        ]);
    }

    public function delReunion($id) {

        if($this->restrictAccess('bureau')) { return $this->redirectToRoute('accueil'); }

        // Récupération de la liste des réunions
            $entityManager = $this->getDoctrine()->getManager();
            // Permet de chercher les réunions via le repository
            $reuFound = $entityManager->getRepository(Reunions::class)->find($id);
                //suppression de l'article trouvé
                #$entityManager->remove($reuFound);
                #$entityManager->flush();

        return $this->render('reunions/delReu.html.twig', [
            'reunionTrouvee' => $reuFound,
        ]);
    }

    public function delConf($id) {

        if($this->restrictAccess('bureau')) { return $this->redirectToRoute('accueil'); }

        // Récupération de la liste des réunions
        $entityManager = $this->getDoctrine()->getManager();
        // Permet de chercher les réunions via le repository
        $reuFound = $entityManager->getRepository(Reunions::class)->find($id);
        // Envoi du mail
        $users = $this->getDoctrine()->getRepository(Utilisateurs::class)->findAll();

        if ($reuFound->getTypeReu() == 'Bureau') {
            // Envoi du mail
            $users = $this->getDoctrine()->getRepository(Utilisateurs::class)->findAll();
            $bureauMin = [];
            foreach ($users as $user) {
                if($user->getAcces() == 'bureau' || $user->getAcces() == 'admin') {
                    $bureauMin[] = $user->getEmail();
                }
            }

            $receivers = $bureauMin;
            $subject = 'Amicale BMW Moto 38 - Suppression d\'une réunion : '.$reuFound->getDatetimeReu()->format('d/m/Y').' - '.$reuFound->getTitre();
            $content = '<h2>Suppression de la réunion du '.$reuFound->getDatetimeReu()->format('d/m/Y').' : '.$reuFound->getTitre().'</h2>
                        <p>Bonjour, nous vous informons que la réunion a été supprimée.</p>';

            $this->sendingMails($receivers, $subject, $content);
        }

        else {
            // Envoi du mail
            $users = $this->getDoctrine()->getRepository(Utilisateurs::class)->findAll();
            $adherentsMin = [];
            foreach ($users as $user) {
                if($user->getAcces() != 'membre') {
                    $adherentsMin[] = $user->getEmail();
                }
            }

            $receivers = $adherentsMin;
            $subject = 'Amicale BMW Moto 38 - Suppression d\'une réunion : '.$reuFound->getDatetimeReu()->format('d/m/Y').' - '.$reuFound->getTitre();
            $content = '<h2>Suppression de la réunion du '.$reuFound->getDatetimeReu()->format('d/m/Y').' : '.$reuFound->getTitre().'</h2>
                        <p>Bonjour, nous vous informons que la réunion a été supprimée.</p>';

            $this->sendingMails($receivers, $subject, $content);
        }

        //suppression de l'article trouvé
        $entityManager->remove($reuFound);
        $entityManager->flush();
        header('Refresh: 5; /backoffice/reunions');

        return $this->render('reunions/delConf.html.twig', [
            'reunionTrouvee' => $reuFound,
        ]);
    }

///////////////////////////////////// CR

    public function indexCr() {

        header('Refresh: 5; /reunions');
        // Récupération de la liste des réunions
            $entityManager = $this->getDoctrine()->getManager();
            // Permet de chercher les réunions via le repository
            $crFound = $entityManager->getRepository(ComptesRendus::class)->findAll();

            // foreach ($reuPass as $reu) {
            // // Vérifie si un CR existe et l'ajoute a mon tableau
            // $crFound = $entityManager->getRepository(ComptesRendus::class)->findOneBy([
            //     'reu' => $reu
            // ]);


        return $this->render('reunions/indexCr.html.twig', [
            'crTrouves' => $crFound, 
        ]);
    }

    public function viewCr($id) {
            header('Refresh: 5; /reunions');

        if($this->restrictAccess('adherent')) { return $this->redirectToRoute('accueil'); }
        
        // Récupération de la liste des réunions
            $entityManager = $this->getDoctrine()->getManager();
            // Permet de chercher les réunions via le repository
            $crFound = $entityManager->getRepository(ComptesRendus::class)->find($id);



        return $this->render('reunions/viewCr.html.twig', [
            'crTrouve' => $crFound, 
        ]);
    }

    public function addCr($id) {

        if($this->restrictAccess('bureau')) { return $this->redirectToRoute('accueil'); }

        // Récupération de la liste des réunions
            $entityManager = $this->getDoctrine()->getManager();
            // Permet de chercher les réunions via le repository
            $reuFound = $entityManager->getRepository(Reunions::class)->find($id);
            $user = $entityManager->getRepository(Utilisateurs::class)->find($this->session->get('id'));

            if(!empty($_POST)){

                $safe = array_map('trim', array_map('strip_tags', $_POST));
                
               ///////////////////////////////////////// tableau d'erreur

                $errors = [                                                      
                (!v::notEmpty()->stringType()->length(3)->validate($safe['contenu'])) ? 'Le contenu du compte rendu réunion doit faire au moins 3 caractères' : null,
                (!v::notEmpty()->stringType()->length(3, 80)->validate($safe['titre'])) ? 'Le titre du compte rendu réunion doit faire entre 3 et 80 caractères' : null,
                ];

                $errors = array_filter($errors);

                if(count($errors) == 0 ){
                       /////////////////////////////////////////// ajout bdd ////////////////////////////////////              
                    $cr = new ComptesRendus();
                    $cr->setContenu($safe['contenu'])
                        ->setTitre($safe['titre'])
                        ->setReu($reuFound)
                        //->setUser($_SESSION['user'])
                        ->setDatetimePost(new \DateTime('now'))
                        ->setUser($user);
                        
                    // tell Doctrine you want to (eventually) save the Product (no queries yet)
                    $entityManager->persist($cr);

                    // actually executes the queries (i.e. the INSERT query)
                    $entityManager->flush();
                    $success = true;
                }
                else {
                    $errorsForm = implode('<br>', $errors);
                }
            }

        return $this->render('reunions/addCr.html.twig', [
            'reunionTrouvee'    => $reuFound,
            'donnees_saisies'   => $safe ?? [],
            'success'           => $success ?? false,
            'errors'            => $errorsForm ?? [],
        ]);
    }

    public function editCr($id) {

        if($this->restrictAccess('bureau')) { return $this->redirectToRoute('accueil'); }

        // Récupération de la liste des réunions
            $entityManager = $this->getDoctrine()->getManager();
            // Permet de chercher les réunions via le repository
            $reu = $entityManager->getRepository(Reunions::class)->find($id);
            
            
            // Vérifie si un CR existe et l'ajoute a mon tableau
                $crFound = $entityManager->getRepository(ComptesRendus::class)->findOneBy([
                'reu' => $reu
                ]);

                // if(!empty($crFound)){
                //     $reuWithCr[] = $reu;
                // }
            

            // $crFound = $entityManager->getRepository(ComptesRendus::class)->find($id);

            if(!empty($_POST)){

                $safe = array_map('trim', array_map('strip_tags', $_POST));
                
               ///////////////////////////////////////// tableau d'erreur

                $errors = [                                                      
                (!v::notEmpty()->stringType()->length(3)->validate($safe['contenu'])) ? 'Le contenu du compte rendu réunion doit faire au moins 3 caractères' : null,
                (!v::notEmpty()->stringType()->length(3, 80)->validate($safe['titre'])) ? 'Le titre du compte rendu réunion doit faire entre 3 et 80 caractères' : null,
                ];

                $errors = array_filter($errors);

                if(count($errors) == 0 ){
                       ////// ajout bdd             
                   
                    $crFound->setContenu($safe['contenu'])
                        ->setTitre($safe['titre'])
                        ->setReu($reu)///********//////********////////*********
                        //->setUser($_SESSION['user'])
                        ->setDatetimeModif(new \DateTime('now'));

                    // tell Doctrine you want to (eventually) save the Product (no queries yet)
                    $entityManager->persist($crFound);

                    // actually executes the queries (i.e. the INSERT query)
                    $entityManager->flush();
                    $success = true;
                }
                else {
                    $errorsForm = implode('<br>', $errors);
                }
                //suppression de l'article trouvé
                #$entityManager->remove($reuFound);
                #$entityManager->flush();
            }

        return $this->render('reunions/editCr.html.twig', [
            'reunionTrouvee'    => $reu,
            'crTrouve'          => $crFound,
            'donnees_saisies'   => $safe ?? [],
            'success'           => $success ?? false,
            'errors'            => $errorsForm ?? [],
            //'test'              => $reu ?? []
        ]);
    }

    public function delCr($id) {

        if($this->restrictAccess('bureau')) { return $this->redirectToRoute('accueil'); }

        // Récupération de la liste des réunions
            $entityManager = $this->getDoctrine()->getManager();
            // Permet de chercher les réunions via le repository
            $crFound = $entityManager->getRepository(ComptesRendus::class)->find($id);
                //suppression de l'article trouvé
                #$entityManager->remove($reuFound);
                #$entityManager->flush();
            header('Refresh: 1; /backoffice/reunions');

        return $this->render('reunions/delCr.html.twig', [
            'crTrouve' => $crFound,
        ]);
    }

}
