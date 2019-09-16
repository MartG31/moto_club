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
        $balades = $em->getRepository(Balades::class)->findAll();

        return $this->render('balades/index.html.twig', [
            'balades' => $balades ?? [],

        ]);
    }

    public function addBalade() {

        if($this->restrictAccess('adherent')) { return $this->redirectToRoute('accueil'); }

    	$errors = [];

        $em = $this->getDoctrine()->getManager();

        if(!empty($_POST)) {

            $post = array_map('trim', array_map('strip_tags', $_POST));


            echo '<pre>';
            // var_dump($post);
            echo '</pre>';

            if(!v::notEmpty()->length(3,30)->validate($post['titre'])) {
                $errors[] = 'Le titre doit comporter entre 3 et 30 caractères';
            }

            if(!v::notEmpty()->length(10,1000)->validate($post['titre'])) {
                $errors[] = 'Le titre doit comporter entre 10 et 1000 caractères';
            }

            // DATE DEBUT & FIN

            if(!v::notEmpty()->validate($post['date_debut'])) {
                $errors[] = 'La date de début doit être renseignée';   
            }
            elseif(!v::date('Y-m-d')->validate($post['date_debut'])) {
                $errors[] = 'La date de début est invalide';
            }
            elseif(!$this->checkEnglishDate($post['date_debut'])) {
                $errors[] = 'La date de début n\'existe pas';
            }

            if(!v::notEmpty()->validate($post['date_fin'])) {
                $errors[] = 'La date de fin doit être renseignée';   
            }
            elseif(!v::date('Y-m-d')->validate($post['date_fin'])) {
                $errors[] = 'La date de fin est invalide';
            }
            elseif(!$this->checkEnglishDate($post['date_fin'])) {
                $errors[] = 'La date de fin n\'existe pas';
            }

            if($post['date_debut'] > $post['date_fin']) {
                $errors[] = 'La date de début doit être antérieure à la date de fin';
            }

            // RENDEZ-VOUS

            // if(!v::notEmpty()->validate($post['adresse_rdv'])) {
            //     $errors[] = 'L\'adresse du rendez-vous doit être renseignée';
            // }

            // if(!v::notEmpty()->postalCode('FR')->validate($post['cp_rdv'])) {
            //     $errors[] = 'Le code postal du rendez-vous est invalide ou n\'a pas été correctement renseignée';
            // }

            // if(!v::notEmpty()->validate($post['ville_rdv'])) {
            //     $errors[] = 'La ville du rendez-vous doit être renseignée';
            // }

            // GPS
            // ???

            if(count($errors) === 0) {

                $user = $em->getRepository(Utilisateurs::class)->find(1);

                $bal = new Balades();
                $bal->setUser($user);

                $bal->setTitre($post['titre']);
                $bal->setContenu($post['contenu']);
                $bal->setDateDebut(new \DateTime($post['date_debut']));
                $bal->setDateFin(new \DateTime($post['date_fin']));
                $bal->setDatetimeRdv($this->mergeDateTime($post['date_rdv'], $post['time_rdv']));
                $bal->setAdresseRdv($post['adresse_rdv']);
                $bal->setCpRdv($post['cp_rdv']);
                $bal->setVilleRdv($post['ville_rdv']);
                // $bal->setFileGps($post['file_gps']);
                $bal->setDatetimePost(new \DateTime());
                // $bal->setDatetimeModif(new \DateTime());

                $em->persist($bal);
                $em->flush();

                $success = true;
            }

        }

    	return $this->render('balades/add.html.twig', [
            'post' => $post ?? [],
            'errors' => $errors ?? '',
            'success' => $success ?? false,
        ]);
    }

    public function editBalade() {

    	if($this->restrictAccess('adherent')) { return $this->redirectToRoute('accueil'); }

    	return $this->render('balades/edit.html.twig', [

        ]);
    }

    public function deleteBalade() {

    	if($this->restrictAccess('adherent')) { return $this->redirectToRoute('accueil'); }

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
        $balades = $em->getRepository(Balades::class)->findAll();

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
        // Envoi du mail
        $users = $this->getDoctrine()->getRepository(Utilisateurs::class)->findAll();
        $balade = $em->getRepository(Balades::class)->find($id);
        $adherentsMin = [];
        foreach ($users as $user) {
            if($user->getAcces() != 'membre') {
                $adherentsMin[] = $user->getEmail();
            }
        }
        $receivers = $adherentsMin;
        $subject = 'Amicale BMW Moto 38 - Nouvelle balade : '.$balade->getTitre().' le '.date("d/m/Y", strtotime($balade->getDateDebut()));
        $content = '<h2>Nouvelle balade, "'.$balade->getTitre().'" le '.date("d/m/Y", strtotime($balade->getDateDebut()).' : ''</h2>
                    <p>Bonjour, nous vous informons qu\'une réunion a été ajoutée sur le site de l\'Amicale BMW Moto 38.</p>
                    <p>Cette réunion ('.$safe['type'].') a pour sujet <strong>"'.$safe['titre'].'"</strong> et se déroulera le <strong>'.date("d/m/Y", strtotime($safe['date_reu'])).'</strong> à <strong>'.$safe['lieu'].'</strong></p>
                    <p>Vous pouvez consulter les <a href="http://127.0.0.1:8000/reunions/details/'.$reunion->getId().'">détails</a> de cette réunion.';

        $this->sendingMails($receivers, $subject, $content);

        return $this->render('balades/gestion-inscrits.html.twig', [
        ]);
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
