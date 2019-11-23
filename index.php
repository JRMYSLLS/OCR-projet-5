<?php
require_once 'vendor/autoload.php';


// router

$action ='';

$member = new App\Controller\MembersController();

if(isset($_GET['aciton'])){
    $action = $_GET['action'];
};

switch($action){
    case 'weclome': 
        $member->accueil();
        break;

    default:
         $member->accueil();
}

