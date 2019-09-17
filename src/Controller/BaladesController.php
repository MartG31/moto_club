<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Utilisateurs;
use App\Entity\Balades;
use App\Entity\MembresBalades;

use \Respect\Validation\Validator as v;

class BaladesController extends MasterController
{

    /**
     * @Route("/balades", name="balades")
     */

    public function indexBalades() {


    	// Affichage du calendrier des balades


    	// Affichage des dernières balades

        $em = $this->getDoctrine()->getManager();
        $balades = $em->getRepository(Balades::class)->findBy(array(), array('dateDebut' => 'DESC'));

        return $this->render('balades/index.html.twig', [
            'balades' => $balades ?? [],

        ]);
    }

    public function addBalade() {

        if($this->restrictAccess('adherent')) { return $this->redirectToRoute('accueil'); }

        $em = $this->getDoctrine()->getManager();
    	$errors = [];

        if(!empty($_POST)) {

            $post = array_map('trim', array_map('strip_tags', $_POST));


            if(!v::notEmpty()->length(3,30)->validate($post['titre'])) {
                $errors[] = 'Le titre doit comporter entre 3 et 30 caractères';
            }

            if(!v::notEmpty()->length(10,1000)->validate($post['contenu'])) {
                $errors[] = 'Le contenu doit comporter entre 10 et 1000 caractères';
            }

            // DATE DEBUT & FIN

            if(!v::notEmpty()->validate($post['date_debut'])) {
                $errors[] = 'La date de début doit être renseignée';   
            }
            elseif(!v::date('Y-m-d')->validate($post['date_debut'])) {
                $errors[] = 'La date de début est invalide';
            }

            if(!v::notEmpty()->validate($post['date_fin'])) {
                $errors[] = 'La date de fin doit être renseignée';   
            }
            elseif(!v::date('Y-m-d')->validate($post['date_fin'])) {
                $errors[] = 'La date de fin est invalide';
            }

            if($post['date_debut'] > $post['date_fin']) {
                $errors[] = 'La date de début doit être antérieure à la date de fin';
            }

            // NOMBRE PARTICIPANTS

            if($post['nb_max_pers'] != '' && !v::positive()->validate($post['nb_max_pers'])) {
                $errors[] = 'Le nombre de participants doit impérativement être un nombre entier positif';
            }

            // GPS
            // ???

            if(count($errors) === 0) {

                $user = $em->getRepository(Utilisateurs::class)->find($this->session->get('id'));

                $balade = new Balades();
                $balade->setUser($user);

                $balade->setTitre($post['titre']);
                $balade->setContenu($post['contenu']);
                $balade->setDateDebut(new \DateTime($post['date_debut']));
                $balade->setDateFin(new \DateTime($post['date_fin']));
                $balade->setDatetimePost(new \DateTime());

                if(v::notEmpty()->validate($post['nb_max_pers'])) {
                    $balade->setNbMaxPers($post['nb_max_pers']);
                }
                else {
                    $balade->setNbMaxPers(null);                    
                }

                if(in_array('bureau', $this->session->get('ranks'))) {
                    $balade->setBalActive(true);
                    $balade->setInscActive(true);
                }
                else {
                    $balade->setBalActive(false);
                    $balade->setInscActive(false);
                }

                $em->persist($balade);
                $em->flush();

                $success = true;
                $post = [];
            }

        }

    	return $this->render('balades/add.html.twig', [
            'post' => $post ?? [],
            'errors' => $errors ?? '',
            'success' => $success ?? false,
        ]);
    }

    public function editBalade($id) {

    	if($this->restrictAccess('bureau')) { return $this->redirectToRoute('accueil'); }

        $em = $this->getDoctrine()->getManager();
        $balade = $em->getRepository(Balades::class)->find($id);

        $errors = [];

        if(!empty($_POST)) {

            $post = array_map('trim', array_map('strip_tags', $_POST));


            if(!v::notEmpty()->length(3,30)->validate($post['titre'])) {
                $errors[] = 'Le titre doit comporter entre 3 et 30 caractères';
            }

            if(!v::notEmpty()->length(10,1000)->validate($post['contenu'])) {
                $errors[] = 'Le contenu doit comporter entre 10 et 1000 caractères';
            }

            // DATE DEBUT & FIN

            if(!v::notEmpty()->validate($post['date_debut'])) {
                $errors[] = 'La date de début doit être renseignée';   
            }
            elseif(!v::date('Y-m-d')->validate($post['date_debut'])) {
                $errors[] = 'La date de début est invalide';
            }

            if(!v::notEmpty()->validate($post['date_fin'])) {
                $errors[] = 'La date de fin doit être renseignée';   
            }
            elseif(!v::date('Y-m-d')->validate($post['date_fin'])) {
                $errors[] = 'La date de fin est invalide';
            }

            if($post['date_debut'] > $post['date_fin']) {
                $errors[] = 'La date de début doit être antérieure à la date de fin';
            }

            // NOMBRE PARTICIPANTS

            if($post['nb_max_pers'] != '' && !v::positive()->validate($post['nb_max_pers'])) {
                $errors[] = 'Le nombre de participants doit impérativement être un nombre entier positif';
            }

            // GPS
            // ???

            if(count($errors) === 0) {

                $user = $em->getRepository(Utilisateurs::class)->find($this->session->get('id'));

                $balade->setTitre($post['titre']);
                $balade->setContenu($post['contenu']);
                $balade->setDateDebut(new \DateTime($post['date_debut']));
                $balade->setDateFin(new \DateTime($post['date_fin']));
                $balade->setDatetimeModif(new \DateTime());

                if(v::notEmpty()->validate($post['nb_max_pers'])) {
                    $balade->setNbMaxPers($post['nb_max_pers']);
                }
                else {
                    $balade->setNbMaxPers(null);                    
                }

                // $em->persist($balade);
                $em->flush();

                $success = true;
                $post = [];
            }

        }

    	return $this->render('balades/edit.html.twig', [
            'balade' => $balade ?? [],
            'post' => $post ?? [],
            'errors' => $errors ?? '',
            'success' => $success ?? false,

        ]);
    }

    public function delBalade($id) {

    	if($this->restrictAccess('adherent')) { return $this->redirectToRoute('accueil'); }

        $em = $this->getDoctrine()->getManager();
        $balade = $em->getRepository(Balades::class)->find($id);

        echo $balade->getTitre();
        die;

    	return $this->render('balades/delete.html.twig', [

        ]);
    }

    public function viewBalade($id) {

        // Affichage du détail des balades (Titre, dates, description, map)
        // Accéder à la galerie
        // Bouton "S'inscrire"

        $em = $this->getDoctrine()->getManager();
        $balade = $em->getRepository(Balades::class)->find($id);

        


        return $this->render('balades/view.html.twig', [
            'balade' => $balade ?? [],
            'inscrit' => $this->inscrit($balade) ?? false,
            'nbMaxPers' => $balade->getNbMaxPers(),
            'nbInscrits' => $this->nbInscrits($balade),
            'baladeFull' => $this->baladeFull($balade) ?? false,

        ]);
    }

    public function inscriptionBalade($id) {

        if($this->restrictAccess('membre')) { return $this->redirectToRoute('accueil'); }

        $em = $this->getDoctrine()->getManager();
        $balade = $em->getRepository(Balades::class)->find($id);
        $user = $em->getRepository(Utilisateurs::class)->find($this->session->get('id'));

        if(!$this->inscrit($balade) && !$this->baladeFull($balade)) {

            $mb = new MembresBalades();
            $mb->setBal($balade);
            $mb->setUser($user);

            $em->persist($mb);
            $em->flush();
        }

        return $this->redirectToRoute('view_balade', [
            'id' => $balade->getId()
        ]);
    }

    public function desinscriptionBalade($id) {

        if($this->restrictAccess('membre')) { return $this->redirectToRoute('accueil'); }

        $em = $this->getDoctrine()->getManager();
        $balade = $em->getRepository(Balades::class)->find($id);
        $user = $em->getRepository(Utilisateurs::class)->find($this->session->get('id'));

        if($this->inscrit($balade)) {

            $mb = $em->getRepository(MembresBalades::class)->findOneBy([
                'bal' => $balade,
                'user' => $user,
            ]);

            $em->remove($mb);
            $em->flush();
        }

        return $this->redirectToRoute('view_balade', [
            'id' => $balade->getId()
        ]);
    }


    public function gestionBalades() {

        if($this->restrictAccess('bureau')) { return $this->redirectToRoute('accueil'); }

        $em = $this->getDoctrine()->getManager();
        $balades = $em->getRepository(Balades::class)->findBy(array(), array('dateDebut' => 'DESC'));

        $bal_datas = [];
        foreach ($balades as $balade) {
            $bal_datas[] = array(
                'balade' => $balade,
                'nbInscrits' => $this->nbInscrits($balade),
                'baladeFull' => $this->baladeFull($balade) ?? false,
            );
        }


        return $this->render('balades/gestion-balades.html.twig', [
            'bal_datas' => $bal_datas ?? [],            
        ]);
    }

    public function gestionInscrits($id) {

        if($this->restrictAccess('bureau')) { return $this->redirectToRoute('accueil'); }

        $em = $this->getDoctrine()->getManager();
        $balade = $em->getRepository(Balades::class)->find($id);
        $inscrits = $em->getRepository(MembresBalades::class)->findBy([
            'bal' => $balade
        ]);

        return $this->render('balades/gestion-inscrits.html.twig', [
            'balade' => $balade,
            'inscrits' => $inscrits,
        ]);
    }

    public function validerBalade($id) {

        if($this->restrictAccess('bureau')) { return $this->redirectToRoute('accueil'); }

        $em = $this->getDoctrine()->getManager();
        $balade = $em->getRepository(Balades::class)->find($id);
        $balade->setBalActive(true);
        $balade->setInscActive(true);
        $em->flush();

        // Envoi du mail
        $users = $em->getRepository(Utilisateurs::class)->findAll();
        $adherentsMin = [];
        foreach ($users as $user) {
            if($user->getAcces() != 'membre') {
                $adherentsMin[] = $user->getEmail();
            }
        }
        // $receivers = $adherentsMin;
        // $subject = 'Amicale BMW Moto 38 - Nouvelle balade : '.$balade->getTitre().' le '.date("d/m/Y", strtotime($balade->getDateDebut());
        // $content = '<h2>Nouvelle balade, "'.$balade->getTitre().'" le '.date("d/m/Y", strtotime($balade->getDateDebut()).' : ''</h2>
        //             <p>Bonjour, nous vous informons qu\'une réunion a été ajoutée sur le site de l\'Amicale BMW Moto 38.</p>
        //             <p>Cette réunion ('.$safe['type'].') a pour sujet <strong>"'.$safe['titre'].'"</strong> et se déroulera le <strong>'.date("d/m/Y", strtotime($safe['date_reu'])).'</strong> à <strong>'.$safe['lieu'].'</strong></p>
        //             <p>Vous pouvez consulter les <a href="http://127.0.0.1:8000/reunions/details/'.$reunion->getId().'">détails</a> de cette réunion.';

        // $this->sendingMails($receivers, $subject, $content);

        return $this->redirectToRoute('gestion_balades');
    }

    public function refuserBalade($id) {

        if($this->restrictAccess('bureau')) { return $this->redirectToRoute('accueil'); }

        $em = $this->getDoctrine()->getManager();
        $balade = $em->getRepository(Balades::class)->find($id);
        // $em->remove($balade);
        // $em->flush();

        return $this->redirectToRoute('gestion_balades');
    }

    public function cloturerInscriptions($id) {

        if($this->restrictAccess('bureau')) { return $this->redirectToRoute('accueil'); }

        $em = $this->getDoctrine()->getManager();
        $balade = $em->getRepository(Balades::class)->find($id);
        $balade->setInscActive(false);
        $em->flush();

        return $this->redirectToRoute('gestion_balades');
    }

    public function ouvrirInscriptions($id) {

        if($this->restrictAccess('bureau')) { return $this->redirectToRoute('accueil'); }

        $em = $this->getDoctrine()->getManager();
        $balade = $em->getRepository(Balades::class)->find($id);
        $balade->setInscActive(true);
        $em->flush();

        return $this->redirectToRoute('gestion_balades');
    }





    // PRIVATE FUNCTIONS

    private function inscrit(Balades $balade) {

        $em = $this->getDoctrine()->getManager();
        $inscrits = $em->getRepository(MembresBalades::class)->findBy([
            'bal' => $balade
        ]);

        foreach ($inscrits as $inscrit) {
            if($inscrit->getUser()->getId() == $this->session->get('id')) { return true; }
        }
    }

    private function nbInscrits(Balades $balade) {

        $em = $this->getDoctrine()->getManager();
        $nb_inscrits_tab = $em->getRepository(MembresBalades::class)->countInscrits($balade);
        return array_shift($nb_inscrits_tab);    
    }

    private function baladeFull(Balades $balade) {

        $em = $this->getDoctrine()->getManager();
        if($this->nbInscrits($balade) == $balade->getNbMaxPers()) {
            return true;
        }
    }


}
