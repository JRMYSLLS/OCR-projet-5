<?php
namespace App\Controller;

use App\Manager\AstucesManager;
require_once('App/Model/AstucesManager.php');

class AstucesController extends Controller{

    public function homeUser(){
        $this->isConnect();
        $astuces = new AstucesManager();

        $user=$astuces->getAstuceForUser($_SESSION['id']);

        $this->loadView();
        echo $this->twig->render('test.twig',['user'=> $user]);
    }

    public function getAstuces(){
        $this->isConnect();
        $articles = new AstucesManager();
        $test = $articles->getAstuces($_SESSION['id']);
        $this->loadView();
        echo $this->twig->render('articles.twig',['articles' => $test]);
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

}