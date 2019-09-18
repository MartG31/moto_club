<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \Respect\Validation\Validator as v;
use App\Entity\Reunions;
use App\Entity\Balades;

class DefaultController extends MasterController
{
    /**
     * @Route("/default", name="default")
     */
    public function index() {


        // SWIPER

        $em = $this->getDoctrine()->getManager();
        $nextbalade = $em->getRepository(Balades::class)->findLastNotPast(array());
        $lastbalade = $em->getRepository(Balades::class)->findLast(array());
        $reunion = $em->getRepository(Reunions::class)->findLastNotPast(array());


        // CONTACT

        $errors = [];
        
        if(!empty($_POST)){

            $safe = array_map('trim', array_map('strip_tags', $_POST));

            if(!v::stringType()->length(3, null)->validate($safe['lastname'])){
                $errors[] = 'Le nom doit comporter au moins 3 caractères';
            }

            if(!v::stringType()->length(3, null)->validate($safe['firstname'])){
                $errors[] = 'Le prénom doit comporter au moins 3 caractères';
            }

            if(!filter_var($safe['email'], FILTER_VALIDATE_EMAIL)){
                $errors[] = 'L\'adresse email est invalide';
            }

            if(!v::phone($safe['phone'])){
                $errors[] = 'Le numéro de téléphone est invalide';
            }

            if(!v::stringType()->length(30, null)->validate($safe['message'])){
                $errors[] = 'Le message doit comporter au moins 30 caractères';
            }

            if(count($errors) == 0){

                $success = true;// Envoi du mail
                $receivers = ['mathieu.webforce3@gmail.com'];
                $subject = 'Message de '.$safe['lastname'].' '.$safe['firstname'];
                $content = '<h2>'.$safe['lastname'].' '.$safe['firstname'].' via "contactez-nous"</h2>
                            <p><strong>Email :</strong> '.$safe['email'].'<br>
                            <strong>Téléphone :</strong> '.$safe['phone'].'<hr>
                            <strong>Message :</strong> '.$safe['message'].'</p>';

                $this->sendingMails($receivers, $subject, $content);
            }
        }

        
        return $this->render('default/index.html.twig', [
            'errors'     => $errors ?? [],
            'donnees_saisies' => $safe ?? [],
            'success' => $success ?? false,
            'nextbalade' => $nextbalade,
            'lastbalade' => $lastbalade,
            'reunion' => $reunion
        ]);
    }
}