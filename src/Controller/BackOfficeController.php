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
        // Si pas accès < bureau : redirection
        if($this->restrictAccess('bureau')) { return $this->redirectToRoute('admin_accueil'); }
        // Récupération la liste des utilisateurs
        $entityManager = $this->getDoctrine()->getManager();
        // Permet de chercher la liste via le repository

        // echo '<pre class="alert alert-info mb-0">';
        // print_r($_POST);
        // echo '</pre>';

        if(!empty($_POST)){

            $errors = [];
            $safe = array_map('trim', array_map('strip_tags', $_POST));
            $keysafe = array_keys($safe);
            $userId = array_shift($keysafe);
            $newAcces = array_shift($safe);

        // echo '<pre class="alert alert-info mb-0">';
        // print_r($userId);
        // print_r($newAcces);
        // echo '</pre>';

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

        $users = $entityManager->getRepository(Utilisateurs::class)->findAll();

        return $this->render('back_office/liste-users.html.twig', [
            'nomsRanks' => $this->nomsRanks,
        	'users' => $users ?? [],
            'errors'     => $errors ?? [],
            'success' => $success ?? false,
            'user' => $user ?? null,
        ]);
    }
}
