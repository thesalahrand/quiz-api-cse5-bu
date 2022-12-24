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
    'title' => 'required|max:50',
    'topicPic' => 'uploaded_file:0,500K,png,jpeg',
    'categoryId' => 'required'
  ]);
  
  $validation->setMessages([
    'title:required' => 'Title is required',
    'title:max' => 'Title should not exceed 50 characters',
    'topicPic:uploaded_file' => 'Topic picture should be jpeg/png and not exceed 500 KB',
    'categoryId:required' => 'Category is required'
  ]);

  $validation->validate();

  if($validation->fails()) {
    http_response_code(400);
    echo json_encode(['message' => $validation->errors()->firstOfAll()[array_key_first($validation->errors()->firstOfAll())]]);
    exit();
  }

  $categories->id = $_POST['categoryId'];

  if(!$categories->readById()->rowCount()) {
    http_response_code(400);
    echo json_encode(['message' => 'Category not found']);
    exit();
  }

  $topics->title = $_POST['title'];
  $topics->categoryId = $_POST['categoryId'];

  if($topics->readByTitleCategoryId()->rowCount()) {
    http_response_code(400);
    echo json_encode(['message' => 'Title already exists under this category']);
    exit();
  }
?>