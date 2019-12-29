<?php
session_start();
ini_set('display_errors',1);
require_once 'vendor/autoload.php';

use App\Controller\AstucesController;
use App\Controller\ChatController;
use App\Controller\Controller;
use App\Controller\MembersController;

// router

$action ='';

$member = new MembersController();
$astuces = new AstucesController();
$chat = new ChatController();

if(isset($_GET['action'])){
    $action = $_GET['action'];
};

try{
    switch($action){
        case 'weclome': 
            $member->accueil();
        break;

        case 'registrationView':
            $member->registrationView();
        break;

        case 'registration':
            $member->registration();
        break;

        case 'confirmation':
            $member->confirmationView();
        break;

        case 'connectionView':
            $member->connectionView();
        break;

        case 'login':
            $member->connect();
        break;

        case 'deconnexion':
            $member->disconnection();
        break;

        case 'resetPassView':
            $member->resetPassView();
        break;

        case 'resetpassword':
            $member->resetPassWord();
        break;

        case 'resetPage':
            $member->resetPage();
        break;

        case 'resetConfirm':
            $member->resetConfirm();
        break;

        case 'homeUser':
            $astuces->homeUser();
        break;

        case 'articles':
            $astuces->getAstuces();
        break;

        case 'validateAstuce':
            $astuces->validateAstuce();
        break;

        case 'deleteAstuceForUser':
            $astuces->deleteAstuceForUser();
        break;

        case 'writeAstuce':
            $astuces->writeAstuce();
        break;

        case 'addAstuce':
            $astuces->addAstuce();
        break;

        case 'deleteAstuceByUser':
            $astuces->deleteAstuceByUser();
        break;

        case 'chatPage':
            $chat->chatPage();
        break;

        case 'refresh':
            $chat->chatMessage();
        break;

        case 'chatMessage':
            $chat->sendMessage();
        break;

        default:
            $member->accueil();
    }
} catch (\Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
   }

