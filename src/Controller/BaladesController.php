<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BaladesController extends AbstractController
{
    /**
     * @Route("/balades", name="balades")
     */
    public function index()
    {
        return $this->render('balades/index.html.twig', [
            'controller_name' => 'BaladesController',
        ]);
    }
}
