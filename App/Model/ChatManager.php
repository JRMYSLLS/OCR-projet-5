<?php
namespace App\Manager;
require_once('App/Model/Manager.php');

class ChatManager extends Manager{

    function getMessage(){
        $db = $this->dbconnect();
        $req = $db->prepare('SELECT id,membre,content,DATE_FORMAT(dtime, \'%H:%i\') AS dtime 
                            FROM chat WHERE dtime>DATE_SUB(now(),interval 1 DAY)
                            ORDER BY id DESC');
        $req->execute(array());
        $results = $req->fetchAll();

        return $results;
    }

    function postMessage($membre,$message){
        $db = $this->dbconnect();
        $req = $db->prepare('INSERT INTO chat(membre,content,dtime) VALUES(?,?,NOW())');
        $affectedline = $req->execute(array($membre,$message));

        return $affectedline;
    }
}