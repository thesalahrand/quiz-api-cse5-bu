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
  require __DIR__ . '/validations/read-topics-by-category-id.validation.php';

  $topics->categoryId = $_POST['categoryId'];

  $allTopics = $topics->readByCategoryId()->fetchAll(PDO::FETCH_ASSOC);

  http_response_code(200);
  echo json_encode($allTopics);
?>