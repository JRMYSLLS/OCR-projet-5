<?php
namespace App\Controller;

class Controller{

    protected $twig;

    function loadView(){
        $loader = new \Twig\Loader\FilesystemLoader('./App/View');
        $this->twig = new \Twig\Environment($loader);
        $this->twig->addGlobal('_get', $_GET);
    }

    public static function setFlash($message, $type ='danger') {
        $_SESSION['flash'] = array(
          'message' => $message,
          'type'    =>$type
        );
    }
    public static function getFlash() {
      if (isset($_SESSION['flash']) ) {
        echo '<div id="alert" class="alert alert-'. $_SESSION['flash']['type'] .'">
              <a class="close"> x </a>
              <p class="txt">'
              . $_SESSION['flash']['message'] .
              '</p>
              </div>';
        unset($_SESSION['flash']);
      }
    }
}