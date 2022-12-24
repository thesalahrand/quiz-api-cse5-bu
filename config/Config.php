<?php
  namespace config;

  class Config {
    public static $ROOT_DIR;
    public static $TIMEZONE = 'Asia/Dhaka';
    public static $PROFILE_PIC_UPLOAD_DIR = 'uploads/users/';
    public static $CATEGORY_PIC_UPLOAD_DIR = 'uploads/categories/';
    public static $TOPIC_PIC_UPLOAD_DIR = 'uploads/topics/';

    public function __construct() {
      self::$ROOT_DIR = $_ENV['ROOT_DIR'];

      date_default_timezone_set(self::$TIMEZONE);
    }

    public static function uploadFile($file, $uploadDir) {
      $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
      $randFileName = bin2hex(random_bytes(10));
      $uploadFileName = $uploadDir . $randFileName . '.' . $fileExt;
      $uploadFileLoc = __DIR__ . '/../' . $uploadFileName;
      return move_uploaded_file($file['tmp_name'], $uploadFileLoc) ? $uploadFileName : false;
    }
  }
?>