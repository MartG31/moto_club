<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class MasterController extends AbstractController
{
    // ATTRIBUTS MUTUALISES

    public $session;

    public $rank = array(
        'membre' => 1,
        'adherent' => 2,
        'bureau' => 3,
        'admin' => 4,
    );


    // CONSTRUCTEUR

    public function __construct() {

        $this->session = new Session();

        // Ajout des variables _session, _post, et _get a twig
        // $loader = new \Twig\Loader\FilesystemLoader();
        // $this->twig = new \Twig\Environment($loader);

        // $this->twig->addGlobal('_session', $_SESSION);
        // $this->twig->addGlobal('_post', $_POST);
        // $this->twig->addGlobal('_get', $_GET);
        
        // echo '<pre>';
        // print_r($_SESSION);
        // var_dump($this->twig->getGlobals());
        // echo '</pre>';

        // echo '<pre>';
        // print_r($this->session);
        // echo '</pre>';
    

    }

    // GESTION DES ACCES

    protected function niveauAcces($niv) {
        
    }

    // FONCTIONS MUTUALISEES

    protected function checkEnglishDate(string $date) {
        $exp = explode('-', $date);
        return checkdate($exp[1], $exp[2], $exp[0]);
    }

    protected function mergeDateTime(string $date, string $time) {
    	$exp_date = explode('-', $date);
    	$exp_time = explode(':', $time);

    	$dt = new \DateTime();
    	$dt->setDate($exp_date[0], $exp_date[1], $exp_date[2]);
    	$dt->setTime($exp_time[0], $exp_time[1]);

    	return $dt;
    }
}