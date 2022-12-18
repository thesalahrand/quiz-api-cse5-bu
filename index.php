<?php
  // Testing if database connection is okay or not
  require 'vendor/autoload.php';

  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
  $dotenv->safeLoad();

  use \config\Database;

  $database = new Database();
  $database->connect();
?>