<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Utilisateurs;
use App\Entity\Balades;

use \Respect\Validation\Validator as v;

class BaladesController extends AbstractController
{
    /**
     * @Route("/balades", name="balades")
     */
    public function indexBalades() {

    	// Affichage du calendrier des balades
    	// Affichage des dernières balades




        return $this->render('balades/index.html.twig', [

        ]);
    }

    public function viewBalade() {

    	// Affichage du détail des balades (Titre, dates, description, map)
    	// Accéder à la galerie
    	// Bouton "S'inscrire"

    	return $this->render('balades/view.html.twig', [

        ]);
    }

    public function addBalade() {

    	$errors = [];

        $em = $this->getDoctrine()->getManager();

        if(!empty($_POST)) {

            $post = array_map('trim', array_map('strip_tags', $_POST));

            // echo '<pre>';
            // var_dump($post);
            // echo '</pre>';

            if(!v::notEmpty()->length(3,30)->validate($post['titre'])) {
                $errors[] = 'Le titre doit comporter entre 3 et 30 caractères';
            }

            if(!v::notEmpty()->date('Y-m-d')->validate($post['date_debut'])) {
                $errors[] = 'La date de début est invalide ou n\'a pas été renseignée';
            }

            if(!v::notEmpty()->date('Y-m-d')->validate($post['date_fin'])) {
                $errors[] = 'La date de fin est invalide ou n\'a pas été renseignée';
            }

            if(!v::notEmpty()->postalCode('FR')->validate($post['cp_rdv'])) {
                $errors[] = 'Le code postal est invalide ou n\'a pas été correctement renseignée';
            }

            if(count($errors) === 0) {

                $user = $em->getRepository(Utilisateurs::class)->find(3);

                $bal = new Balades();
                $bal->setUser($user);

                $bal->setTitre($post['titre']);
                $bal->setContenu($post['contenu']);
                $bal->setDateDebut(new \DateTime($post['date_debut']));
                $bal->setDateFin(new \DateTime($post['date_fin']));
                $bal->setDatetimeRdv(new \DateTime($post['datetime_rdv']));
                $bal->setAdresseRdv($post['adresse_rdv']);
                $bal->setCpRdv($post['cp_rdv']);
                $bal->setVilleRdv($post['ville_rdv']);
                // $bal->setFileGps($post['file_gps']);
                $bal->setDatetimePost(new \DateTime());
                // $bal->setDatetimeModif(new \DateTime());

                $em->persist($bal);
                $em->flush();

                $success = true;
            }

        }

        $balades = $em->getRepository(Balades::class)->findAll();

        echo '<pre>';
        print_r($balades[0]->getUser()->getPrenom());
        echo '</pre>';





    	return $this->render('balades/add.html.twig', [
            'post' => $post ?? [],
            'errors' => $errors ?? '',
            'success' => $success ?? false,
        ]);
    }

    public function editBalade() {

    	//

    	return $this->render('balades/edit.html.twig', [

        ]);
    }

    public function deleteBalade() {

    	//

    	return $this->render('balades/delete.html.twig', [

        ]);
    }


}
