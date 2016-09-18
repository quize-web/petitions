<?php

final class route
{

  private static $instance;
  private function __construct() {}
  private function __clone() {}


  public static $host;
  public static $current_url;
  public static $controller_url;
  public static $action_url;

  public static $views_path;
  public static $models_path;
  public static $controllers_path;

  public static $model;
  public static $controller;

  public static $controller_name;
  public static $action_name;



  public static function start() {

    if(!(self::$instance instanceof self)) {
      self::$instance = new self();
    }


    self::$host = "http://{$_SERVER['HTTP_HOST']}";
    self::$current_url = self::$host.$_SERVER["REQUEST_URI"];

    self::$views_path = "app/views";
    self::$models_path = "app/models";
    self::$controllers_path = "app/controllers";

    $views_path = self::$views_path;
    $models_path = self::$models_path;
    $controllers_path = self::$controllers_path;

    $controller_name = "main";
    $action_name = "index";


    $address = explode("/", $_SERVER["REQUEST_URI"]);

    if(!empty($address[1])) {
      $controller_name = $address[1];
    }

    if(!empty($address[2])) {
      $action_name = $address[2];
      $action_name = explode("?", $action_name); // убираем гет запрос, если вдруг он есть и мешает найти наш экшн
      $action_name = $action_name["0"];
    }

    self::$controller_name = $controller_name;
    self::$controller_url = self::$host."/".$controller_name;
    self::$action_name = $action_name;
    self::$action_url = self::$controller_url."/".self::$action_name;

    $model_name = $controller_name;
    $model = "model__$model_name";
    $model_file = "$models_path/$model.php";

    if(file_exists($model_file)) {
      self::$model = $model;
      include_once($model_file);
    }


    $action = "action__$action_name";
    $controller = "controller__$controller_name";
    $controller_file = "$controllers_path/$controller.php";

    if(file_exists($controller_file)) {
      self::$controller = $controller;
      include_once($controller_file);
      $controller_class = new $controller;
      if(method_exists($controller_class, $action)) $controller_class->$action(); else self::error();
    } else self::error();


    return self::$instance;

  }



  public static function error($type = "404") {

    $host = self::$host;

    switch ($type) {
      case "404":
        header("HTTP/1.0 404 Not Found");
        header("HTTP/1.1 404 Not Found");
        header("Status: 404 Not Found");
        header("Location: $host/404");
        break;
    }

  }



  public static function check_post_data($condition = true, $post_have = "", $post_count = "") {

    if($condition === true) {
      if(empty($_POST)) self::error();
    } elseif($condition === false) {
      if(!empty($_POST)) self::error();
    }

    if(!empty($post_have)) {
      if(empty($_POST[$post_have])) self::error();
    }

    if(!empty($post_count)) {
      if(count($_POST) != $post_count) self::error();
    }

  }



  public static function check_get_data($condition = true, $get_have = "", $get_count = "") {

    if($condition === true) {
      if(empty($_GET)) self::error();
    } elseif($condition === false) {
      if(!empty($_GET)) self::error();
    }

    if(!empty($get_have)) {
      if(empty($_GET[$get_have])) self::error();
    }

    if(!empty($get_count)) {
      if(count($_GET) != $get_count) self::error();
    }

  }



  public static function check_session($condition = true) {
    if($condition === true) {
      if(!user::session_exist()) self::error();
    } elseif($condition === false) {
      if(user::session_exist()) self::error();
    }
  }



  public static function redirect($to = "index") {

    switch ($to) {
      case "to_controller_index": header("Location: ".self::$controller_url); break;
      case "index": header("Location: ".self::$host); break;
      default: header("Location: ".self::$host); break;
    }

  }



  public static function check_page($url) {
    if($_SERVER["REQUEST_URI"] == $url) return true; else return false;
  }

}