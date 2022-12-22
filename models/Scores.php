<?php
  namespace models;

  class Scores {
    private $conn;
    private $tableName = 'scores';

    public $id;
    public $questionsCnt;
    public $correctAnsCnt;
    public $userId;
    public $playedAt;

    public function __construct($db) {
      $this->conn = $db;
    }

    public function read() {
      $query = "SELECT `$this->tableName`.`id`, `$this->tableName`.`questionsCnt`, `$this->tableName`.`correctAnsCnt`, `$this->tableName`.`playedAt`, `users`.`firstName`, `users`.`lastName`, `users`.`profilePic` FROM `$this->tableName`, `users` WHERE `$this->tableName`.`userId` = `users`.`id` ORDER BY (`$this->tableName`.`correctAnsCnt` / `$this->tableName`.`questionsCnt`) DESC";

      $stmt = $this->conn->prepare($query);

      $stmt->execute();

      return $stmt;
    }

    public function readById() {
      $query = "SELECT * FROM `$this->tableName` WHERE `id` = :id;";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':id', $this->id);

      $stmt->execute();

      return $stmt;
    }

    public function create() {
      $query = "INSERT INTO `$this->tableName`(`questionsCnt`, `correctAnsCnt`, `userId`, `playedAt`) VALUES(:questionsCnt, :correctAnsCnt, :userId, :playedAt);";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':questionsCnt', $this->questionsCnt);
      $stmt->bindParam(':correctAnsCnt', $this->correctAnsCnt);
      $stmt->bindParam(':userId', $this->userId);
      $stmt->bindParam(':playedAt', $this->playedAt);

      return $stmt->execute() ? true : false;
    }
  }
?>