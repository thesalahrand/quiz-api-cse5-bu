<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-type: application/json; charset=UTF-8');
  header('Access-Control-Allow-Methods: POST'); 

  require dirname(__DIR__) . '/vendor/autoload.php';

  $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
  $dotenv->safeLoad();

  use \config\Config;
  use \config\Database;
  use \models\Users;
  use \models\Topics;
  use \models\Quiz;
  use \models\Scores;

  $config = new Config();

  $database = new Database();
  $db = $database->connect();

  $users = new Users($db);
  $topics = new Topics($db);
  $quiz = new Quiz($db);
  $scores = new Scores($db);

  require __DIR__ . '/validations/is-logged-in.validation.php';
  require __DIR__ . '/validations/create-score.validation.php';

  $scores->questionsCnt = count($sanitizedAnswers);
  $scores->userId = $users->id;
  $scores->playedAt = date('Y-m-d H:i:s', time());
  $scores->correctAnsCnt = 0;

  $solutionArr = [];

  foreach($sanitizedAnswers as $sanitizedAnswer) {
    $quiz->id = $sanitizedAnswer['questionId'];
    $singleQuiz = $quiz->readById()->fetch(PDO::FETCH_ASSOC);

    $solutionArr[] = [
      'questionId' => $quiz->id,
      'chosenOptions' => $sanitizedAnswer['chosenOptions'],
      'correctOptions' => json_decode($singleQuiz['correctOptions'], true) 
    ];

    if(json_decode($singleQuiz['correctOptions'], true) === $sanitizedAnswer['chosenOptions']) {
      $scores->correctAnsCnt++;
    }
  }

  if(!$scores->create()) {
    http_response_code(500);
    echo json_encode(['message' => 'Server error']);
    exit();
  }

  http_response_code(200);
  echo json_encode([
    'score' => [
      'id' => $db->lastInsertId(),
      'questionsCnt' => $scores->questionsCnt,
      'correctAnsCnt' => $scores->correctAnsCnt,
      'playedAt' => $scores->playedAt
    ],
    'solution' => $solutionArr
  ]);
?>