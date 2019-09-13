<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class MasterController extends AbstractController
{
    // ATTRIBUTS

    public $session;
    public $ranks = array('admin', 'bureau', 'adherent', 'membre');


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

        echo '<pre class="alert alert-info">';
        print_r('user id : '.$this->session->get('id').' ('.$this->session->get('email').')');
        echo '<br>';
        print_r($this->session->get('ranks'));
        echo '</pre>';
    

    }

    // GESTION DES ACCES

    protected function initSession($user) {

        $userRanks = [];
        $rankFound = false;
        foreach ($this->ranks as $rank) {
            if($user->getAcces() == $rank) { $rankFound = true; }
            if($rankFound) { $userRanks[] = $rank; }
        }

        $this->session->set('id', $user->getId());
        $this->session->set('email', $user->getEmail());
        $this->session->set('acces', $user->getAcces());
        $this->session->set('ranks', $userRanks);
        $this->session->set('pseudo', $user->getPseudo());
        $this->session->set('nom', $user->getNom());
        $this->session->set('prenom', $user->getPrenom());
        $this->session->set('avatar', $user->getAvatar());
        $this->session->set('datetime_inscription', $user->getDatetimeInscription());
        $this->session->set('datetime_adhesion', $user->getDatetimeAdhesion());
        $this->session->set('adresse', $user->getAdresse());
        $this->session->set('cp', $user->getCp());
        $this->session->set('ville', $user->getVille());
        $this->session->set('telephone', $user->getTelephone());
        $this->session->set('date_naiss', $user->getDateNaiss());
    }

    protected function restrictAccess($niv) {

        echo '<pre class="alert alert-danger">';
        print_r($niv);
        echo '<br>';
        print_r(!in_array($niv, $this->session->get('ranks')));
        echo '<br>';
        ;

        if(!in_array($niv, $this->session->get('ranks'))) {
            print_r('in if');
            echo '</pre>';
            return true;
        }  

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