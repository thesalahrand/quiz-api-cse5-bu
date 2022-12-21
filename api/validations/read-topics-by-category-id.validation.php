<?php
  if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(503);
    echo json_encode(['message' => 'Access denied']);
    exit();
  }

  use Rakit\Validation\Validator;

  $validator = new Validator();

  $_POST = array_map('trim', $_POST);

  $validation = $validator->make($_POST, [
    'categoryId' => 'required'
  ]);
  
  $validation->setMessages([
    'categoryId:required' => 'Category id is required',
  ]);

  $validation->validate();

  if($validation->fails()) {
    http_response_code(400);
    echo json_encode(['message' => $validation->errors()->firstOfAll()[array_key_first($validation->errors()->firstOfAll())]]);
    exit();
  }

  $categories->id = $_POST['categoryId'];

  if(!$categories->readById()->rowCount()) {
    http_response_code(404);
    echo json_encode(['message' => 'Category not found']);
    exit();
  }
?>