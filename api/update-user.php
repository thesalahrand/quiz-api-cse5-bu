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
  require __DIR__ . '/validations/update-user.validation.php';

  $singleUser = $users->readById()->fetch(PDO::FETCH_ASSOC);

  $users->firstName = !isset($_POST['firstName']) || !$_POST['firstName'] ? $singleUser['firstName'] : $_POST['firstName'];
  $users->lastName = !isset($_POST['lastName']) || !$_POST['lastName'] ? $singleUser['lastName'] : $_POST['lastName'];
  $users->phone = !isset($_POST['phone']) || !$_POST['phone'] ? $singleUser['phone'] : $_POST['phone'];
  $users->password = !isset($_POST['password']) || !$_POST['password'] ? $singleUser['password'] : password_hash($_POST['password'], PASSWORD_DEFAULT);
  $users->profilePic = $singleUser['profilePic'];
  $users->updatedAt = date('Y-m-d H:i:s', time());

  if(isset($_FILES['profilePic'])) {
    $res = Config::uploadFile($_FILES['profilePic'], Config::$PROFILE_PIC_UPLOAD_DIR);

    if(!$res) {
      http_response_code(500);
      echo json_encode(['message' => 'Failed to upload the profile picture']);
      exit();
    } else {
      if($users->profilePic) {
        unlink(__DIR__ . '/../' . $users->profilePic);
      }
      $users->profilePic = $res;
    }
  }

  if(!$users->update()) {
    http_response_code(500);
    echo json_encode(['message' => 'Server error']);
    exit();
  }

  $singleUser = $users->readById()->fetch(PDO::FETCH_ASSOC);
  unset($singleUser['password']);

  http_response_code(200);
  echo json_encode($singleUser);
?>