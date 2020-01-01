<?php
namespace App\Manager;
require_once('App/Model/Manager.php');

class TutoManager extends Manager{

    function getTuto(){
      $db = $this->dbconnect();
      $req = $db->prepare('SELECT *
                           FROM Tuto
                           ORDER BY id DESC');
      $req->execute(array());
      $results = $req->fetchAll();
      return $results;
    }

    function newTuto($pseudo,$title,$content){
      $db = $this->dbconnect();
      $req = $db->prepare('INSERT INTO Tuto(author,title,content) VALUES(?,?,?)');
      $affectedLine = $req->execute(array($pseudo,$title,$content));

      return $affectedLine;
    }
}