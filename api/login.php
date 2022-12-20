<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-type: application/json; charset=UTF-8');
  header('Access-Control-Allow-Methods: POST'); 

  require dirname(__DIR__) . '/vendor/autoload.php';

  $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
  $dotenv->safeLoad();

  use \config\Database;
  use \models\Users;
  use Firebase\JWT\JWT;
  use Firebase\JWT\Key;

  $database = new Database();
  $db = $database->connect();

  $users = new Users($db);

  if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(503);
    echo json_encode(['message' => 'Access denied']);
    exit();
  }

  require __DIR__ . '/validations/login.validation.php';

  $users->phone = $_POST['phone'];
  $users->password = $_POST['password'];

  if(!$users->readByPhone()->rowCount()) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid phone number or password']);
    exit();
  }

  $user = $users->readByPhone()->fetch(PDO::FETCH_ASSOC);

  if(!password_verify($users->password, $user['password'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid phone number or password']);
    exit();
  }

  $payload = [
    'id' => $user['id']
  ];
  $jwt = JWT::encode($payload, $_ENV['JWT_SECRET_KEY'], 'HS256');

  http_response_code(200);
  echo json_encode(['jwt' => $jwt]);
?>