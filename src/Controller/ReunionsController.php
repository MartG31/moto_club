<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface; // Connexion a la base de données
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Respect\Validation\Validator as v;
use Intervention\Image\ImageManagerStatic as Image;

use App\Entity\Utilisateurs;
use App\Entity\Reunions;
use App\Entity\ComptesRendus;

class ReunionsController extends MasterController
{
    /**
     * @Route("/reunions", name="reunions")
     */
    public function indexReunion()
    
    {
    	// Récupération de la liste des réunions
            $entityManager = $this->getDoctrine()->getManager();
            // Permet de chercher les réunions via le repository
            $reuFound = $entityManager->getRepository(Reunions::class)->findAll();
            //$crFound = $entityManager->getRepository(ComptesRendus::class)->findAll();

        return $this->render('reunions/index.html.twig', [
            'reunionsTrouvees' => $reuFound, 
            //'crTrouves' => $crFound,
        ]);
    }

    public function viewReunion($id)
    
    {
    	// Récupération de la liste des réunions
            $entityManager = $this->getDoctrine()->getManager();
            // Permet de chercher les réunions via le repository
            $reuFound = $entityManager->getRepository(Reunions::class)->find($id);
            $crFound = $entityManager->getRepository(ComptesRendus::class)->find($id);
            //$crFound = $entityManager->getRepository(ComptesRendus::class)->find(getReu()->$id);

        return $this->render('reunions/viewReu.html.twig', [
            'reunionTrouvee' => $reuFound, 
            'crTrouve' => $crFound,
        ]);
    }

    public function addReunion()
    
    {
        // Utilisation de la base de données
        $entityManager = $this->getDoctrine()->getManager();
        

        if(!empty($_POST)){

            $safe = array_map('trim', array_map('strip_tags', $_POST));

            //pas de controle d'unicité de la réunion : il s'agira d'une modération manuelle
            #$entityManager = $this->getDoctrine()->getManager();
            #$userFound = $entityManager->getRepository(Reunions::class)->findByEmail($safe['email']);
            //var_dump($userFound);
            
           ///////////////////////////////////////// tableau d'erreur

            $errors = [                                                      
            (!v::notEmpty()->stringType()->length(3, 80)->validate($safe['titre'])) ? 'L\'intitulé de la réunion doit faire entre 3 et 80 caractères' : null,
            (!v::notEmpty()->stringType()->length(3, 80)->validate($safe['lieu'])) ? 'Le lieu de réunion doit faire entre 3 et 80 caractères' : null,
            (!v::notEmpty()->stringType()->length(2, 30)->validate($safe['type'])) ? 'Le type de réunion doit faire entre 2 et 30 caractères' : null,
            (!v::notEmpty()->stringType()->length(3)->validate($safe['contenu'])) ? 'Le contenu doit faire au moins 3 caractères' : null,
            (!v::notEmpty()->date()->validate($safe['date_reu'])) ? 'La réunion doit être une date valide' : null,
            //(!v::notEmpty()->date()->validate($safe['time_rdv'])) ? 'L\'heure de réunion doit être une heure valide' : null,
            
            ];

            $errors = array_filter($errors);

            if(count($errors) == 0 ){
                   /////////////////////////////////////////// ajout bdd ////////////////////////////////////              
                $reunion = new Reunions();
                $reunion->setTitre($safe['titre'])
                        ->setLieuReu($safe['lieu'])
                        ->setTypeReu($safe['type'])
                        ->setContenu($safe['contenu'])
                        //->setUser($_SESSION['user'])
                        ->setDatetimeReu($this->mergeDateTime($safe['date_reu'], $safe['time_reu']))
                        ->setDatetimePost(new \DateTime('now'));
                

                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($reunion);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();
                $success = true;
            }
            else {
                $errorsForm = implode('<br>', $errors);
            }
  
        }

       return $this->render('reunions/addReu.html.twig', [
           'success'            => $success ?? false,
           'errors'             => $errorsForm ?? [],
           'donnees_saisies'    => $safe ?? [],
           //'maxSizeFile'          => $this->maxSizeFile,

                   
        ]);     
    }

    public function editReunion($id)
    
    {
        // Utilisation de la base de données
        $entityManager = $this->getDoctrine()->getManager();
        $reuFound = $entityManager->getRepository(Reunions::class)->find($id);
        

        if(!empty($_POST)){

            $safe = array_map('trim', array_map('strip_tags', $_POST));

            //pas de controle d'unicité de la réunion : il s'agira d'une modération manuelle
            #$entityManager = $this->getDoctrine()->getManager();
            #$userFound = $entityManager->getRepository(Reunions::class)->findByEmail($safe['email']);
            //var_dump($userFound);
            
           ///////////////////////////////////////// tableau d'erreur

            $errors = [                                                      
            (!v::notEmpty()->stringType()->length(3, 80)->validate($safe['titre'])) ? 'L\'intitulé de la réunion doit faire entre 3 et 80 caractères' : null,
            (!v::notEmpty()->stringType()->length(3, 80)->validate($safe['lieu'])) ? 'Le lieu de réunion doit faire entre 3 et 80 caractères' : null,
            (!v::notEmpty()->stringType()->length(2, 30)->validate($safe['type'])) ? 'Le type de réunion doit faire entre 2 et 30 caractères' : null,
            (!v::notEmpty()->stringType()->length(3)->validate($safe['contenu'])) ? 'Le contenu doit faire au moins 3 caractères' : null,
            (!v::notEmpty()->date()->validate($safe['date_reu'])) ? 'La réunion doit être une date valide' : null,
            
            ];

            $errors = array_filter($errors);

            if(count($errors) == 0 ){

                   /////////////////////////////////////////// ajout bdd ////////////////////////////////////              
                $reuFound->setTitre($safe['titre'])
                        ->setLieuReu($safe['lieu'])
                        ->setTypeReu($safe['type'])
                        ->setContenu($safe['contenu'])
                        ->setDatetimeReu($this->mergeDateTime($safe['date_reu'], $safe['time_reu']))
                        ->setDatetimePost(new \DateTime('now'));
                

                // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $entityManager->persist($reuFound);

                // actually executes the queries (i.e. the INSERT query)
                $entityManager->flush();
                $success = true;
            }
            else {
                $errorsForm = implode('<br>', $errors);
            }
  
        }

        return $this->render('reunions/editReu.html.twig', [
            'success'        => $success ?? false,
            'errors'         => $errorsForm ?? [],
            'reunionTrouvee' => $reuFound,
        ]);
    }

    public function delReunion($id)
    
    {
        // Récupération de la liste des réunions
            $entityManager = $this->getDoctrine()->getManager();
            // Permet de chercher les réunions via le repository
            $reuFound = $entityManager->getRepository(Reunions::class)->find($id);
                //suppression de l'article trouvé
                #$entityManager->remove($reuFound);
                #$entityManager->flush();

        return $this->render('reunions/delReu.html.twig', [
            'reunionTrouvee' => $reuFound,
        ]);
    }

    public function addCr($id)
    
    {
        // Récupération de la liste des réunions
            $entityManager = $this->getDoctrine()->getManager();
            // Permet de chercher les réunions via le repository
            $reuFound = $entityManager->getRepository(Reunions::class)->find($id);


            if(!empty($_POST)){

                $safe = array_map('trim', array_map('strip_tags', $_POST));

                //pas de controle d'unicité de la réunion : il s'agira d'une modération manuelle
                #$entityManager = $this->getDoctrine()->getManager();
                #$userFound = $entityManager->getRepository(Reunions::class)->findByEmail($safe['email']);
                //var_dump($userFound);
                
               ///////////////////////////////////////// tableau d'erreur

                $errors = [                                                      
                (!v::notEmpty()->stringType()->length(3)->validate($safe['contenu'])) ? 'Le contenu du compte rendu réunion doit faire au moins 3 caractères' : null,
                (!v::notEmpty()->stringType()->length(3, 80)->validate($safe['titre'])) ? 'Le titre du compte rendu réunion doit faire entre 3 et 80 caractères' : null,
                ];

                $errors = array_filter($errors);

                if(count($errors) == 0 ){
                       /////////////////////////////////////////// ajout bdd ////////////////////////////////////              
                    $cr = new ComptesRendus();
                    $cr->setContenu($safe['contenu'])
                        ->setTitre($safe['titre'])
                        ->setReu($reuFound)
                        //->setUser($_SESSION['user'])
                        ->setDatetimePost(new \DateTime('now'));

                    // tell Doctrine you want to (eventually) save the Product (no queries yet)
                    $entityManager->persist($cr);

                    // actually executes the queries (i.e. the INSERT query)
                    $entityManager->flush();
                    $success = true;
                }
                else {
                    $errorsForm = implode('<br>', $errors);
                }
                //suppression de l'article trouvé
                #$entityManager->remove($reuFound);
                #$entityManager->flush();
            }

        return $this->render('reunions/addCr.html.twig', [
            'reunionTrouvee'    => $reuFound,
            'donnees_saisies'   => $safe ?? [],
            'success'           => $success ?? false,
            'errors'            => $errorsForm ?? [],
        ]);
    }

    public function editCr($id)
    
    {
        // Récupération de la liste des réunions
            $entityManager = $this->getDoctrine()->getManager();
            // Permet de chercher les réunions via le repository
            $reuFound = $entityManager->getRepository(Reunions::class)->find($id);
            $crFound = $entityManager->getRepository(ComptesRendus::class)->find($id);

            if(!empty($_POST)){

                $safe = array_map('trim', array_map('strip_tags', $_POST));

                //pas de controle d'unicité de la réunion : il s'agira d'une modération manuelle
                #$entityManager = $this->getDoctrine()->getManager();
                #$userFound = $entityManager->getRepository(Reunions::class)->findByEmail($safe['email']);
                //var_dump($userFound);
                
               ///////////////////////////////////////// tableau d'erreur

                $errors = [                                                      
                (!v::notEmpty()->stringType()->length(3)->validate($safe['contenu'])) ? 'Le contenu du compte rendu réunion doit faire au moins 3 caractères' : null,
                (!v::notEmpty()->stringType()->length(3, 80)->validate($safe['titre'])) ? 'Le titre du compte rendu réunion doit faire entre 3 et 80 caractères' : null,
                ];

                $errors = array_filter($errors);

                if(count($errors) == 0 ){
                       /////////////////////////////////////////// ajout bdd ////////////////////////////////////              
                   
                    $crFound->setContenu($safe['contenu'])
                        ->setTitre($safe['titre'])
                        ->setReu($reuFound)
                        //->setUser($_SESSION['user'])
                        ->setDatetimeModif(new \DateTime('now'));

                    // tell Doctrine you want to (eventually) save the Product (no queries yet)
                    $entityManager->persist($crFound);

                    // actually executes the queries (i.e. the INSERT query)
                    $entityManager->flush();
                    $success = true;
                }
                else {
                    $errorsForm = implode('<br>', $errors);
                }
                //suppression de l'article trouvé
                #$entityManager->remove($reuFound);
                #$entityManager->flush();
            }

        return $this->render('reunions/editCr.html.twig', [
            //'reunionTrouvee'    => $reuFound,
            'crTrouve'          => $crFound,
            'donnees_saisies'   => $safe ?? [],
            'success'           => $success ?? false,
            'errors'            => $errorsForm ?? [],
        ]);
    }
    public function indexCr()
    
    {
        // Récupération de la liste des réunions
            $entityManager = $this->getDoctrine()->getManager();
            // Permet de chercher les réunions via le repository
            $crFound = $entityManager->getRepository(ComptesRendus::class)->findAll();

        return $this->render('reunions/indexCr.html.twig', [
            'crTrouves' => $crFound, 
        ]);
    }

    public function viewCr($id)
    
    {
        // Récupération de la liste des réunions
            $entityManager = $this->getDoctrine()->getManager();
            // Permet de chercher les réunions via le repository
            $crFound = $entityManager->getRepository(ComptesRendus::class)->find($id);


        return $this->render('reunions/viewCr.html.twig', [
            'crTrouve' => $crFound, 
        ]);
    }

    public function delCr($id)
    
    {
        // Récupération de la liste des réunions
            $entityManager = $this->getDoctrine()->getManager();
            // Permet de chercher les réunions via le repository
            $crFound = $entityManager->getRepository(ComptesRendus::class)->find($id);
                //suppression de l'article trouvé
                #$entityManager->remove($reuFound);
                #$entityManager->flush();

        return $this->render('reunions/delCr.html.twig', [
            'crTrouve' => $crFound,
        ]);
    }

}
