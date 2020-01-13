<?php
namespace App\Controller;

use App\Model\TutoManager;

class TutoController extends Controller{

    public function tutosPage(){
        $this->isConnect();
        $tuto = new TutoManager;
        $getTuto = $tuto->getTutos();

        $this->loadView();
        echo $this->twig->render('tuto.twig',[
            'tutos' => $getTuto
        ]);
    }

    public function tutoPage(){
        $this->isConnect();
        $tuto = new TutoManager;

        if(isset($_GET['id']) && !empty($_GET['id'])){
            
            $id = intval($_GET['id']);
            $getTuto = $tuto->getTuto($id);
            $check = $tuto->checkValidate($id,$_SESSION['id']);
            $this->loadView();
            echo $this->twig->render('tutoPage.twig',[
            'tuto' => $getTuto,
            'check' => $check
            ]);
        }else{
            $this->setFlash('Ce tuto est introuvable');
            header('location: index.php?action=tutos');
        }
    }

    public function writeTutoPage(){
        $this->isAdmin();
        $this->loadView();
        echo $this->twig->render('writeTutoPage.twig');
    }

    public function newTuto(){
        $this->isAdmin();
        $tuto = new TutoManager;
        $dossier = './public/uploads/';
        $fichier = basename($_FILES['background']['name']);
        $extensions = array('.png', '.gif', '.jpg', '.jpeg');
        $extension = strrchr($_FILES['background']['name'], '.'); 

        if(isset($_POST['newTuto'])){

            if(isset($_POST['title']) && isset($_POST['content']) && isset($_POST['presentation'])){

                $title = $_POST['title'];
                $content = $_POST['content'];
                $presentation = $_POST['presentation'];

                if(!empty($title) && !empty($content) && !empty($presentation)){

                    if(in_array($extension, $extensions)){

                        $fichier = strtr($fichier, 
                        'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                        'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                        $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);

                        if(move_uploaded_file($_FILES['background']['tmp_name'], $dossier . $fichier)){

                            $tuto->newTuto($_SESSION['pseudo'],$_SESSION['id'],$title,$_FILES['background']['name'],$presentation,$content);
                            $this->setFlash('Tuto publier.','success');
                            header('location: index.php?action=homeUser');
                            exit (0);

                        }else{
                            $this->setFlash('Erreur lors de la publication.');
                        }

                    
                    }else{
                        $this->setFlash('Vous devez uploader une image de type png, gif, jpg, jpeg.');
                    }

                }else{
                    $this->setFlash('Vous devez remplir tout les champs.');
                }

            }else{
                $this->setFlash('Erreur de champs.');
            }

        }else{
            $this->setFlash('Erreur de avec le formulaire.');
        }

        header('location: index.php?action=writeTutoPage');
    }

    public function deleteTuto(){
        $this->isAdmin();
        $tuto = new TutoManager;
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $id = intval($_GET['id']);
            $tuto->deleteTuto($id);
            \header('location: index.php?action=homeUser');
        }
    }

    public function editTutoPage(){
        $this->isAdmin();

        if(isset($_GET['id']) && !empty($_GET['id'])){
            $id = intval($_GET['id']);
            $tuto = new TutoManager;
            $getTuto = $tuto->getTuto($id);

            $this->loadView();
            echo $this->twig->render('editTuto.twig',[
                'tuto' => $getTuto
            ]);
        }
        
    }

    public function editTuto(){
        $this->isAdmin();
        $tuto = new TutoManager;
        $dossier = './public/uploads/';
        $fichier = basename($_FILES['background']['name']);
        $extensions = array('.png', '.gif', '.jpg', '.jpeg');
        $extension = strrchr($_FILES['background']['name'], '.'); 
        

        if(isset($_GET['id']) && !empty($_GET['id'])){
            $id = intval($_GET['id']);

            if(isset($_POST['editTuto'])){

                if(!empty($_POST['title']) && !empty($_POST['presentation']) && !empty($_POST['content'])){

                    if(in_array($extension, $extensions)){

                        $fichier = strtr($fichier, 
                        'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                        'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                        $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);

                        if(move_uploaded_file($_FILES['background']['tmp_name'], $dossier . $fichier)){

                            $title = $_POST['title'];
                            $presentation = $_POST['presentation'];
                            $content = $_POST['content'];

                            $tuto->editTuto($title,$_FILES['background']['name'],$presentation,$content,$id);
                            \header('location: index.php?action=homeUser');
                            exit (0);

                        }else{
                            $this->setFlash('Erreur lors de la publication.');
                        }

                    
                    }else{
                        $this->setFlash('Vous devez uploader une image de type png, gif, jpg, jpeg.');
                    }

                }else{
                $this->setFlash('Vous devez remplir tout les champs');

                }
            }
        }else{
            $this->setFlash('Erreur de champs');
        }
        echo 'prout';
    }

    public function validateTuto(){
        $this->isConnect();
        $tuto = new TutoManager();

        if(isset($_GET['action'], $_GET['id_tuto'])){
            $idAstuce = $_GET['id_tuto'];
            $idMembre = $_SESSION['id'];

            if($tuto->tutoExiste($idAstuce)==1){

                if($tuto->checkValidate($idAstuce,$idMembre)==0){

                        $tuto->validateTuto($idAstuce,$idMembre);
                        $this->setFlash('Tuto sauvegardé','success');
                        header('location: index.php?action=tuto&id='.$idAstuce.'');
                        exit (0);
                    
                }else{
                    $this->setFlash('Vous avez deja valider ce tuto');
                }      
                
            }else{
                $this->setFlash('Ce tuto n\'existe pas');
            }
           
        }
        header('location: index.php?action=tutos');
    }

    public function deleteTutoForUser(){
        $this->isConnect();
        $astuce = new TutoManager();
        $astuce->deleteValidateTuto($_GET['idtuto'],$_GET['iduser']);
        $this->setFlash('Tuto éffacé','success');
        header('location: index.php?action=homeUser');
    }


}