<?php
namespace App\Controller;

use App\Manager\TutoManager;
require_once('App/Model/TutoManager.php');

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
            $this->loadView();
            echo $this->twig->render('tutoPage.twig',[
            'tuto' => $getTuto
            ]);
        }else{
            echo 'page introuvable';
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

                    $tuto->newTuto($_SESSION['pseudo'],$title,$presentation,$content);
                    echo 'publier';

                }else{
                    echo 'variable vide';
                }

            }else{
                echo 'pas de variable';
            }
        }else{
            echo 'prout';
        }
    }
}