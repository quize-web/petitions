<?php

final class config
{

  private static $instance;
  private function __construct() {}
  private function __clone() {}

  public static $site_name;

  public static function start() {

    if(!(self::$instance instanceof self)) {
      self::$instance = new self();
    }


    self::$site_name = database::get("settings", ["value" => ""], ["name" => "site_name"], true);


    return self::$instance;

  }

}