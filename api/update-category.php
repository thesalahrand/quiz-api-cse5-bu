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

  $config = new Config();

  $database = new Database();
  $db = $database->connect();

  $users = new Users($db);
  $categories = new Categories($db);

  require __DIR__ . '/validations/is-logged-in.validation.php';
  require __DIR__ . '/validations/update-category.validation.php';

  $singleCategory = $categories->readById()->fetch(PDO::FETCH_ASSOC);

  $categories->title = !isset($_POST['title']) || !$_POST['title'] ? $singleCategory['title'] : $_POST['title'];
  $categories->categoryPic = $singleCategory['categoryPic'];
  $categories->updatedAt = date('Y-m-d H:i:s', time());

  if(isset($_FILES['categoryPic'])) {
    $res = Config::uploadFile($_FILES['categoryPic'], Config::$CATEGORY_PIC_UPLOAD_DIR);

    if(!$res) {
      http_response_code(500);
      echo json_encode(['message' => 'Failed to upload the category picture']);
      exit();
    } else {
      if($categories->categoryPic) {
        $oldCategoryPicLoc = __DIR__ . '/../' . $categories->categoryPic;
        file_exists($oldCategoryPicLoc) && unlink($oldCategoryPicLoc);
      }
      $categories->categoryPic = $res;
    }
  }

  if(!$categories->update()) {
    http_response_code(500);
    echo json_encode(['message' => 'Server error']);
    exit();
  }

  $singleCategory = $categories->readById()->fetch(PDO::FETCH_ASSOC);

  http_response_code(200);
  echo json_encode($singleCategory);
?>