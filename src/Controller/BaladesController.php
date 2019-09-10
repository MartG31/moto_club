<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BaladesController extends AbstractController
{
    /**
     * @Route("/balades", name="balades")
     */
    public function indexBalades() {

    	// Affichage du calendrier des balades
    	// Affichage des dernières balades




        return $this->render('balades/index.html.twig', [

        ]);
    }

    public function viewBalade() {

    	// Affichage du détail des balades (Titre, dates, description, map)
    	// Accéder à la galerie
    	// Bouton "S'inscrire"

    	return $this->render('balades/view.html.twig', [

        ]);
    }

    public function addBalade() {

    	//

    	return $this->render('balades/add.html.twig', [

        ]);
    }

    public function editBalade() {

    	//

    	return $this->render('balades/edit.html.twig', [

        ]);
    }

    public function deleteBalade() {

    	//

    	return $this->render('balades/delete.html.twig', [

        ]);
    }


}
