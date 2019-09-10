<?php

namespace App\Controller;

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
		$safe = array_map('trim', array_map('strip_tags', $_POST));
    	$errors = [];
        $emailExist = $this->getDoctrine()->getRepository(Users::class)->findBy(['email' => $safe['email']]);

    	if(!empty($_POST)){

			// Vérifie le bon format de mon email
			if(!filter_var($safe['email'], FILTER_VALIDATE_EMAIL)){
				$errors[] = 'L\'adresse email est invalide';
			}

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
    			$usersData = new Users();
    			$usersData->setEmail($safe['email'])
							 ->setPassword(password_hash($safe['password'], PASSWORD_DEFAULT))
    						 ->setRoles('User');

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
