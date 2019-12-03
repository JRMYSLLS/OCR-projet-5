<?php
namespace App\Controller;

use Twig_SimpleFunction;

class Controller{

    protected $twig;

    function loadView(){
        $loader = new \Twig\Loader\FilesystemLoader('./App/View');
        $this->twig = new \Twig\Environment($loader);
        $this->twig->addFunction(new Twig_SimpleFunction('getFlash', function(){
          if (isset($_SESSION['flash']) ) {
            echo '<div id="alert" class="alert alert-custom alert-'. $_SESSION['flash']['type'] .'">
                  <a class="close"> x </a>
                  <p class="txt">'
                  . $_SESSION['flash']['message'] .
                  '</p>
                  </div>';
            unset($_SESSION['flash']);
          }
        }));
        $this->twig->addGlobal('_get', $_GET);
        $this->twig->addGlobal('session', $_SESSION);
    }

    public function isConnect(){
      if (!isset($_SESSION['pseudo'])) {
        throw new \Exception("Vous devez étre connecté pour avoir accès à cette page");
      }
    }

    public static function setFlash($message, $type ='danger') {
        $_SESSION['flash'] = array(
          'message' => $message,
          'type'    =>$type
        );
    }
    
    
}