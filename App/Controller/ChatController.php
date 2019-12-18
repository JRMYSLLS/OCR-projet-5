<?php
namespace App\Controller;

use App\Manager\ChatManager;

require_once('App/Model/ChatManager.php');

class ChatController extends Controller{

    public function chatPage(){
        $this->isConnect();
        $chat = new ChatManager();
        $message = $chat->getMessage();
        $this->loadView();
        echo $this->twig->render('chat.twig',[
            'messages'=>$message]);
    }

    public function sendMessage(){
        $this->isConnect();
        $chat = new ChatManager();

        if(isset($_POST['sendMessage'])){

            if(isset($_POST['messageChat'])){
                $message = trim($_POST['messageChat']);

                if(!empty($message)){

                    $chat->postMessage($_SESSION['pseudo'],$message);
                    header('location: index.php?action=chatPage');

                }else{
                    echo'le message est vide';
                }
            }
        }
    }
}