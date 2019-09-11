<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface; // Connexion a la base de données
use App\Entity\Utilisateurs; // Intéractions avec la table "users"
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \Respect\Validation\Validator as v;

class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function inscriptionUser()
    {
		// Utilisation de la base de données
		$em = $this->getDoctrine()->getManager();
		// Nettoyage des données
    	$errors = [];
        
    	if(!empty($_POST)){

			$safe = array_map('trim', array_map('strip_tags', $_POST));

			if(!filter_var($safe['email'], FILTER_VALIDATE_EMAIL)){
				$errors[] = 'L\'adresse email est invalide';
			}
			
			if($this->checkEmailExists($safe['email'])){
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

    			/* $articlesData me permet d'utiliser les méthodes de la class App\Entity\Articles.php */
    			/*
    			$usersData = new Utilisateurs();
    			$usersData->setEmail($safe['email'])
							->setPwd(password_hash($safe['password'], PASSWORD_DEFAULT))
							->setNom($safe['lastname'])
							->setPrenom($safe['firstname'])
							->setTelephone($safe['phone'])
							->setDateNaiss(new \DateTime('now'))
							->setAdresse($safe['address'])
							->setCp($safe['postal_code'])
							->setVille($safe['city'])
    						->setAcces(1)
                            ->setDatetimeInscription(new \DateTime('now'));

    			// On prépare la requete.
    			$em->persist($usersData);
    			// On l'exécute
    			$em->flush();*/
    			$success = true;
    		}
    	}

        return $this->render('users/inscription.html.twig', [
        	'errors'     => $errors,
        	'donnees_saisies' => $safe ?? [],
        	'success' => $success ?? false,
        ]);
    }



    /**
     * Vérifie l'existence d'une adresse email
     * @param string $email L'email à vérifier
     * @return boolean true si l'email existe, false sinon
     */
    public function checkEmailExists($email){

    	$exist = $this->getDoctrine()
    		->getRepository(Utilisateurs::class)
	    	->findOneBy(['email' => $email]);


	    return ($exist) ? true : false;
    }
}
