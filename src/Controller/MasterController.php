<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MasterController extends AbstractController
{
    // ATTRIBUTS

    public $session;
    public $ranks = array('admin', 'bureau', 'adherent', 'membre');
    public $nomsRanks = array(
        'admin' => 'Administrateur / Développeur(se)', 
        'bureau' => 'Membre du bureau', 
        'adherent' => 'Adhérent(e) de l\'association', 
        'membre' => 'Membre du site', 
    );


    // CONSTRUCTEUR

    public function __construct() {

        $this->session = new Session();

        setlocale(LC_TIME, 'fr_FR.utf8','fra'); 

        // echo '<pre class="alert alert-info mb-0">';
        // print_r('user id : '.$this->session->get('id').' ('.$this->session->get('email').') / RANG : '.$this->session->get('acces'));
        // echo '</pre>';
    
    }

    // GESTION DES ACCES

    protected function refreshSession($user) {

        $userRanks = [];
        $rankFound = false;
        foreach ($this->ranks as $rank) {
            if($user->getAcces() == $rank) { $rankFound = true; }
            if($rankFound) { $userRanks[] = $rank; }
        }

        $this->session->set('id', $user->getId());
        $this->session->set('email', $user->getEmail());
        $this->session->set('acces', $this->nomsRanks[$user->getAcces()]);
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

        // echo '<pre class="alert alert-danger mb-0">';
        // print_r('Accès réservé : '.$niv);
        // echo '</pre>';

        if($this->session->get('ranks') === null) {
            return true;
        }

        if(!in_array($niv, $this->session->get('ranks'))) {
            return true;
        }

    }

    // FONCTIONS MUTUALISEES

    protected function sendingMails(array $receivers, $subject, $content) {

        $mail = new PHPMailer;
        $mail->SMTPOptions = ['ssl' => ['verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true]];
        // $mail->SMTPDebug = 3; // mode debug si > 2
        $mail->CharSet = 'UTF-8'; // charset utf-8
        $mail->isSMTP(); // connexion directe à un serveur SMTP
        $mail->isHTML(true); // mail au format HTML
        $mail->Host = 'smtp.gmail.com'; // serveur SMTP
        $mail->SMTPAuth = true; // serveur sécurisé
        $mail->Port = 465; // port utilisé par le serveur
        $mail->SMTPSecure = 'ssl'; // certificat SSL
        $mail->Username = 'mathieu.webforce3@gmail.com'; // login
        $mail->Password = 'AbC123456789'; // mot de passe

        foreach ($receivers as $receiver) {

            $mail->AddAddress($receiver); // destinataires
        }

        // $mail->AddAddress('truc.muche@gmail.com'); // autre destinataire
        // $mail->AddCC('machin@bidule.fr'); // copie carbone
        // $mail->AddBCC('patron@societe.com'); // copie cachée
        $mail->SetFrom('mathieu.webforce3@gmail.com', 'Amicale BMW Moto 38'); // expéditeur
        $mail->Subject = $subject; // sujet
        // le corps du mail au format HTML
        $mail->Body = '<html>
                        <head>
                            <style>
                                h2{
                                    color: grey;
                                }
                                p{
                                    color: grey;
                                }
                            </style>
                        </head>
                        <body>
                        '.nl2br($content).'
                        <hr>
                        <a href="http://127.0.0.1:8000/"><img src="https://i.imgur.com/ybBVpp5.png"></a>
                        <p>L\'Amicale BMW Moto 38</p>
                        </body>
                    </html>';

        $mail->Send();

    }

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

    protected function checkTime(string $time){
        $exp_time = explode(':', $time);
        if(($exp_time[0] > 23 || $exp_time[0] < 0) && ($exp_time[1] > 59 || $exp_time[1] < 00)){
            return false;
        }
        else {
            return true;
        }
    }


}