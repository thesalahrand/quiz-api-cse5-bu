<?php
  namespace models;

  class Users {
    private $conn;
    private $tableName = 'users';

    public $id;
    public $firstName;
    public $lastName;
    public $phone;
    public $password;
    public $profilePic;
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

    public function readByPhone() {
      $query = "SELECT * FROM `$this->tableName` WHERE `phone` = :phone;";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':phone', $this->phone);

      $stmt->execute();

      return $stmt;
    }

    public function create() {
      $query = "INSERT INTO `$this->tableName`(`phone`, `password`, `createdAt`, `updatedAt`) VALUES(:phone, :password, :createdAt, :updatedAt);";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':phone', $this->phone);
      $stmt->bindParam(':password', $this->password);
      $stmt->bindParam(':createdAt', $this->createdAt);
      $stmt->bindParam(':updatedAt', $this->updatedAt);

      return $stmt->execute() ? true : false;
    }

    public function update() {
      $query = "UPDATE `$this->tableName` SET `firstName` = :firstName, `lastName` = :lastName, `phone` = :phone, `password` = :password, `profilePic` = :profilePic, `updatedAt` = :updatedAt WHERE `id` = :id;";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':firstName', $this->firstName);
      $stmt->bindParam(':lastName', $this->lastName);
      $stmt->bindParam(':phone', $this->phone);
      $stmt->bindParam(':password', $this->password);
      $stmt->bindParam(':profilePic', $this->profilePic);
      $stmt->bindParam(':updatedAt', $this->updatedAt);
      $stmt->bindParam(':id', $this->id);

      return $stmt->execute() ? true : false;
    }
  }
?>