<?php
namespace App\Manager;
require_once('App/Model/Manager.php');

class AstucesManager extends Manager{

    function getAstuces($id){
      $db = $this->dbconnect();
      $req = $db->prepare('SELECT Astuces.id,title,content,id_astuce,id_membre FROM Astuces
      LEFT JOIN Validate_astuce on Astuces.id = Validate_astuce.id_astuce
      
      AND id_membre = ?
      ORDER BY id DESC');
      $req->execute(array($id));
      $results = $req->fetchAll();
      return $results;
    }

    function validateAstuce($id_astuce,$id_membre){
      $db = $this->dbconnect();
      $req = $db->prepare('INSERT INTO Validate_astuce(id_astuce,id_membre) VALUES (?,?)');
      $affectedline = $req->execute(array($id_astuce,$id_membre));

      return $affectedline;
    }

    function astuceExiste($id_astuce){
      $db = $this->dbconnect();
      $req = $db->prepare('SELECT * FROM Astuces WHERE id=?');
      $req->execute(array($id_astuce));
      $result = $req->rowCount();

      return $result;
    }

    function checkValidate($idAstuce,$idMembre){
      $db = $this->dbconnect();
      $req = $db->prepare('SELECT id FROM Validate_astuce WHERE id_astuce=? AND id_membre=?');
      $req->execute(array($idAstuce,$idMembre));
      $results = $req->rowCount();
      return $results;

    }

    function getAstuceForUser($id){
      $db = $this->dbconnect();
      $req = $db->prepare('SELECT Astuces.id,title,content,id_astuce,id_membre FROM Astuces
                          LEFT JOIN Validate_astuce on Astuces.id = Validate_astuce.id_astuce
                          
                          WHERE id_membre = ?
                          ORDER BY id DESC');
      $req->execute(array($id));
      $results = $req->fetchAll();
      return $results;
    }
}