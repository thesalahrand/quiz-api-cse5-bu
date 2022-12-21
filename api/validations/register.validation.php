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
    'phone' => 'required|regex:/^\+8801[3-9]{1}[0-9]{8}$/',
    'password' => 'required|min:8|max:20|regex:/^[a-zA-Z0-9]{8,20}$/'
  ]);
  
  $validation->setMessages([
    'phone:required' => 'Phone number is required',
    'phone:regex' => 'Phone number must start with +880 and contain 10 digits afterwards',
    'password:required' => 'Password is required',
    'password:min' => 'Password must contain at least 8 characters',
    'password:max' => 'Password may contain at most 20 characters',
    'password:regex' => 'Password should contain only English alphabets and digits'
  ]);

  $validation->validate();

  if($validation->fails()) {
    http_response_code(503);
    echo json_encode(['message' => $validation->errors()->firstOfAll()[array_key_first($validation->errors()->firstOfAll())]]);
    exit();
  }

  $users->phone = $_POST['phone'];

  if($users->readByPhone()->rowCount()) {
    http_response_code(500);
    echo json_encode(['message' => 'Phone number already used']);
    exit();
  }
?>