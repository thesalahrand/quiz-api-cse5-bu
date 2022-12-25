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
    'id' => 'required'
  ]);
  
  $validation->setMessages([
    'id:required' => 'Quiz id is required'
  ]);

  $validation->validate();

  if($validation->fails()) {
    http_response_code(400);
    echo json_encode(['message' => $validation->errors()->firstOfAll()[array_key_first($validation->errors()->firstOfAll())]]);
    exit();
  }

  $quiz->id = $_POST['id'];

  if(!$quiz->readById()->rowCount()) {
    http_response_code(404);
    echo json_encode(['message' => 'Quiz not found']);
    exit();
  }
?>