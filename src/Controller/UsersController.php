<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface; // Connexion a la base de données
use App\Entity\Utilisateurs; // Intéractions avec la table "users"
use App\Entity\Tokens;

use \Respect\Validation\Validator as v;
use \Behat\Transliterator\Transliterator as tr;
use Intervention\Image\ImageManagerStatic as Image; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UsersController extends MasterController {
    /**
     * @Route("/users", name="users")
     */

    // ATTRIBUTS
    public $maxFileSize = 3 * 1000 * 1000;
    public $uploadDir = 'uploads/avatars/';


    // PAGES & METHODES

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
    			$success = true;// Envoi du mail
				$receivers = [$safe['email']];
				$subject = 'Bienvenue !';
				$content = '<h2>Vous venez de vous inscrire sur notre site, nous avons le plaisir de vous souhaiter la bienvenue</h2>
							<hr>
							<p>Voici un récapitulatif des informations que vous avez saisies :</p>
							<p>Nom : '.$safe['lastname'].'</p>
							<p>Prénom : '.$safe['firstname'].'</p>
							<p>Téléphone : '.$safe['phone'].'</p>
							<p>Date de naissance : '.date("d/m/Y", strtotime($safe['birthday'])).'</p>
							<p>Adresse : '.$safe['address'].', '.$safe['postal_code'].' '.$safe['city'].'</p>';

				$this->sendingMails($receivers, $subject, $content);
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

    				$this->refreshSession($userExists);
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

				// Envoi du mail
				$receivers = [$safe['email']];
				$subject = 'Récupération de Mot de passe';
				$content = '<h2>Mot de passe perdu ?</h2>
							<p>Bonjour, vous avez indiqué avoir perdu votre mot de passe, veuillez cliquer sur le lien suivant pour récupérer l\'accès à votre compte.</p>
							<p><a href="http://127.0.0.1:8000/users/reinit-password?token='.$token.'">Réinitialiser mon mot de passe</a></p>
							<p>Si vous n\'êtes pas à l\'origine de cette demande, veuillez ignorer cet email. Vous pouvez continuer à utiliser votre mot de passe actuel.</p>';

				$this->sendingMails($receivers, $subject, $content);
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

    	$em = $this->getDoctrine()->getManager();

        echo '<pre class="alert alert-info mb-0">';
        print_r($this->checkTime('55:77'));
        echo '</pre>';


        if(!empty($_POST)) {

        	// UPDATE AVATAR

        	$av_errors = [];

            // echo '<pre class="alert alert-info mb-0">';
            // print_r($_FILES);
            // // print_r($_SERVER);
            // echo '</pre>';


        	if($_POST['action'] == 'avatar-form' && !empty($_FILES)) {

        		if($_FILES['avatar']['error'] != UPLOAD_ERR_OK) {
        		    $av_errors[] = 'Une erreur est survenue lors de la sélection du fichier';
                    echo '<pre class="alert alert-danger mb-0">';
                    print_r($av_errors);
                    echo '</pre>';
        		}
        		else {

                    // Init MIME Type
                    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mimeType = finfo_file($fileInfo, $_FILES['avatar']['tmp_name']);
                    finfo_close($fileInfo);

                    if(substr($mimeType, 0, 5) != 'image') {
                        $av_errors[] = 'Type de fichier invalide. Vous devez sélectionner un fichier de type image';
                    }
                    else {
                        $img = Image::make($_FILES['avatar']['tmp_name']);

                        if($img->filesize() > $this->maxFileSize) {
                            $av_errors[] = 'La taille de votre image ne doit pas exéder 3 MB';
                        }
                    }

        			if(count($av_errors) === 0) {

        				$user = $em->getRepository(Utilisateurs::class)->find($this->session->get('id'));
        				$current_avatar = $user->getAvatar();

        				// Suppression de l'ancien avatar
        				if($current_avatar != null) {
        					unlink($this->uploadDir.$current_avatar);
        				}

        				$img->resize(500, null, function ($constraint) {
        				    $constraint->aspectRatio();
        				});

        				$path = pathinfo($_FILES['avatar']['name']);
        				$fileName = tr::transliterate(time().'-'.$path['filename']).'.'.$path['extension'];

        				// Enregistrement en bdd
        				$user->setAvatar($fileName);
        				$em->flush();

        				// Enregistrement du nouveau fichier
        				$img->save($this->uploadDir.$fileName);

        				$this->refreshSession($user);

        				$av_success = true;
        			}
        		}
        	}

        	// UPDATE INFOS

        	$errors = [];
        	
            if($_POST['action'] == 'infos-form') {

        		$post = array_map('trim', array_map('strip_tags', $_POST));

        		if(!v::stringType()->length(3, null)->validate($post['nom'])){
        			$errors[] = 'Le nom doit comporter au moins 3 caractères';
        		}

        		if(!v::stringType()->length(3, null)->validate($post['prenom'])){
        			$errors[] = 'Le prénom doit comporter au moins 3 caractères';
        		}

        		if(!v::notEmpty()->date('Y-m-d')->validate($post['date_naiss'])){
        			$errors[] = 'La date de naissance est invalide';
        		}

        		if(!v::phone($post['telephone'])){
        			$errors[] = 'Le numéro de téléphone est invalide';
        		}

        		if(!v::stringType()->length(7, null)->validate($post['adresse'])){
        			$errors[] = 'La rue doit comporter au moins 7 caractères';
        		}

        		if(!v::postalCode('FR')->validate($post['cp'])){
        			$errors[] = 'Le code postal est invalide';
        		}

        		if(!v::stringType()->length(3, null)->validate($post['ville'])){
        			$errors[] = 'La ville doit comporter au moins 3 caractères';
        		}

        		if(count($errors) === 0) {

        			$user = $em->getRepository(Utilisateurs::class)->find($this->session->get('id'));

        			$user->setPseudo($post['pseudo']);
        			$user->setNom($post['nom']);
        			$user->setPrenom($post['prenom']);
        			$user->setPseudo($post['pseudo']);
        			$user->setAdresse($post['adresse']);
        			$user->setCp($post['cp']);
        			$user->setVille($post['ville']);
        			$user->setTelephone($post['telephone']);
        			$user->setDateNaiss(new \DateTime($post['date_naiss']));

        			$em->flush();

        			$this->refreshSession($user);

        			$success = true;
        		}
        	}

            // UPDATE PWD

            $pwd_errors = [];
            
            if($_POST['action'] == 'pwd-form') {

                $post = array_map('trim', array_map('strip_tags', $_POST));

                $user = $em->getRepository(Utilisateurs::class)->find($this->session->get('id'));

                if(!password_verify($post['current_pwd'], $user->getPwd())) {
                    $pwd_errors[] = 'Votre mot de passe est incorrect';
                }
                elseif(!v::stringType()->length(8, null)->validate($post['new_pwd'])){
                    $pwd_errors[] = 'Le mot de passe doit comporter au moins 8 caractères';
                }
                elseif(!v::equals($post['new_pwd'])->validate($post['new_pwd_confirm'])) {
                    $pwd_errors[] = 'Les mots de passe ne correspondent pas';
                }

                if(count($pwd_errors) === 0) {

                    $user->setPwd(password_hash($post['new_pwd'], PASSWORD_DEFAULT));
                    $em->flush();

                    $pwd_success = true;
                }
            }
        }

	    return $this->render('users/viewprofile.html.twig', [
            'maxFileSize' => $this->maxFileSize,         
	    	'post' => $post ?? [],
    	    'av_errors' => $av_errors ?? [],
    	    'av_success' => $av_success ?? false,
            'errors' => $errors ?? [],
            'success' => $success ?? false,
            'pwd_errors' => $pwd_errors ?? [],
            'pwd_success' => $pwd_success ?? false,        	
        ]);
    }




}
