<?php
namespace App\Controller;

use App\Manager\MembersManager;
require_once('App/Model/MembersManager.php');

class MembersController extends Controller{

    function accueil(){
        $this->loadView();
        echo $this->twig->render('welcome.twig');
    }

    function registrationView(){
        $this->loadView();
        echo $this->twig->render('registration.twig');
    }

    function confirmationView(){
        $member = new MembersManager();

        if(isset($_GET['pseudo']) && isset($_GET['confirmKey']) && !empty($_GET['pseudo']) && !empty($_GET['confirmKey'])){
            $pseudo = $_GET['pseudo'];
            $confirmKey = $_GET['confirmKey'];

            if($member->verifyForConfirm($pseudo,$confirmKey)==1){
                $bddConfirmKey = $member->isRegistredForConfirm($pseudo);

                if($bddConfirmKey['confirm']==0){
                    $member->confirm($pseudo,$confirmKey);
                    $this->loadView();
                    echo $this->twig->render('confirmation.twig');

                }else{
                    echo 'compte deja creer';
                }      

            }else{
                echo 'probleme verification';
                var_dump($member->verifyForConfirm($pseudo,$confirmKey),$pseudo,$confirmKey);
            }
        }else{
            echo 'pas de GET';
        }
        
    }

    public function sendMail($mail,$pseudo,$confirmKey){
        $from = "sallesjry@gmail.com";
     
        $to = $mail;

        $subject = "DAD IN FORMATION Validation";

        $message = '
        <html>
            <body>
                <div>
                    <p>Pour valider votre inscription, cliquer sur le <a href="http://localhost:8888/projet_5/dad_in_formation/OCR-projet-5/index.php?action=confirmation&pseudo='.$pseudo.'&confirmKey='.$confirmKey.'">lien</a>.</p>
                </div>
            <body>
        </html>
        ';

        $headers = "From:" . $from;

     
        mail($to,$subject,$message, $headers);
    
        }

    public function registration(){
        $member = new MembersManager();
        
        if(isset($_POST['registration'])){
            

            if(!empty($_POST['pseudo']) && !empty($_POST['mail']) && !empty($_POST['password'])){
                $pseudo = trim($_POST['pseudo']);
                $mail = trim($_POST['mail']);
                $mail2 = trim($_POST['mail2']);
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                if($mail === $mail2){
                    
                    if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
                        $mailVerif = $member->isRegistred($mail);

                        if($mailVerif == 0){
                            $pseudoVerif = $member->isAlreadyUsed($pseudo);

                            if($pseudoVerif == 0){
                                $lKey = 15;
                                $confirmKey ="";
                                for($i = 1 ; $i < $lKey ; $i++){
                                    $confirmKey.=mt_rand(0,9);
                                }

                                $this->sendMail($mail,$pseudo,$confirmKey);
                                $member->registration($pseudo,$mail,$password,$confirmKey);
                                header('location: index.php?action=welcome');

                            }else{
                                echo 'pseudo deja utilisé';
                            }
                        }else{
                            echo 'mail deja utilisé';
                        }
                    }else{
                        echo 'mail non valide';
                    }
                }else{
                    echo 'mail non identique';
                }
            }else{
                echo 'variable vide';
            }
        }
    }

}