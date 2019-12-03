<?php
namespace App\Manager;
require_once('App/Model/Manager.php');

class MembersManager extends Manager{
    
    public function registration($pseudo,$mail,$password,$confirmKey){
        $db = $this->dbconnect();
        $req = $db->prepare('INSERT INTO Members(pseudo,mail,mdp,confirmKey) VALUES(?,?,?,?)');
        $affectedline = $req->execute(array($pseudo,$mail,$password,$confirmKey));

        return $affectedline;
      }

      public function isRegistred($mail){
        $db = $this->dbconnect();
        $req = $db->prepare('SELECT mail FROM Members WHERE mail=?');
        $req->execute(array($mail));
        $result = $req->rowCount();

        return $result;
      }

      public function verifyForConfirm($pseudo,$confirmKey){
        $db = $this->dbconnect();
        $req = $db->prepare('SELECT * FROM Members WHERE pseudo=? AND confirmKey=?');
        $req->execute(array($pseudo,$confirmKey));
        $result = $req->rowCount();

        return $result;
      }

      public function isRegistredForConfirm($pseudo){
        $db = $this->dbconnect();
        $req = $db->prepare('SELECT * FROM Members WHERE pseudo =? AND confirm=0');
        $req->execute(array($pseudo));
        $result = $req->fetch();

        return $result;
      }

      public function confirm($pseudo,$confirmKey){
        $db = $this->dbconnect();
        $req = $db->prepare('UPDATE Members SET confirm=1 WHERE pseudo=? AND confirmKey=?');
        $result = $req->execute(array($pseudo,$confirmKey));

        return $result;
      }

      public function isAlreadyUsed($pseudo){
        $db = $this->dbconnect();
        $req = $db->prepare('SELECT * FROM Members WHERE pseudo=?');
        $req->execute(array($pseudo));
        $result = $req->rowCount();

        return $result;
      }

      public function selectByMail($mail){
        $db = $this->dbconnect();
        $req = $db->prepare('SELECT * FROM Members WHERE mail=?');
        $req->execute(array($mail));
        $result = $req->fetch();

        return $result;
      }

      public function countByPseudo($pseudo){
        $db = $this->dbconnect();
        $req = $db->prepare('SELECT * FROM Members WHERE pseudo=?');
        $req->execute(array($pseudo));
        $result = $req->rowCount();

        return $result;
      }

      public function resetPass($mdp,$pseudo){
        $db = $this->dbconnect();
        $req = $db->prepare('UPDATE Members SET mdp=? WHERE pseudo=?');
        $result = $req->execute(array($mdp,$pseudo));

        return $result;
      }
}