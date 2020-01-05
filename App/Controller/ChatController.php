<?php
namespace App\Controller;

use App\Model\ChatManager;

class ChatController extends Controller{

    public function chatPage(){
        $this->isConnect();
        $this->loadView();
        echo $this->twig->render('chat.twig');
    }

    public function chatMessage(){
        $this->isConnect();
            $chat = new ChatManager();
            $messages = $chat->getMessage();
            require('./App/View/chatMessage.php');
    }

    public function sendMessage(){
        $this->isConnect();
        $chat = new ChatManager();

        if(isset($_POST['sendMessage'])){

            if(isset($_POST['messageChat'])){
                $message = trim($_POST['messageChat']);

                if(!empty($message)){

                    $message = htmlspecialchars($message);
                    $chat->postMessage($_SESSION['pseudo'],$message);
                    header('location: index.php?action=chatPage');

                }else{
                    $this->setFlash('Vous n\'avez pas écris de message');
                    header('location: index.php?action=chatPage');
                }
            }
        }
    }
}