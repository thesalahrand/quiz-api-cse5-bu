<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-type: application/json; charset=UTF-8');
  header('Access-Control-Allow-Methods: POST'); 

  require dirname(__DIR__) . '/vendor/autoload.php';

  $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
  $dotenv->safeLoad();

  use \config\Config;
  use \config\Database;
  use \models\Users;

  $config = new Config();

  $database = new Database();
  $db = $database->connect();

  $users = new Users($db);

  require __DIR__ . '/validations/is-logged-in.validation.php';

  $allUsers = $users->read()->fetchAll(PDO::FETCH_ASSOC);
  $allUsersNew = [];
  foreach($allUsers as $eachUser) {
    unset($eachUser['password']);
    $allUsersNew[] = $eachUser;
  }

  http_response_code(200);
  echo json_encode($allUsersNew);
?>