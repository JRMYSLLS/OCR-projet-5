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

        if(isset($_POST['newTuto'])){

            if(isset($_POST['title']) && isset($_POST['content']) && isset($_POST['presentation'])){

                $title = $_POST['title'];
                $content = $_POST['content'];
                $presentation = $_POST['presentation'];

                if(!empty($title) && !empty($content) && !empty($presentation)){

                    $tuto->newTuto($_SESSION['pseudo'],$_SESSION['id'],$title,$presentation,$content);
                    echo 'publier';
                    exit (0);

                }else{
                    $this->setFlash('Vous devez remplir tout les champs.');
                }

            }else{
                $this->setFlash('Erreur de champs.');
            }

        }else{
            $this->setFlash('Erreur de avec le formulaire.');
        }

        header('location: index.php?action=homeUser');
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

        if(isset($_GET['id']) && !empty($_GET['id'])){
            $id = intval($_GET['id']);

            if(isset($_POST['editTuto'])){

                if(!empty($_POST['title']) && !empty($_POST['presentation']) && !empty($_POST['content'])){

                    $title = $_POST['title'];
                    $presentation = $_POST['presentation'];
                    $content = $_POST['content'];

                    $tuto->editTuto($title,$presentation,$content,$id);
                    \header('location: index.php?action=homeUser');
                    exit (0);

                }else{
                $this->setFlash('Vous devez remplir tout les champs');

                }
            }
        }else{
            $this->setFlash('Erreur de champs');
        }
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
                        $this->setFlash('Tuto Validé','success');
                        header('location: index.php?action=tuto&id='.$idAstuce.'');
                        exit (0);
                    
                }else{
                    $this->setFlash('Vous avez deja valider ce tuto');
                    header('location: index.php?action=tutos');
                }      
                
            }else{
                $this->setFlash('Ce tuto n\'existe pas');
                header('location: index.php?action=tutos');
            }
            header('location: index.php?action=tutos');
        }
        
    }

    public function deleteTutoForUser(){
        $this->isConnect();
        $astuce = new TutoManager();
        $astuce->deleteValidateTuto($_GET['idtuto'],$_GET['iduser']);
        header('location: index.php?action=homeUser');
    }


}