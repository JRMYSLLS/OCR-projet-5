<?php
namespace App\Controller;

class Controller{

    protected $twig;

    function loadView(){
        $loader = new \Twig\Loader\FilesystemLoader('./App/View');
        $this->twig = new \Twig\Environment($loader);
    }

    function test(){
        echo 'prout';
    }
}