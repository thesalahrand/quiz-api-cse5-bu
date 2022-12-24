<?php
  namespace config;

  class Config {
    public static $TIMEZONE;
    public static $ROOT_DIR;
    public static $PROFILE_PIC_UPLOAD_DIR;

    public function __construct() {
      self::$ROOT_DIR = $_ENV['ROOT_DIR'];
      self::$TIMEZONE = 'Asia/Dhaka';
      self::$PROFILE_PIC_UPLOAD_DIR = 'uploads/users/';

      date_default_timezone_set(self::$TIMEZONE);
    }

    public static function uploadFile($file) {
      $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
      $randFileName = bin2hex(random_bytes(10));
      $uploadFileName = self::$PROFILE_PIC_UPLOAD_DIR . $randFileName . '.' . $fileExt;
      $uploadFileLoc = __DIR__ . '/../' . $uploadFileName;
      return move_uploaded_file($file['tmp_name'], $uploadFileLoc) ? $uploadFileName : false;
    }
  }
?>