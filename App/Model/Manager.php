<?php
namespace App\Model;

class Manager
{

  protected function dbconnect()
  {
    try
      {
        $db = new \PDO('mysql:host=localhost;dbname=dad_in_formation;charset=utf8', 'root', 'root');
        return $db;
      }
        catch(\Exception $e)
      {
        die('Erreur : '.$e->getMessage());
      }
  }
}