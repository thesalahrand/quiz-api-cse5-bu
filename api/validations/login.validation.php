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
    'phone' => 'required',
    'password' => 'required'
  ]);
  
  $validation->setMessages([
    'phone:required' => 'Phone number is required',
    'password:required' => 'Password is required'
  ]);

  $validation->validate();

  if($validation->fails()) {
    http_response_code(503);
    echo json_encode(['message' => $validation->errors()->firstOfAll()[array_key_first($validation->errors()->firstOfAll())]]);
    exit();
  }

  $users->phone = $_POST['phone'];
  $users->password = $_POST['password'];

  if(!$users->readByPhone()->rowCount()) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid phone number or password']);
    exit();
  }

  $user = $users->readByPhone()->fetch(PDO::FETCH_ASSOC);

  if(!password_verify($users->password, $user['password'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid phone number or password']);
    exit();
  }
?>