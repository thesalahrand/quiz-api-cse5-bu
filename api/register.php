<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-type: application/json; charset=UTF-8');
  header('Access-Control-Allow-Methods: POST'); 

  require dirname(__DIR__) . '/vendor/autoload.php';

  $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
  $dotenv->safeLoad();

  use \config\Database;
  use \models\Users;

  $database = new Database();
  $db = $database->connect();

  $users = new Users($db);

  if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(503);
    echo json_encode(['message' => 'Access denied']);
    exit();
  }

  $_POST = array_map('trim', $_POST);
  
  $users->phone = $_POST['phone'];
  $users->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $users->createdAt = date('Y-m-d H:i:s', time());
  $users->updatedAt = date('Y-m-d H:i:s', time());

  require __DIR__ . '/validations/register.validation.php';

  if(!$users->create()) {
    http_response_code(500);
    echo json_encode(['message' => 'Server error']);
    exit();
  }

  http_response_code(200);
  echo json_encode(['message' => 'User successfully registered']);
?>