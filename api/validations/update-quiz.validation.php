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
    'question' => 'max:65535',
    'options' => 'json',
    'correctOptions' => 'json'
  ]);
  
  $validation->setMessages([
    'id:required' => 'Quiz id is required',
    'question:max' => 'Question should not exceed 65535 characters',
    'options:json' => 'Options are not in correct format',
    'correctOptions:json' => 'Correct options are not in correct format'
  ]);

  $validation->validate();

  if($validation->fails()) {
    http_response_code(400);
    echo json_encode(['message' => $validation->errors()->firstOfAll()[array_key_first($validation->errors()->firstOfAll())]]);
    exit();
  }

  $quiz->id = $_POST['id'];
  if(!$quiz->readById()->rowCount()) {
    http_response_code(400);
    echo json_encode(['message' => 'Quiz not found']);
    exit();
  }

  $singleQuiz = $quiz->readById()->fetch(PDO::FETCH_ASSOC);

  if(isset($_POST['topicId'])) {
    $topics->id = $_POST['topicId'];
    if(!$topics->readById()->rowCount()) {
      http_response_code(400);
      echo json_encode(['message' => 'Topic not found']);
      exit();
    }
  }

  $options = json_decode($singleQuiz['options'], true);
  if(isset($_POST['options'])) {
    $options = json_decode($_POST['options'], true);
    foreach($options as $option) {
      if(!is_int($option) && !is_string($option)) {
        http_response_code(400);
        echo json_encode(['message' => 'Options are not in correct format']);
        exit();  
      }
    }
  }

  $sanitizedCorrectOptions = [];
  if(isset($_POST['correctOptions'])) {
    $correctOptions = json_decode($_POST['correctOptions'], true);
    foreach($correctOptions as $correctOption) {
      if((!is_int($correctOption) && !is_string($correctOption)) || (int) $correctOption < 0 || (int) $correctOption >= count($options)) {
        http_response_code(400);
        echo json_encode(['message' => 'Correct options are not in correct format']);
        exit();  
      }
      $sanitizedCorrectOptions[] = (int) $correctOption;
    }
    $sanitizedCorrectOptions = array_unique($sanitizedCorrectOptions);
    sort($sanitizedCorrectOptions);
  }
?>