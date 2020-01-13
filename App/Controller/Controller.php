<?php
namespace App\Controller;

use App\Manager\AstucesManager;
use Twig_SimpleFunction;

class Controller{

    protected $twig;

    function loadView(){
        $loader = new \Twig\Loader\FilesystemLoader('./App/View');
        $this->twig = new \Twig\Environment($loader,[
          'debug' => true,
        ]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
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
        //$this->twig->addGlobal('article', new AstucesManager());
    }

    public function isConnect(){
      if (!isset($_SESSION['pseudo'])) {
        throw new \Exception('Vous devez étre connecté pour avoir accès à cette page.');
      }
    }

    public function isAdmin(){
      if (!isset($_SESSION['isAdmin'])){
        throw new \Exception("Vous n'etes pas admin");
      }
    }

    public static function setFlash($message, $type ='danger') {
        $_SESSION['flash'] = array(
          'message' => $message,
          'type'    =>$type
        );
    }
    
    
}