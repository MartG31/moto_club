<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
        return $this->render('back_office/tables.html.twig', [
            'controller_name' => 'BackOfficeController',
        ]);
    }
}
