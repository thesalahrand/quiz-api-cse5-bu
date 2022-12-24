<?php
  if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(503);
    echo json_encode(['message' => 'Access denied']);
    exit();
  }

  use Rakit\Validation\Validator;

  $_POST = array_map('trim', $_POST);

  $validator = new Validator();

  $validation = $validator->make($_POST, [
    'id' => 'required',
    'title' => 'max:50',
    'categoryPic' => 'uploaded_file:0,500K,png,jpeg'
  ]);
  
  $validation->setMessages([
    'id:required' => 'Category id is required',
    'title:max' => 'Title should not exceed 50 characters',
    'categoryPic:uploaded_file' => 'Category picture should be jpeg/png and not exceed 500 KB'
  ]);

  $validation->validate();

  if($validation->fails()) {
    http_response_code(400);
    echo json_encode(['message' => $validation->errors()->firstOfAll()[array_key_first($validation->errors()->firstOfAll())]]);
    exit();
  }

  $categories->id = $_POST['id'];

  if(!$categories->readById()->rowCount()) {
    http_response_code(404);
    echo json_encode(['message' => 'Category not found']);
    exit();
  }

  if(isset($_POST['title']) && $_POST['title']) {
    $categories->title = $_POST['title'];
    if($categories->readByTitle()->rowCount()) {
      $singleCategory = $categories->readByTitle()->fetch(PDO::FETCH_ASSOC);
      if($singleCategory['id'] != $categories->id) {
        http_response_code(400);
        echo json_encode(['message' => 'Title already exists']);
        exit();
      }
    }
  }
?>