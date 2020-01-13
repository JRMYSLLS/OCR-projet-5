<?php
namespace App\Model;

class AstucesManager extends Manager{

    function getAstuces($id,$begin,$astucePerPage){
      $db = $this->dbconnect();
      $req = $db->prepare('SELECT Astuces.id,title,content,id_astuce,id_membre,signaled FROM Astuces
      LEFT JOIN Validate_astuce on Astuces.id = Validate_astuce.id_astuce
      
      AND id_membre = ?
      ORDER BY id DESC
      LIMIT '.$begin.','.$astucePerPage.'');
      $req->execute(array($id));
      $results = $req->fetchAll();
      return $results;
    }

    function getAstucesHome(){
      $db = $this->dbconnect();
      $req = $db->prepare('SELECT * FROM Astuces ORDER BY id ASC LIMIT 2');
      $req->execute(array());
      $results = $req->fetchAll();
      return $results;
    }

    function newAstuce($title,$author,$content){
      $db = $this->dbconnect();
      $req = $db->prepare('INSERT INTO Astuces(title,author,content) VALUES (?,?,?)');
      $affectedline = $req->execute(array($title,$author,$content));

      return $affectedline;
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

    function getAstuceByUser($author){
      $db = $this->dbconnect();
      $req = $db->prepare('SELECT * FROM Astuces
                          WHERE author = ?
                          ORDER BY id DESC');
      $req->execute(array($author));
      $results = $req->fetchAll();
      return $results;
    }

    function deleteAstuceForUser($idAstuce,$idMembre){
      $db = $this->dbconnect();
      $req = $db->prepare('DELETE FROM Validate_astuce      
                          WHERE id_astuce =? AND id_membre = ?');
      $req->execute(array($idAstuce,$idMembre));
      $results = $req->fetchAll();
      return $results;
    }

    function deleteAstuceByUser($idAstuce,$idMembre){
      $db = $this->dbconnect();
      $req = $db->prepare('DELETE FROM Astuces      
                          WHERE id =? AND author = ?');
      $req->execute(array($idAstuce,$idMembre));
      $results = $req->fetchAll();
      return $results;
    }

    function deleteValidateAstuce($id){
      $db = $this->dbconnect();
      $req = $db->prepare('DELETE FROM Validate_astuce      
                          WHERE id_astuce =?');
      $req->execute(array($id));
      $results = $req->fetchAll();
      return $results;
    }
    
    function countAstuces(){
      $db = $this->dbconnect();
      $req = $db->prepare('SELECT id FROM Astuces');
      $req->execute(array());
      $results = $req->rowCount();
      return $results;

    }

    function countAstucesForUser($id){
      $db = $this->dbconnect();
      $req = $db->prepare('SELECT Astuces.id,id_membre FROM Astuces
      LEFT JOIN Validate_astuce on Astuces.id = Validate_astuce.id_astuce
      
      WHERE id_membre = ?');
      $req->execute(array($id));
      $results = $req->rowCount();
      return $results;
    }

    function countAstucesByUser($user){
      $db = $this->dbconnect();
      $req = $db->prepare('SELECT id FROM Astuces
      WHERE author = ?');
      $req->execute(array($user));
      $results = $req->rowCount();
      return $results;
    }

    function signalAstuce($id){
      $db = $this->dbconnect();
      $req = $db->prepare('UPDATE Astuces SET signaled=1 WHERE id=?');
      $affectedLine = $req->execute(array($id));

      return $affectedLine;
    }

    function confirmAstuce($id){
      $db = $this->dbconnect();
      $req = $db->prepare('UPDATE Astuces SET signaled=2 WHERE id=?');
      $affectedLine = $req->execute(array($id));

      return $affectedLine;
    }

    function deleteAstuce($id){
      $db = $this->dbconnect();
      $req = $db->prepare('DELETE FROM Astuces WHERE id=?');
      $affectedLine = $req->execute(array($id));

      return $affectedLine;
    }

}