<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface; // Connexion a la base de données
use App\Entity\Utilisateurs; // Intéractions avec la table "users"
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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

			// Vérifie le bon format de mon email
			if(!filter_var($safe['email'], FILTER_VALIDATE_EMAIL)){
				$errors[] = 'L\'adresse email est invalide';
			}
			
			$emailExist = $this->getDoctrine()->getRepository(Utilisateurs::class)->findBy(['email' => $safe['email']]);
			if(!empty($emailExist)){
				$errors[] = 'L\'adresse email existe déjà';
			}

			// Vérifie que le mot de passe a au moins 8 caractères
			if(strlen($safe['password']) < 7){
				$errors[] = 'Le mot de passe doit comporter au moins 8 caractères';
			}

			// Vérifie que le mot de passe confirmé et le même que le mot de passe
			if($safe['password'] != $safe['confirmpassword']) {
				$errors[] = 'Les mots de passe ne correspondent pas';
			}

			// Aucune erreur, je sauvegarde mes données
    		if(count($errors) == 0){

    			/* $articlesData me permet d'utiliser les méthodes de la class App\Entity\Articles.php */
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
    						->setAcces(1)
                            ->setDatetimeInscription(new \DateTime('now'));

    			// On prépare la requete.
    			$em->persist($usersData);
    			// On l'exécute
    			$em->flush();
    			$success = true;
    		}
    	}

        return $this->render('users/inscription.html.twig', [
        	'errors'     => $errors,
        	'donnees_saisies' => $safe ?? [],
        	'success' => $success ?? false,
        ]);
    }
}
