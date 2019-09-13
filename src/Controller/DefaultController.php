<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends MasterController
{
    /**
     * @Route("/default", name="default")
     */
    public function index() {

        return $this->render('default/index.html.twig', [
        ]);
    }

    public function contact() {
        
        return $this->render('default/contact.html.twig', [
        ]);
    }
}
