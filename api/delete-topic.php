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
  use \models\Topics;

  $config = new Config();

  $database = new Database();
  $db = $database->connect();

  $users = new Users($db);
  $topics = new Topics($db);

  require __DIR__ . '/validations/is-logged-in.validation.php';
  require __DIR__ . '/validations/delete-topic.validation.php';

  $singleTopic = $topics->readById()->fetch(PDO::FETCH_ASSOC);
  
  if(!$topics->delete()) {
    http_response_code(500);
    echo json_encode(['message' => 'Server error']);
    exit();
  }

  $topicPicLoc = __DIR__ . '/../' . $singleTopic['topicPic'];
  file_exists($topicPicLoc) && unlink($topicPicLoc);

  http_response_code(200);
  echo json_encode($singleTopic);
?>