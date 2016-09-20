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
    public static $templates_path;
    public static $contents_path;
    public static $units_path;
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
      self::$templates_path = "templates";
      self::$contents_path = "contents";
      self::$units_path = "units";
    self::$models_path = "app/models";
    self::$controllers_path = "app/controllers";

    $views_path = self::$views_path;
      $templates_path = self::$templates_path;
      $contents_path = self::$contents_path;
      $units_path = self::$units_path;
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



  public static function redirect($to = "index") {

    switch ($to) {
      case "controller_index": header("Location: ".self::$controller_url); break;
      case "index": header("Location: ".self::$host); break;
      default: header("Location: ".self::$host.$to); break;
    }

  }



  public static function check($function, $action_function = "default") {
    if(!$function) {
      switch ($action_function) {
        case "default": self::error(); break;
        default: return $action_function; break;
      }
    }
    return true;
  }



  public static function page($url) {
    if($_SERVER["REQUEST_URI"] == $url) return true; else return false;
  }

}