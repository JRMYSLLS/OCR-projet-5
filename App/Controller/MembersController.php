<?php
namespace App\Controller;

use App\Manager\MembersManager;
require_once('App/Model/MembersManager.php');

class MembersController extends Controller{

    function accueil(){
        $this->loadView();
        echo $this->twig->render('welcome.twig');
    }

    function connectionView(){
        $this->loadView();
        echo $this->twig->render('connection.twig');
    }

    function registrationView(){
        $this->loadView();
        echo $this->twig->render('registration.twig');
    }

    function resetPassView(){
        $this->loadView();
        echo $this->twig->render('resetPassView.twig');
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
                    echo $this->twig->render('user/confirmation.twig',['user' =>[
                        'pseudo' => $pseudo,
                        'confirmKey' => $confirmKey
                    ]]);

                }else{
                    echo 'compte deja creer';
                }      

            }else{
                echo 'probleme verification';
            }
        }else{
            echo 'pas de GET';
        }
 
    }

    public function sendMail($mail,$messageMail){
        $from = "sallesjry@gmail.com";
     
        $to = $mail;

        $subject = "DAD IN FORMATION Validation";

        $message = $messageMail;

        $headers = "From:" . $from;

     
        mail($to,$subject,$message, $headers);
    
        }

    public function registration(){
        $member = new MembersManager();
        $header = header('location: index.php?action=registrationView');
        
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
                                $messageMail ='
                                <html>
                                    <body>
                                        <div>
                                            <p>Pour valider votre inscription, cliquer sur le <a href="http://localhost:8888/projet_5/dad_in_formation/OCR-projet-5/index.php?action=confirmation&pseudo='.$pseudo.'&confirmKey='.$confirmKey.'">lien</a>.</p>
                                        </div>
                                    <body>
                                </html>
                                ';
                                $this->sendMail($mail,$pseudo,$messageMail,$confirmKey);
                                $member->registration($pseudo,$mail,$password,$confirmKey);
                                header('location: index.php?action=welcome');

                            }else{
                                $this->setFlash('Ce pseudo est déja utilisé.');
                                $header;
                            }
                        }else{
                            $this->setFlash('Ce mail est déja utilisé.');
                            $header;
                        }
                    }else{
                        $this->setFlash('Votre mail n\'est pas valide.');
                        $header;
                    }
                }else{
                    $this->setFlash('Vos mail ne sont pas identiques.');
                    $header;
                }
            }else{
                $this->setFlash('Tout les champs sont obligatoire.');
                $header;
            }
        }
    }

    public function connect(){
        $members = new MembersManager();
        if (isset($_POST['connection'])) {

            if (!empty($_POST['mail']) &&!empty($_POST['password'])) {
                $mail = htmlspecialchars($_POST['mail']);
                $password = $_POST['password'];
                $verify = $members->selectByMail($mail);
                $passwordMatch = password_verify($password, $verify['mdp']);

                if($passwordMatch){
                    

                    if($verify['confirm'] == 1){
                        $_SESSION['pseudo'] = $verify['pseudo'];
                        $_SESSION['id'] = $verify['id'];
                        $this->loadView();
                        echo $this->twig->render('test.twig');
                        //$this->setFlash('Vous etes connecté','success');
                    }
                    
                    else{
                        $this->setFlash('votre compte n\'as pas etait validé, verifier vos mail');
                        header('location: index.php?action=connectionView');
                    }
                    
                }

                else {
                    $this->setFlash('Mauvais mail ou mot de passe!!!');
                    header('location: index.php?action=connectionView');
                }
             }

            else {
                $this->setFlash('Tout les champs sont obligatoires !');
                header('location: index.php?action=connectionView');
          }

        }

      }

      public function resetPassWord(){
        $members = new MembersManager();

        if(isset($_POST['resetpassword'])){

            if (isset($_POST['mail']) && !empty($_POST['mail'])) {
                $mail = htmlspecialchars($_POST['mail']);
                $verify = $members->selectByMail($mail);

                    if($verify['mail'] === $mail){
                        $confirmKey = $verify['confirmKey'];
                        $pseudo = $verify['pseudo'];
                        $messageMail ='
                        <html>
                            <body>
                                <div>
                                    <p>Pour modifier votre mot de passe, cliquer sur le <a href="http://localhost:8888/projet_5/dad_in_formation/OCR-projet-5/index.php?action=resetPage&pseudo='.$pseudo.'&confirmKey='.$confirmKey.'">lien</a>.</p>
                                </div>
                            <body>
                        </html>
                        ';
                        $this->sendMail($mail,$messageMail);
                        header('location: index.php?action=welcome');
                        $this->setFlash('Pour reinitialiser votre mot de passe, regarder vos mail','success');

                    }else{
                        $this->setFlash('étes vous sur de vous etre inscrit ?');
                        header('location: index.php?action=resetPassView');
                    }

            }else{
                $this->setFlash('Tout les champs sont obligatoires !');
                header('location: index.php?action=resetPassView');
            }
        }

      }

      public function resetPage(){
        $member = new MembersManager();

        if(isset($_GET['pseudo']) && isset($_GET['confirmKey']) && !empty($_GET['pseudo']) && !empty($_GET['confirmKey'])){
            $pseudo = $_GET['pseudo'];
            $confirmKey = $_GET['confirmKey'];

            if($member->verifyForConfirm($pseudo,$confirmKey)==1){
                $this->loadView();
                echo $this->twig->render('user/changePass.twig',['user' =>[
                        'pseudo' => $pseudo,
                        'confirmKey' => $confirmKey
                    ]]);
                
            }else{
                echo 'erreur de verification';
            }
        }
      }

      public function resetConfirm(){
        $member = new MembersManager();

        if(isset($_POST['resetConfirm'])){

            if(isset($_POST['password']) && isset($_POST['password2']) && !empty($_POST['password']) && !empty($_POST['password2'])){

                $password =  $_POST['password'];
                $password2 = $_POST['password2'];
                $pseudo = $_POST['pseudo'];

                if($member->countByPseudo($pseudo) == 1){

                    if($password == $password2){

                        $hpassword = password_hash ($_POST['password'], PASSWORD_DEFAULT);
                        $member->resetPass($hpassword,$pseudo);
                        header('location: index.php?action=welcome');
                        $this->setFlash('Votre mot de passe à etait modifier','success');

                    }else{
                        echo 'vos mdp ne sont pas identique';
                    }
                }else{
                    echo 'erreur de pseudo';
                }
                
            }else{
                echo 'vous devez rentrer un new mdp';
            }
        }else{
            echo 'prout';
        }
      }

      public function disconnection(){
        $_SESSION = array();
        session_destroy();
        setcookie('id', '');
        setcookie('pseudo', '');
        header('Location: index.php');
      }

}