<?php
namespace App\Controller;

use App\Manager\TutoManager;
require_once('App/Model/TutoManager.php');

class TutoController extends Controller{

    public function tutoPage(){
        $this->isConnect();
        $tuto = new TutoManager;
        $getTuto = $tuto->getTuto();

        $this->loadView();
        echo $this->twig->render('tuto.twig',[
            'tutos' => $getTuto
        ]);
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

            if(isset($_POST['title']) && isset($_POST['content'])){

                $title = $_POST['title'];
                $content = $_POST['content'];

                if(!empty($title) && !empty($content)){

                    $tuto->newTuto($_SESSION['pseudo'],$title,$content);
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