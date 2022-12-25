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
  use \models\Categories;
  use \models\Topics;

  $config = new Config();

  $database = new Database();
  $db = $database->connect();

  $users = new Users($db);
  $categories = new Categories($db);
  $topics = new Topics($db);

  require __DIR__ . '/validations/is-logged-in.validation.php';
  require __DIR__ . '/validations/create-topic.validation.php';

  $topics->topicPic = null;
  $topics->createdAt = date('Y-m-d H:i:s', time());
  $topics->updatedAt = date('Y-m-d H:i:s', time());

  if(isset($_FILES['topicPic'])) {
    $res = Config::uploadFile($_FILES['topicPic'], Config::TOPIC_PIC_UPLOAD_DIR);

    if(!$res) {
      http_response_code(500);
      echo json_encode(['message' => 'Failed to upload the topic picture']);
      exit();
    } else {
      $topics->topicPic = $res;
    }
  }

  if(!$topics->create()) {
    http_response_code(500);
    echo json_encode(['message' => 'Server error']);
    exit();
  }

  $topics->id = $db->lastInsertId();
  $singleTopic = $topics->readById()->fetch(PDO::FETCH_ASSOC);

  http_response_code(200);
  echo json_encode($singleTopic);
?>