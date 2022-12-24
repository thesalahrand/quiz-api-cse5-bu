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
    'firstName' => 'max:20',
    'lastName' => 'max:20',
    'phone' => 'regex:/^\+8801[3-9]{1}[0-9]{8}$/',
    'password' => 'min:8|max:20|regex:/^[a-zA-Z0-9]{8,20}$/',
    'profilePic' => 'uploaded_file:0,500K,png,jpeg'
  ]);
  
  $validation->setMessages([
    'firstName:max' => 'First name should not exceed 20 characters',
    'lastName:max' => 'Last name should not exceed 20 characters',
    'phone:regex' => 'Phone number must start with +880 and contain 10 digits afterwards',
    'password:min' => 'Password must contain at least 8 characters',
    'password:max' => 'Password may contain at most 20 characters',
    'password:regex' => 'Password should contain only English alphabets and digits',
    'profilePic:uploaded_file' => 'Profile pic should be jpeg/png and not exceed 500 KB'
  ]);

  $validation->validate();

  if($validation->fails()) {
    http_response_code(400);
    echo json_encode(['message' => $validation->errors()->firstOfAll()[array_key_first($validation->errors()->firstOfAll())]]);
    exit();
  }

  if(isset($_POST['phone']) && $_POST['phone']) {
    $users->phone = $_POST['phone'];
    if($users->readByPhone()->rowCount()) {
      $singleUser = $users->readByPhone()->fetch(PDO::FETCH_ASSOC);
      if($singleUser['id'] != $users->id) {
        http_response_code(400);
        echo json_encode(['message' => 'Phone number already used']);
        exit();
      }
    }
  }
?>