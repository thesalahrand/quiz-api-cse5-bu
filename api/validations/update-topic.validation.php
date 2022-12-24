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
    'topicPic' => 'uploaded_file:0,500K,png,jpeg'
  ]);
  
  $validation->setMessages([
    'id:required' => 'Topic id is required',
    'title:max' => 'Title should not exceed 50 characters',
    'topicPic:uploaded_file' => 'Topic picture should be jpeg/png and not exceed 500 KB'
  ]);

  $validation->validate();

  if($validation->fails()) {
    http_response_code(400);
    echo json_encode(['message' => $validation->errors()->firstOfAll()[array_key_first($validation->errors()->firstOfAll())]]);
    exit();
  }

  $topics->id = $_POST['id'];

  if(!$topics->readById()->rowCount()) {
    http_response_code(404);
    echo json_encode(['message' => 'Topic not found']);
    exit();
  }

  if(isset($_POST['categoryId'])) {
    $categories->id = $_POST['categoryId'];
    
    if(!$categories->readById()->rowCount()) {
      http_response_code(404);
      echo json_encode(['message' => 'Category not found']);
      exit();
    }
  }

  $singleTopic = $topics->readById()->fetch(PDO::FETCH_ASSOC);
  $topics->title = !isset($_POST['title']) || !$_POST['title'] ? $singleTopic['title'] : $_POST['title'];
  $topics->categoryId = !isset($_POST['categoryId']) || !$_POST['categoryId'] ? $singleTopic['categoryId'] : $_POST['categoryId'];  

  if((isset($_POST['title']) && $_POST['title']) || isset($_POST['categoryId'])) {
    if($topics->readByTitleCategoryId()->rowCount()) {
      $singleTopic = $topics->readByTitleCategoryId()->fetch(PDO::FETCH_ASSOC);
      if($singleTopic['id'] != $topics->id) {
        http_response_code(400);
        echo json_encode(['message' => 'Title already exists under this category']);
        exit();
      }
    }
  }
?>