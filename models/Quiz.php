<?php
  namespace models;

  class Quiz {
    private $conn;
    private $tableName = 'quiz';

    public $id;
    public $question;
    public $options;
    public $correctOptions;
    public $topicId;
    public $createdAt;
    public $updatedAt;

    public function __construct($db) {
      $this->conn = $db;
    }

    public function read() {
      $query = "SELECT * FROM `$this->tableName`;";

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

    public function readByTopicId() {
      $query = "SELECT * FROM `$this->tableName` WHERE `topicId` = :topicId;";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':topicId', $this->topicId);

      $stmt->execute();

      return $stmt;
    }

    public function create() {
      $query = "INSERT INTO `$this->tableName`(`question`, `options`, `correctOptions`, `topicId`, `createdAt`, `updatedAt`) VALUES(:question, :options, :correctOptions, :topicId, :createdAt, :updatedAt);";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':question', $this->question);
      $stmt->bindParam(':options', $this->options);
      $stmt->bindParam(':correctOptions', $this->correctOptions);
      $stmt->bindParam(':topicId', $this->topicId);
      $stmt->bindParam(':createdAt', $this->createdAt);
      $stmt->bindParam(':updatedAt', $this->updatedAt);

      return $stmt->execute() ? true : false;
    }

    public function update() {
      $query = "UPDATE `$this->tableName` SET `question` = :question, `options` = :options, `correctOptions` = :correctOptions, `topicId` = :topicId, `createdAt` = :createdAt, `lastUpdated` = :lastUpdated WHERE `id` = :id;";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':question', $this->question);
      $stmt->bindParam(':options', $this->options);
      $stmt->bindParam(':correctOptions', $this->correctOptions);
      $stmt->bindParam(':topicId', $this->topicId);
      $stmt->bindParam(':createdAt', $this->createdAt);
      $stmt->bindParam(':lastUpdated', $this->lastUpdated);
      $stmt->bindParam(':id', $this->id);

      return $stmt->execute() ? true : false;
    }

    public function delete() {
      $query = "DELETE FROM `$this->tableName` WHERE `id` = :id;";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':id', $this->id);

      return $stmt->execute() ? true : false;
    }
  }
?>