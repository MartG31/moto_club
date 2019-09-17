<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Utilisateurs;
use App\Entity\Balades;
use App\Entity\Photos;

use \Respect\Validation\Validator as v;
use \Behat\Transliterator\Transliterator as tr;
use Intervention\Image\ImageManagerStatic as Image; 


class PhotosController extends MasterController
{
    
    // ATTRIBUTS
    public $errors = [];

    public $maxFileSize = 3 * 1000 * 1000; // Limite la taille des photos de balades à 3 Mo
    public $uploadDir = 'uploads/photos/';


    // PAGES & METHODES

    public function viewAlbums() {

        $em = $this->getDoctrine()->getManager();

        $balades = $em->getRepository(Balades::class)->findAll();
        $albums = [];

        foreach ($balades as $balade) {
            $firstPhotoDeChaqueBalade = $em->getRepository(Photos::class)->findOneBy(['bal' => $balade ]);
            if($firstPhotoDeChaqueBalade != null) {
                $albums[] = $firstPhotoDeChaqueBalade;
            }
        }

        return $this->render('photos/albums.html.twig', [
            'albums' => $albums,
            'uploadDir' => $this->uploadDir,
        ]);
    }

    public function addPhoto() {

        if($this->restrictAccess('adherent')) { return $this->redirectToRoute('accueil'); }

    	$this->errors = [];
        $em = $this->getDoctrine()->getManager();

        if(!empty($_POST)) {
            $post = array_map('trim', array_map('strip_tags', $_POST));

            if(empty($_FILES) || $_FILES['photo']['error'] != UPLOAD_ERR_OK) {
                $this->errors[] = 'Aucun fichier n\'a été sélectionné';
            }
            else {
                $img = Image::make($_FILES['photo']['tmp_name']);
                $fileName = $this->checkUploadedPhoto($img);
            }

            if(count($this->errors) === 0) {

                $img->save($this->uploadDir.$fileName);

                $bal = $em->getRepository(Balades::class)->find(3);

                $ph = new Photos();
                $ph->setBal($bal);

                $ph->setFileName($fileName);
                $ph->setLegende($post['legende']);
                $ph->setDatetimePost(new \DateTime());

                $em->persist($ph);
                $em->flush();

                $success = true;

            }

        	
        }

    	return $this->render('photos/add.html.twig', [
            'post' => $post ?? [],
            'errors' => $this->errors ?? '',
            'success' => $success ?? false,
        ]);
    }

    public function viewPortfolio($id) {

        $em = $this->getDoctrine()->getManager();

        $balFound = $em->getRepository(Balades::class)->find($id);
        $photos = $em->getRepository(Photos::class)->findBy(['bal' => $balFound]);

        
        return $this->render('photos/portfolio.html.twig', [
             'photos' => $photos,
             'uploadDir' => $this->uploadDir,        
        ]);
    }

    // PRIVATE FUNCTIONS

    private function checkUploadedPhoto(&$img) {

        // echo '<pre>';
        // var_dump($_FILES);
        // echo '</pre>';

        if($img->filesize() > $this->maxFileSize) {
            $this->errors[] = 'La taille de votre image ne doit pas exéder 3 MB';
        }
        elseif(substr($img->mime(), 0, 5) != 'image') {
            $this->errors[] = 'Type de fichier invalide. Vous devez sélectionner un fichier de type image';
        }

        if(count($this->errors) === 0) {

            if(!is_dir($this->uploadDir)){
                if(!mkdir($this->uploadDir, 0777)){ 
                    die('[ERREUR] Lors de la création du répertoire '.$this->uploadDir);
                }
            }

            $path = pathinfo($_FILES['photo']['name']);
            $fileName = tr::transliterate(time().'-'.$path['filename']).'.'.$path['extension'];

            return $fileName;
        }
        return false;
    }

    public function viewPortfolio($id) {

        $em = $this->getDoctrine()->getManager();

        $balFound = $em->getRepository(Balades::class)->find($id);
        $photos = $em->getRepository(Photos::class)->findBy(['bal' => $balFound]);

        
        return $this->render('photos/portfolio.html.twig', [
             'photos' => $photos,
             'uploadDir' => $this->uploadDir,        
        ]);
    }
 }
