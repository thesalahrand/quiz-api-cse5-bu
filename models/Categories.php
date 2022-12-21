<?php
  namespace models;

  class Categories {
    private $conn;
    private $tableName = 'categories';

    public $id;
    public $title;
    public $categoryPic;
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

    public function readByTitle() {
      $query = "SELECT * FROM `$this->tableName` WHERE `title` = :title;";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':title', $this->title);

      $stmt->execute();

      return $stmt;
    }

    public function create() {
      $query = "INSERT INTO `$this->tableName`(`title`, `categoryPic`, `createdAt`, `updatedAt`) VALUES(:title, :categoryPic, :createdAt, :updatedAt);";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':categoryPic', $this->categoryPic);
      $stmt->bindParam(':createdAt', $this->createdAt);
      $stmt->bindParam(':updatedAt', $this->updatedAt);

      return $stmt->execute() ? true : false;
    }

    public function update() {
      $query = "UPDATE `$this->tableName` SET `title` = :title, `categoryPic` = :categoryPic, `createdAt` = :createdAt, `lastUpdated` = :lastUpdated WHERE `id` = :id;";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':categoryPic', $this->categoryPic);
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