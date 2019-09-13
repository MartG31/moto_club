<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface; // Connexion a la base de données
use App\Entity\Utilisateurs; // Intéractions avec la table "users"
use App\Entity\Tokens;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \Respect\Validation\Validator as v;

class UsersController extends MasterController {
    /**
     * @Route("/users", name="users")
     */
    public function inscriptionUser() {
		// Utilisation de la base de données
		$em = $this->getDoctrine()->getManager();
		// Nettoyage des données
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

    			// On prépare la requete.
    			$em->persist($usersData);
    			// On l'exécute
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
		// Utilisation de la base de données
		$em = $this->getDoctrine()->getManager();
		// Nettoyage des données
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

    				$this->session->set('id', $userExists->getId());
    				$this->session->set('email', $userExists->getEmail());
    				$this->session->set('acces', $userExists->getAcces());
    				$this->session->set('rank', $this->rank[$userExists->getAcces()]);
    				$this->session->set('pseudo', $userExists->getPseudo());
    				$this->session->set('nom', $userExists->getNom());
    				$this->session->set('prenom', $userExists->getPrenom());
    				$this->session->set('avatar', $userExists->getAvatar());
    				$this->session->set('datetime_inscription', $userExists->getDatetimeInscription());
    				$this->session->set('datetime_adhesion', $userExists->getDatetimeAdhesion());
    				$this->session->set('adresse', $userExists->getAdresse());
    				$this->session->set('cp', $userExists->getCp());
    				$this->session->set('ville', $userExists->getVille());
    				$this->session->set('telephone', $userExists->getTelephone());
    				$this->session->set('date_naiss', $userExists->getDateNaiss());

    				session_regenerate_id();
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
		// Utilisation de la base de données
		$em = $this->getDoctrine()->getManager();
		// Nettoyage des données
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
    			$tok->setDatetimeToken(new \DateTime())

				$em->persist($tok);
    			$em->flush();
    			$tok->getUser()->getEmail();
			    
			}
		}

	    return $this->render('users/forgotpassword.html.twig', [
        	'errors'     => $errors ?? [],
        	'donnees_saisies' => $safe ?? [],
        	'success' => $success ?? false,
        ]);
	}

    public function reinitPasswordUser() {
		

	    return $this->render('users/reinitpassword.html.twig', [
        	'errors'     => $errors ?? [],
        	'donnees_saisies' => $safe ?? [],
        	'success' => $success ?? false,
        ]);
    }

    public function viewProfile() {
		

	    return $this->render('users/viewprofile.html.twig', [
        	
        ]);
    }




}
