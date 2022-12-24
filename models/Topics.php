<?php
  namespace models;

  class Topics {
    private $conn;
    private $tableName = 'topics';

    public $id;
    public $title;
    public $topicPic;
    public $categoryId;
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

    public function readByCategoryId() {
      $query = "SELECT * FROM `$this->tableName` WHERE `categoryId` = :categoryId;";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':categoryId', $this->categoryId);

      $stmt->execute();

      return $stmt;
    }

    public function readByTitleCategoryId() {
      $query = "SELECT * FROM `$this->tableName` WHERE lower(`title`) = lower(:title) AND `categoryId` = :categoryId;";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':categoryId', $this->categoryId);

      $stmt->execute();

      return $stmt;
    }

    public function create() {
      $query = "INSERT INTO `$this->tableName`(`title`, `topicPic`, `categoryId`, `createdAt`, `updatedAt`) VALUES(:title, :topicPic, :categoryId, :createdAt, :updatedAt);";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':topicPic', $this->topicPic);
      $stmt->bindParam(':categoryId', $this->categoryId);
      $stmt->bindParam(':createdAt', $this->createdAt);
      $stmt->bindParam(':updatedAt', $this->updatedAt);

      return $stmt->execute() ? true : false;
    }

    public function update() {
      $query = "UPDATE `$this->tableName` SET `title` = :title, `topicPic` = :topicPic, `categoryId` = :categoryId, `createdAt` = :createdAt, `updatedAt` = :updatedAt WHERE `id` = :id;";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':topicPic', $this->topicPic);
      $stmt->bindParam(':categoryId', $this->categoryId);
      $stmt->bindParam(':createdAt', $this->createdAt);
      $stmt->bindParam(':updatedAt', $this->updatedAt);
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