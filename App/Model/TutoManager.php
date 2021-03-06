<?php
namespace App\Model;

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

    function getTutosHome(){
      $db = $this->dbconnect();
      $req = $db->prepare('SELECT *
                           FROM Tuto
                           ORDER BY id ASC LIMIT 2');
      $req->execute(array());
      $results = $req->fetchAll();
      return $results;
    }

    function getTuto($id){
      $db = $this->dbconnect();
      $req = $db->prepare('SELECT *
                            FROM Tuto WHERE id = ?');
      $req->execute(array($id));
      $affectedLine = $req->fetch();

      return $affectedLine;
    }

    function getTutoByAuthor($id){
      $db = $this->dbconnect();
      $req = $db->prepare('SELECT * FROM Tuto WHERE id_author = ? ORDER BY id DESC');
      $req->execute(array($id));
      $affectedLine = $req->fetchAll();

      return $affectedLine;
    }

    function newTuto($pseudo,$idAstuce,$title,$image,$presentation,$content){
      $db = $this->dbconnect();
      $req = $db->prepare('INSERT INTO Tuto(author,id_author,title,image_link,presentation,content) VALUES(?,?,?,?,?,?)');
      $affectedLine = $req->execute(array($pseudo,$idAstuce,$title,$image,$presentation,$content));

      return $affectedLine;
    }

    function editTuto($title,$presentation,$image,$content,$id){
      $db = $this->dbconnect();
      $req = $db->prepare('UPDATE Tuto SET title=?,image_link=?,presentation=?,content=? WHERE id=?');
      $affectedLine = $req->execute(array($title,$presentation,$image,$content,$id));

      return $affectedLine;
    }

    function getLinkImage($id){
      $db = $this->dbconnect();
      $req = $db->prepare('SELECT image_link FROM Tuto WHERE id =?');
      $req->execute(array($id));
      $result = $req->fetch();

      return $result;
    }

    function deleteTuto($id){
      $db = $this->dbconnect();
      $req = $db->prepare('DELETE FROM Tuto WHERE id=?');
      $affectedLine = $req->execute(array($id));

      return $affectedLine;
    }

    function getTutoForUser($id){
      $db = $this->dbconnect();
      $req = $db->prepare('SELECT Tuto.id,title,presentation,id_tuto,id_membre FROM Tuto
                          LEFT JOIN Validate_tuto on Tuto.id = Validate_tuto.id_tuto
                          
                          WHERE id_membre = ?
                          ORDER BY id DESC');
      $req->execute(array($id));
      $results = $req->fetchAll();
      return $results;
    }

    function countTutoForUser($id){
      $db = $this->dbconnect();
      $req = $db->prepare('SELECT Tuto.id,id_membre FROM Tuto
      LEFT JOIN Validate_tuto on Tuto.id = Validate_tuto.id_tuto
      
      WHERE id_membre = ?');
      $req->execute(array($id));
      $results = $req->rowCount();
      return $results;
    }

    function validateTuto($id_tuto,$id_membre){
      $db = $this->dbconnect();
      $req = $db->prepare('INSERT INTO Validate_tuto(id_tuto,id_membre) VALUES (?,?)');
      $affectedline = $req->execute(array($id_tuto,$id_membre));

      return $affectedline;
    }

    function tutoExiste($id_tuto){
      $db = $this->dbconnect();
      $req = $db->prepare('SELECT * FROM Tuto WHERE id=?');
      $req->execute(array($id_tuto));
      $result = $req->rowCount();

      return $result;
    }

    function checkValidate($idAstuce,$idMembre){
      $db = $this->dbconnect();
      $req = $db->prepare('SELECT id FROM Validate_tuto WHERE id_tuto=? AND id_membre=?');
      $req->execute(array($idAstuce,$idMembre));
      $results = $req->rowCount();
      return $results;

    }

    function deleteValidateTuto($id){
      $db = $this->dbconnect();
      $req = $db->prepare('DELETE FROM Validate_tuto      
                          WHERE id_tuto =?');
      $req->execute(array($id));
      $results = $req->fetchAll();
      return $results;
    }
}