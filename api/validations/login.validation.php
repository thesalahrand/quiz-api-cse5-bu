<?php
  use Rakit\Validation\Validator;

  $validator = new Validator();

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
?>