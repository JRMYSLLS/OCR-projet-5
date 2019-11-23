<?php
namespace App\Controller;

//require_once ('App/Controller/Controller.php');

class MembersController extends Controller{

    function accueil(){
        $this->loadView();
        echo $this->twig->render('welcome.twig');
    }
}