<?php
  $server = 'localhost';
  $login = 'root';
  $mdp = 'root';
  try {
      $linkpdo = new PDO("mysql:host=$server;dbname=cabinet", $login, $mdp);
  }
  catch (Exception $e) {
      die('Erreur : ' . $e->getMessage());
  };
 ?>
