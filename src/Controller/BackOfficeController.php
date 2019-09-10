<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Utilisateurs;


class BackOfficeController extends AbstractController
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
    	// Récupération la liste des utilisateurs
            $entityManager = $this->getDoctrine()->getManager();
            // Permet de chercher la liste via le repository
            $adhFound = $entityManager->getRepository(Utilisateurs::class)->findAll();

        return $this->render('back_office/liste.html.twig', [
        	'adherentsTrouves' => $adhFound, 
            'controller_name' => 'BackOfficeController',
        ]);
    }
}
