<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Reunions;

class ReunionsController extends AbstractController
{
    /**
     * @Route("/reunions", name="reunions")
     */
    public function indexReunion()
    
    {
    	// Récupération de la liste des réunions
            $entityManager = $this->getDoctrine()->getManager();
            // Permet de chercher les réunions via le repository
            $reuFound = $entityManager->getRepository(Reunions::class)->findAll();

        return $this->render('reunions/index.html.twig', [
            'controller_name' => 'ReunionController',
            'reunionsTrouvees' => $reuFound, 
        ]);
    }

    public function viewReunion()
    
    {
    	// Récupération de la liste des réunions
            $entityManager = $this->getDoctrine()->getManager();
            // Permet de chercher les réunions via le repository
            #là, c'est un find(), et il faut aller chercher l'id.
            $reuFound = $entityManager->getRepository(Reunions::class)->findAll();


        return $this->render('reunions/viewReu.html.twig', [
            'controller_name' => 'ReunionController',
            'reunionTrouvee' => $reuFound, 
        ]);
    }

    public function addReunion()
    
    {

        return $this->render('reunions/addReu.html.twig', [
            'controller_name' => 'ReunionController',
        ]);
    }

    public function editReunion()
    
    {
    	// Récupération de la liste des réunions
            $entityManager = $this->getDoctrine()->getManager();
            // Permet de chercher les réunions via le repository
            #là, c'est un find(), et il faut aller chercher l'id.
            $reuFound = $entityManager->getRepository(Reunions::class)->findAll();

        return $this->render('reunions/editReu.html.twig', [
            'controller_name' => 'ReunionController',
            'reunionTrouvee' => $reuFound,
        ]);
    }

    public function delReunion()
    
    {

        return $this->render('reunions/delReu.html.twig', [
            'controller_name' => 'ReunionController',
        ]);
    }


}
