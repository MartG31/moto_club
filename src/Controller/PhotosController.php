<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

// use App\Controller\MasterController;
use App\Entity\Utilisateurs;
use App\Entity\Balades;
use App\Entity\Photos;

class PhotosController extends MasterController
{
    /**
     * @Route("/photos", name="photos")
     */
    public function indexPhotos()
    {
        return $this->render('photos/index.html.twig', [

        ]);
    }

    public function addPhoto() {

    	$errors = [];

        $em = $this->getDoctrine()->getManager();

        if(!empty($_FILES)) {
        	$success = true;
        }
        else {
        	$errors[] = 'error $_FILES empty';
        }

    	return $this->render('photos/add.html.twig', [
            'post' => $post ?? [],
            'errors' => $errors ?? '',
            'success' => $success ?? false,
        ]);
    }
}
