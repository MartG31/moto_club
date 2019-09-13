<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface; // Connexion a la base de données
use App\Entity\Utilisateurs; // Intéractions avec la table "users"
use App\Entity\Tokens;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \Respect\Validation\Validator as v;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UsersController extends MasterController {
    /**
     * @Route("/users", name="users")
     */
    public function inscriptionUser() {

		$em = $this->getDoctrine()->getManager();
    	$errors = [];
        
    	if(!empty($_POST)){

			$safe = array_map('trim', array_map('strip_tags', $_POST));

			if(!filter_var($safe['email'], FILTER_VALIDATE_EMAIL)){
				$errors[] = 'L\'adresse email est invalide';
			}
			
			$emailExists = $this->getDoctrine()->getRepository(Utilisateurs::class)->findBy(['email' => $safe['email']]);
			if(!empty($emailExists)){
				$errors[] = 'L\'adresse email existe déjà';
			}

			if(!v::stringType()->length(8, null)->validate($safe['password'])){
				$errors[] = 'Le mot de passe doit comporter au moins 8 caractères';
			}

			if(!v::equals($safe['password'])->validate($safe['confirmpassword'])) {
				$errors[] = 'Les mots de passe ne correspondent pas';
			}

			if(!v::stringType()->length(3, null)->validate($safe['lastname'])){
				$errors[] = 'Le nom doit comporter au moins 3 caractères';
			}

			if(!v::stringType()->length(3, null)->validate($safe['firstname'])){
				$errors[] = 'Le prénom doit comporter au moins 3 caractères';
			}

			if(!v::notEmpty()->date('Y-m-d')->validate($safe['birthday'])){
				$errors[] = 'La date de naissance est invalide';
			}

			if(!v::phone($safe['phone'])){
				$errors[] = 'Le numéro de téléphone est invalide';
			}

			if(!v::stringType()->length(7, null)->validate($safe['address'])){
				$errors[] = 'La rue doit comporter au moins 7 caractères';
			}

			if(!v::postalCode('FR')->validate($safe['postal_code'])){
				$errors[] = 'Le code postal est invalide';
			}

			if(!v::stringType()->length(3, null)->validate($safe['city'])){
				$errors[] = 'La ville doit comporter au moins 3 caractères';
			}

    		if(count($errors) == 0){

    			$usersData = new Utilisateurs();
    			$usersData->setEmail($safe['email'])
							->setPwd(password_hash($safe['password'], PASSWORD_DEFAULT))
							->setNom($safe['lastname'])
							->setPrenom($safe['firstname'])
							->setTelephone($safe['phone'])
							->setDateNaiss(new \DateTime($safe['birthday']))
							->setAdresse($safe['address'])
							->setCp($safe['postal_code'])
							->setVille($safe['city'])
    						->setAcces('membre')
                            ->setDatetimeInscription(new \DateTime('now'));

    			$em->persist($usersData);
    			$em->flush();
    			$success = true;
    			header('Refresh: 1; /users/login');
    		}
    	}

        return $this->render('users/inscription.html.twig', [
        	'errors'     => $errors,
        	'donnees_saisies' => $safe ?? [],
        	'success' => $success ?? false,
        ]);
    }

    public function loginUser() {

		$em = $this->getDoctrine()->getManager();
    	$errors = [];
        
    	if(!empty($_POST)){

			$safe = array_map('trim', array_map('strip_tags', $_POST));

			if(!filter_var($safe['email'], FILTER_VALIDATE_EMAIL)){
				$errors[] = 'L\'adresse email est invalide';
			}
			
			$userExists = $this->getDoctrine()->getRepository(Utilisateurs::class)->findOneBy(['email' => $safe['email']]);
			if(!$userExists){
				$errors[] = 'L\'adresse email n\'existe pas';
			}

			if(!v::stringType()->length(8, null)->validate($safe['password'])){
				$errors[] = 'Le mot de passe doit comporter au moins 8 caractères';
			}

    		if(count($errors) == 0){

    			if(password_verify($safe['password'], $userExists->getPwd())){

    				$this->initSession($userExists);
    				$success = true;
    				header('Refresh: 1; /');
    			}

    			else{
    				$errors[] = 'Le mot de passe est incorrect';
    			}
    		}
    	}

        return $this->render('users/login.html.twig', [
        	'errors'     => $errors,
        	'donnees_saisies' => $safe ?? [],
        	'user' => $userExists ?? false,
        	'success' => $success ?? false,
        ]);
    }

    public function logoutUser() {

		session_destroy();
		return $this->redirectToRoute('accueil');
    }

    public function forgotPasswordUser() {

		$em = $this->getDoctrine()->getManager();
    	$errors = [];
        
    	if(!empty($_POST)) {

			$safe = array_map('trim', array_map('strip_tags', $_POST));
			
			$userExists = $this->getDoctrine()->getRepository(Utilisateurs::class)->findOneBy(['email' => $safe['email']]);
			if(!$userExists) {
				$errors[] = 'L\'adresse email n\'existe pas';
			}

    		if(count($errors) == 0) {

    			$token = bin2hex(random_bytes(50));
    			
    			$tok = new Tokens();
    			$tok->setUser($userExists);
    			
    			$tok->setToken($token);
    			$tok->setDatetimeToken(new \DateTime());

				$em->persist($tok);
    			$em->flush();
    			$tok->getUser()->getEmail();

				$success = true;
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
				$mail->AddAddress($safe['email']); // destinataire
				// $mail->AddAddress('truc.muche@gmail.com'); // autre destinataire
				// $mail->AddCC('machin@bidule.fr'); // copie carbone
				// $mail->AddBCC('patron@societe.com'); // copie cachée
				$mail->SetFrom('mathieu.webforce3@gmail.com', 'Amicale BMW Moto 38'); // expéditeur
				$mail->Subject = 'Récupération de Mot de passe - Amicale BMW Moto 38'; // sujet
				// le corps du mail au format HTML
				$mail->Body = '<html>
								<head>
									<style>
										h1{color: grey;}
										p{color: grey;}
									</style>
								</head>
								<body>
									<h1>Mot de passe perdu ?</h1>
									<p>Bonjour, vous avez indiqué avoir perdu votre mot de passe, veuillez cliquer sur le lien suivant pour récupérer l\'accès à votre compte.</p>
									<p><a href="http://127.0.0.1:8000/users/reinit-password?token='.$token.'">Réinitialiser mon mot de passe</a></p>
									<p>Si vous n\'êtes pas à l\'origine de cette demande, veuillez ignorer cet email. Vous pouvez continuer à utiliser votre mot de passe actuel.</p>
								</body>
							</html>';
				$mail->Send();
			}
		}

	    return $this->render('users/forgotpassword.html.twig', [
        	'errors'     => $errors ?? [],
        	'donnees_saisies' => $safe ?? [],
        	'success' => $success ?? false,
        ]);
	}

    public function reinitPasswordUser() {

    	$em = $this->getDoctrine()->getManager();
    	$errors = [];
        
    	if(!empty($_POST)){

			$safe = array_map('trim', array_map('strip_tags', $_POST));
			$tokenExists = $this->getDoctrine()->getRepository(Tokens::class)->findOneBy(['token' => $_GET['token']]);

			if(!v::stringType()->length(8, null)->validate($safe['password'])){
				$errors[] = 'Le mot de passe doit comporter au moins 8 caractères';
			}

			if(!v::equals($safe['password'])->validate($safe['confirmpassword'])) {
				$errors[] = 'Les mots de passe ne correspondent pas';
			}

    		if(count($errors) == 0){

    			$tokenExists->getUser()->setPwd(password_hash($safe['password'], PASSWORD_DEFAULT));
    			$em->persist($tokenExists);
    			$em->flush();
    			$success = true;
    			header('Refresh: 3; /users/login');
    		}
    	}
		

	    return $this->render('users/reinitpassword.html.twig', [
        	'errors'     => $errors ?? [],
        	'donnees_saisies' => $safe ?? [],
        	'success' => $success ?? false,
        ]);
    }

    public function viewProfile() {

    	if($this->restrictAccess('membre')) { return $this->redirectToRoute('accueil'); }
		

	    return $this->render('users/viewprofile.html.twig', [
        	
        ]);
    }




}
