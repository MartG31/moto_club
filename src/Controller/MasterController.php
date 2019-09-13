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

        echo '<pre class="alert alert-info mb-0">';
        print_r('user id : '.$this->session->get('id').' ('.$this->session->get('email').') / RANG : '.$this->session->get('acces'));
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

        echo '<pre class="alert alert-danger mb-0">';
        print_r('Accès réservé : '.$niv);
        echo '</pre>';

        if(!in_array($niv, $this->session->get('ranks'))) {
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