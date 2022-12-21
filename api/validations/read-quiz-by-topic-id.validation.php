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
    'topicId' => 'required'
  ]);
  
  $validation->setMessages([
    'topicId:required' => 'Topic id is required',
  ]);

  $validation->validate();

  if($validation->fails()) {
    http_response_code(400);
    echo json_encode(['message' => $validation->errors()->firstOfAll()[array_key_first($validation->errors()->firstOfAll())]]);
    exit();
  }

  $topics->id = $_POST['topicId'];

  if(!$topics->readById()->rowCount()) {
    http_response_code(404);
    echo json_encode(['message' => 'Topic not found']);
    exit();
  }
?>