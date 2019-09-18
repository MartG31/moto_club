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

    public function indexAlbums() {

        $em = $this->getDoctrine()->getManager();

        $balades = $em->getRepository(Balades::class)->findAll();
        $albums = [];

        foreach ($balades as $balade) {
            $firstPhotoDeChaqueBalade = $em->getRepository(Photos::class)->findOneBy(['bal' => $balade ]);
            if($firstPhotoDeChaqueBalade != null) {
                $albums[] = $firstPhotoDeChaqueBalade;
            }
        }

        return $this->render('photos/index.html.twig', [
            'albums' => $albums,
            'uploadDir' => $this->uploadDir,
        ]);
    }

    public function addPhoto() {

        if($this->restrictAccess('adherent')) { return $this->redirectToRoute('accueil'); }

    	$this->errors = [];

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

    public function delPhoto($id) {

        if($this->restrictAccess('adherent')) { return $this->redirectToRoute('accueil'); }

        $em = $this->getDoctrine()->getManager();
        $ph = $em->getRepository(Photos::class)->find($id);

        // Suppression du fichier
        unlink($this->uploadDir.$ph->getFileName());

        $em->remove($ph);
        $em->flush();


        return $this->redirectToRoute('gestion_photos', [
            'id' => $ph->getBal()->getId(),
        ]);
    }

    public function viewAlbum($id) {

        $em = $this->getDoctrine()->getManager();

        $balade = $em->getRepository(Balades::class)->find($id);
        $photos = $em->getRepository(Photos::class)->findBy(['bal' => $balade]);

        
        return $this->render('photos/view.html.twig', [
             'balade' => $balade,
             'photos' => $photos,
             'uploadDir' => $this->uploadDir,        
        ]);
    }

    public function gestionPhotos($id) {

        if($this->restrictAccess('adherent')) { return $this->redirectToRoute('accueil'); }

        $em = $this->getDoctrine()->getManager();

        $balade = $em->getRepository(Balades::class)->find($id);

        // AJOUT PHOTO

        $errors = [];

        if(!empty($_POST) && !empty($_FILES)) {

            // echo '<pre class="alert alert-info mb-0">';
            // print_r($_FILES);
            // echo '</pre>';

            if($_FILES['photo']['error'] != UPLOAD_ERR_OK) {
                $errors[] = 'Une erreur est survenue lors de la sélection du fichier';
            }
            else {

                // Init MIME Type
                $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($fileInfo, $_FILES['photo']['tmp_name']);
                finfo_close($fileInfo);

                if(substr($mimeType, 0, 5) != 'image') {
                    $errors[] = 'Type de fichier invalide. Vous devez sélectionner un fichier de type image';
                }
                else {
                    $img = Image::make($_FILES['photo']['tmp_name']);

                    if($img->filesize() > $this->maxFileSize) {
                        $errors[] = 'La taille de votre image ne doit pas exéder 3 MB';
                    }
                }

                if(count($errors) === 0) {

                    $path = pathinfo($_FILES['photo']['name']);
                    $dt = new \DateTime();
                    $fileName = tr::transliterate($dt->format('Ymd-His').'-'.$balade->getTitre()).'.'.$path['extension'];

                    // Enregistrement en bdd
                    $user = $em->getRepository(Utilisateurs::class)->find($this->session->get('id'));
                    
                    $ph = new Photos();
                    $ph->setBal($balade);
                    $ph->setUser($user);

                    $ph->setFileName($fileName);
                    // $ph->setLegende();
                    $ph->setDatetimePost(new \DateTime());

                    $em->persist($ph);
                    $em->flush();

                    // Enregistrement du nouveau fichier
                    $img->save($this->uploadDir.$fileName);

                    $success = true;
                }
            }
        }

        // DATA GESTION PHOTOS

        $photos = $em->getRepository(Photos::class)->findBy(['bal' => $balade]);
        
        
        return $this->render('photos/gestion-photos.html.twig', [
            'maxFileSize' => $this->maxFileSize, 
            'uploadDir' => $this->uploadDir,  
            'balade' => $balade,
            'photos' => $photos,
            'errors' => $errors ?? [],
            'success' => $success ?? false,
        ]);
    }






 }
