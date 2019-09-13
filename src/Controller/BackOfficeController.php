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
    public function index()
    {
        return $this->render('back_office/index.html.twig', [

            'controller_name' => 'BackOfficeController',
        ]);
    }

    public function viewUsers()
    {
        // Si pas accès < bureau : redirection
        if($this->restrictAccess('bureau')) { return $this->redirectToRoute('accueil'); }

    	// Récupération la liste des utilisateurs
            $entityManager = $this->getDoctrine()->getManager();
            // Permet de chercher la liste via le repository
            $users = $entityManager->getRepository(Utilisateurs::class)->findAll();

        return $this->render('back_office/liste-users.html.twig', [
        	'users' => $users ?? [],
        ]);
    }
}
