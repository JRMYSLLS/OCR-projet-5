<?php
ini_set('display_errors',1);
require_once 'vendor/autoload.php';
use App\Controller\MembersController;

// router

$action ='';

$member = new MembersController();

if(isset($_GET['action'])){
    $action = $_GET['action'];
};

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

    default:
         $member->accueil();
}

