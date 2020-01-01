<?php
namespace App\Manager;
require_once('App/Model/Manager.php');

class TutoManager extends Manager{

    function getTutos(){
      $db = $this->dbconnect();
      $req = $db->prepare('SELECT *
                           FROM Tuto
                           ORDER BY id DESC');
      $req->execute(array());
      $results = $req->fetchAll();
      return $results;
    }

    function getTuto($id){
      $db = $this->dbconnect();
      $req = $db->prepare('SELECT *
                            FROM tuto WHERE id = ?');
      $req->execute(array($id));
      $affectedLine = $req->fetch();

      return $affectedLine;
    }

    function newTuto($pseudo,$title,$presentation,$content){
      $db = $this->dbconnect();
      $req = $db->prepare('INSERT INTO Tuto(author,title,presentation,content) VALUES(?,?,?,?)');
      $affectedLine = $req->execute(array($pseudo,$title,$presentation,$content));

      return $affectedLine;
    }
}