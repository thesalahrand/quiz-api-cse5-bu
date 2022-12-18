<?php
  namespace config;

  class Config {
    public static $TIMEZONE;
    public static $ROOT_DIR;

    public function __construct() {
      self::$ROOT_DIR = $_ENV['ROOT_DIR'];
      self::$TIMEZONE = 'Asia/Dhaka';

      date_default_timezone_set(self::$TIMEZONE);
    }
  }
?>