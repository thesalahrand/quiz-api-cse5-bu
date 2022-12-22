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
    'topicId' => 'required',
    'answers' => 'required|json'
  ]);
  
  $validation->setMessages([
    'phone:required' => 'Topic id is required',
    'answers:required' => 'Answers are required',
    'answers:json' => 'Invalid answers format'
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

  $sanitizedAnswers = [];

  $answers = json_decode($_POST['answers'], true);

  foreach($answers as $answer) {
    if(!isset($answer['questionId']) || !isset($answer['chosenOptions'])) continue;
    if((!is_int($answer['questionId']) && !is_string($answer['questionId'])) || !is_array($answer['chosenOptions']) || ($answer['chosenOptions'] !== array_values($answer['chosenOptions']))) continue;

    $quiz->id = $answer['questionId'];
    if(!$quiz->readById()->rowCount()) continue;
    $singleQuiz = $quiz->readById()->fetch(PDO::FETCH_ASSOC);

    $validChosenOptions = true;
    for($i = 0; $i < count($answer['chosenOptions']); $i++) {
      if(!is_int($answer['chosenOptions'][$i]) && !is_string($answer['chosenOptions'][$i])) {
        $validChosenOptions = false;
        break;
      }

      $answer['chosenOptions'][$i] = (int) $answer['chosenOptions'][$i];

      if($answer['chosenOptions'][$i] < 0 || $answer['chosenOptions'][$i] >= count(json_decode($singleQuiz['options'], true))) {
        $validChosenOptions = false;
        break;
      }
    }
    if(!$validChosenOptions) continue;

    if($answer['chosenOptions'] !== array_unique($answer['chosenOptions'], SORT_NUMERIC)) continue;

    sort($answer['chosenOptions']);

    $sanitizedAnswers[] = [
      'questionId' => $answer['questionId'],
      'chosenOptions' => $answer['chosenOptions']
    ];
  }

  $sanitizedAnswers = array_unique($sanitizedAnswers, SORT_REGULAR);
  if(!count($sanitizedAnswers)) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid answers format']);
    exit();
  }
?>