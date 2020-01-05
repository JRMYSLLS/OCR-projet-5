<?php
namespace App\Controller;

use App\Model\AstucesManager;
use App\Model\TutoManager;

class AstucesController extends Controller{

    public function homeUser(){
        $this->isConnect();
        $astuces = new AstucesManager();
        $tuto = new TutoManager();
        $astuceByUser = $astuces->getAstuceByUser($_SESSION['pseudo']);
        $countAstuceUser = $astuces->countAstucesForUser($_SESSION['id']);
        $countAstuceByUser = $astuces->countAstucesByUser($_SESSION['pseudo']);
        $user = $astuces->getAstuceForUser($_SESSION['id']);
        $getTutos = $tuto->getTutoByAuthor($_SESSION['id']);
        $getValidateTuto = $tuto->getTutoForUser($_SESSION['id']);
        $countTuto = $tuto->countTutoForUser($_SESSION['id']);

        $this->loadView();
        echo $this->twig->render('homeUser.twig',['user'=> $user,
        'count'=> $countAstuceUser,
        'astuceUser'=> $astuceByUser,
        'userCount'=> $countAstuceByUser,
        'tutos' => $getTutos,
        'validateTuto' => $getValidateTuto,
        'countTuto' => $countTuto
        ]);
        
    }

    public function getAstuces(){
        $this->isConnect();
        $articles = new AstucesManager();
        $numberOfAstuces = $articles->countAstuces();

        // Pagination
        if(isset($_GET['page']) && $_GET['page']>0){
            $currentPage = intval($_GET['page']);
        }else{
            $currentPage = 1;
        }

        $astucePerPage = 4;
        $numberOfPage = ceil($numberOfAstuces/$astucePerPage);
        if($currentPage>$numberOfPage){
            $currentPage=$numberOfPage;
        }
        $begin = ($currentPage-1)*$astucePerPage;

        $test = $articles->getAstuces($_SESSION['id'],$begin,$astucePerPage);
        $this->loadView();
        echo $this->twig->render('articles.twig',[
        'articles' => $test,
        'page' => $numberOfAstuces,
        'test' => $numberOfPage]);
    }

    //Supprimer les astuces sauvegardé
    public function deleteAstuceForUser(){
        $this->isConnect();
        $astuce = new AstucesManager();
        $astuce->deleteAstuceForUser($_GET['idastuce'],$_GET['iduser']);
        header('location: index.php?action=homeUser');
    }

    //Supprimer les astuces ecrite par le membre
    public function deleteAstuceByUser(){
        $this->isConnect();
        $astuce = new AstucesManager();
        if(isset($_GET['idastuce']) && isset($_GET['iduser'])){
            $astuce->deleteAstuceByUser($_GET['idastuce'],$_GET['iduser']);
            $astuce->deleteValidateAstuce($_GET['idastuce']);
        }
        header('location: index.php?action=homeUser');
    }

    public function validateAstuce(){
        $this->isConnect();
        $astuce = new AstucesManager();

        if(isset($_GET['action'], $_GET['id_astuce'])){
            $idAstuce = $_GET['id_astuce'];
            $idMembre = $_SESSION['id'];

            if($astuce->astuceExiste($idAstuce)==1){

                if($astuce->checkValidate($idAstuce,$idMembre)==0){

                        $astuce->validateAstuce($idAstuce,$idMembre);
                        $this->setFlash('Astuce Validé');
                        header('location: index.php?action=articles');
                    
                }else{
                    $this->setFlash('Vous avez deja valider cette astuce');
                    header('location: index.php?action=articles');
                }      
                
            }else{
                $this->setFlash('l\'astuce n\'existe pas');
                header('location: index.php?action=articles');
            }
            header('location: index.php?action=articles');
        }
        
    }

    public function writeAstuce(){
        $this->isConnect();
        $this->loadView();
        echo $this->twig->render('user/writeAstuce.twig');
    }

    public function addAstuce(){
        $this->isConnect();
        $astuce = new AstucesManager();

        if(isset($_POST['addAstuce'])){

            if(isset($_POST['title']) && isset($_POST['content'])){
                $title = trim($_POST['title']);
                $content = trim($_POST['content']);

                if(!empty($title) && !empty($content)){
                    $title = htmlspecialchars($title);
                    $content = htmlspecialchars($content);
                    $astuce->newAstuce($title,$_SESSION['pseudo'],$content);
                    \header('location: index.php?action=homeUser');
                }else{
                    $this->setFlash('Vous devez remplir tout les champs.');
                    \header('location: index.php?action=writeAstuce');

                }
            }
        }
    }

}