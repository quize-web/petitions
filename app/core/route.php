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
      $controller_name = explode("?", $controller_name); // убираем гет запрос, если вдруг он есть и мешает найти наш контроллер
      $controller_name = $controller_name["0"];
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

//////////////////////////////////////////////

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

//////////////////////////////////////////////

  public static function post_data($condition = true, $post_have = [], $post_count = "") {

    if($condition === true) {
      if(empty($_POST)) return false;
    } elseif($condition === false) {
      if(!empty($_POST)) return false;
    }

    if(!empty($post_count)) {
      if(count($_POST) != $post_count) return false;
    }

    if(!empty($post_have)) {
      foreach($post_have as $key => $value) {
        if( (!isset($value)) || (empty($value)) || ($value == "") || ($value == "random") )  {
          if( (!isset($_POST[$key])) || (empty($_POST[$key])) ) return false;
        } else {
          if( (!isset($_POST[$key])) || (empty($_POST[$key])) || ($_POST[$key] != $value) ) return false;
        }
      }
    }

    return true;
  }

//////////////////////////////////////////////

  public static function get_data($condition = true, $get_have = [], $get_count = "") {

    if($condition === true) {
      if(empty($_GET)) return false;
    } elseif($condition === false) {
      if(!empty($_GET)) return false;
    }

    if(!empty($get_count)) {
      if(count($_GET) != $get_count) return false;
    }

    if(!empty($get_have)) {
      foreach($get_have as $key => $value) {
        if( (!isset($value)) || (empty($value)) || ($value == "") || ($value == "random") )  {
          if( (!isset($_GET[$key])) || (empty($_GET[$key])) ) return false;
        } else {
          if( (!isset($_GET[$key])) || (empty($_GET[$key])) || ($_GET[$key] != $value) ) return false;
        }
      }
    }

    return true;

  }

//////////////////////////////////////////////

  public static function redirect($to = "index", $get_params = []) {

    if(is_array($get_params)) {
      $get_string = "";
      if(!empty($get_params)) {
        $get_string = "?";
        foreach($get_params as $key => $value) {
          if($get_string == "?") $get_string .= "$key=$value";
          else $get_string .= "&$key=$value";
        }
      }
    } else $get_string = $get_params;

    switch ($to) {
      case "self": header("Location: ".self::$current_url.$get_string); break;
      case "action": header("Location: ".self::$action_url.$get_string); break;
      case "controller": header("Location: ".self::$controller_url.$get_string); break;
      case "index": header("Location: ".self::$host.$get_string); break;
      default: header("Location: ".self::$host.$to.$get_string); break;
    }

    exit();

  }

//////////////////////////////////////////////

  public static function check($function, $action_function = "default") {
    if(!$function) {
      switch ($action_function) {
        case "default": self::error(); break;
        default: return $action_function; break;
      }
    }
    return true;
  }

//////////////////////////////////////////////

  public static function page($url) {
    if($_SERVER["REQUEST_URI"] == $url) return true; else return false;
  }

//////////////////////////////////////////////

  public static function array_to_string($data, $delimiter = "&", $deep_delimiter = "__", $return_string = true, $get_key = "") {
    $array = [];
    $get_value = "";
    $string = "";


    if(!empty($data)) {
      foreach($data as $key => $value) {
        $get_key .= $key.$deep_delimiter;

        if(is_array($value)) {
          $array = array_merge($array, self::array_to_string($value, "&", "__", false, $get_key));
          $get_key = trim($get_key, $deep_delimiter);
          $get_key = trim($get_key, $key);
        } else {
          $get_key = trim($get_key, $deep_delimiter);
          $array[$get_key] = $value;
          $get_key = trim($get_key, $key);
        }

      }
    }


    if($return_string === false) return $array;
    else {
      foreach($array as $key => $value) {
        $string .= "$key=$value".$delimiter;
      }
      $string = trim($string, $delimiter);
      return $string;
    }
  }

//////////////////////////////////////////////

  public static function string_to_array($string, $delimiter = "&", $deep_delimiter = "__", $from_array = false) {

    if($from_array === false) {

      $inner_array = explode($delimiter, $string);
      $outer_array = [];

      foreach($inner_array as $key => $value) {
        $element = explode("=", $value); // $element: [0] = key, [1] = value;

        if(preg_match("/$deep_delimiter/", $element[0])) {
          $deep = explode($deep_delimiter, $element[0]);
          $code = '$outer_array';
          $i = 0;
          foreach($deep as $level) {
            $code .= '[$deep['.$i++.']]';
          }
          $code .= ' = $element[1];';
          eval($code);

        } else $outer_array[$element[0]] = $element[1];
      }

      return $outer_array;


    } else {

      $outer_array = [];

      foreach($string as $key => $value) {

        if(preg_match("/$deep_delimiter/", $key)) {
          $deep = explode($deep_delimiter, $key);
          $code = '$outer_array';
          $i = 0;
          foreach($deep as $level) {
            $code .= '[$deep['.$i++.']]';
          }
          $code .= ' = $value;';
          eval($code);

        } else $outer_array[$key] = $value;
      }

      return $outer_array;

      }

  }

  //////////////////////////////////////////////

  public static function action($value) {
    if( (isset($_GET["action"])) && ($_GET["action"] == $value) ) return true; else return false;
  }

}










