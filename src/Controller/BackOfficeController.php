<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Utilisateurs;


class BackOfficeController extends MasterController
{
    /**
     * @Route("/back/office", name="back_office")
     */
    public function index() {

        if($this->restrictAccess('membre')) { return $this->redirectToRoute('accueil'); }

        return $this->render('back_office/index.html.twig', [

        ]);
    }

    public function viewUsers() {

        if($this->restrictAccess('bureau')) { return $this->redirectToRoute('admin_accueil'); }

        $entityManager = $this->getDoctrine()->getManager();


        // UPDATE DROITS USER

        if(!empty($_POST)){

            $errors = [];
            $safe = array_map('trim', array_map('strip_tags', $_POST));
            $keysafe = array_keys($safe);
            $userId = array_shift($keysafe);
            $newAcces = array_shift($safe);

            $user = $entityManager->getRepository(Utilisateurs::class)->find($userId);

            if(empty($user)){
                $errors[] = 'L\'utilisateur n\'existe pas';
            }

            if($userId == $this->session->get('id')){
                $errors[] = 'Vous ne pouvez pas changer vos propres droits';
            }

            if(count($errors) == 0 && $user->getAcces() != $newAcces){

                $user->setAcces($newAcces);
                $entityManager->flush();
                $success = true;
            }
        }

        $users = $entityManager->getRepository(Utilisateurs::class)->findBy([], ['datetimeInscription' => 'ASC']);

        $admins = [];
        $bureaux = [];
        $adherents = [];
        $membres = [];

        foreach($users as $user) {
            if($user->getAcces() == 'admin') { $admins[] = $user; }
            if($user->getAcces() == 'bureau') { $bureaux[] = $user; }
            if($user->getAcces() == 'adherent') { $adherents[] = $user; }
            if($user->getAcces() == 'membre') { $membres[] = $user; }
        }

        $sortedUsers = array_merge($admins, $bureaux, $adherents, $membres);

        return $this->render('back_office/liste-users.html.twig', [
            'nomsRanks' => $this->nomsRanks,
        	'users' => $sortedUsers ?? [],
            'errors'     => $errors ?? [],
            'success' => $success ?? false,
            'user' => $user ?? null,
        ]);
    }
}
