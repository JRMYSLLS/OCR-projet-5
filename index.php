<?php
session_start();
ini_set('display_errors',1);
require_once 'vendor/autoload.php';

use App\Controller\Controller;
use App\Controller\MembersController;

// router

$action ='';

$member = new MembersController();

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

        default:
            $member->accueil();
    }
} catch (\Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
   }

