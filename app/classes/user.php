<?php

final class user
{

  private static $instance;
  private function __construct() {}
  private function __clone() {}

  private static $id;


  static public function start() {

    if(!(self::$instance instanceof self)) {
      self::$instance = new self();
    }

    session_start();


    if(isset($_SESSION["user"]["id"])) {

      self::$id = $_SESSION["user"]["id"];


    } elseif ( (isset($_COOKIE["user"]["hash"])) && (isset($_COOKIE["user"]["id"])) ) {

      if($id = database::check("users", ["hash" => $_COOKIE["user"]["hash"]], true, "id")) {

        if($id == $_COOKIE["user"]["id"]) {
          $_SESSION["user"]["id"] = $id;
          self::$id = $_SESSION["user"]["id"];
        } else self::delete_cookie_hash();

      } else self::delete_cookie_hash();

    } else if((isset($_COOKIE["user"]["hash"])) || (isset($_COOKIE["user"]["id"]))) self::delete_cookie_hash();


    return self::$instance;

  }



  static public function session($condition = true) {
    if($condition === true) { if(isset($_SESSION["user"]["id"])) return true; else return false; }
    elseif($condition === false) { if(!isset($_SESSION["user"]["id"])) return true; else return false; }
    else return false;
  }



  static public function get($column) {

    $data = database::check("users", ["id" => self::$id], true, "all");

    switch($column) {
      case "id": return $data["id"]; break;
      case "hash": return$data["hash"]; break;
      case "access": return $data["access"]; break;
      case "is_active": return $data["is_active"]; break;
      case "email": return $data["email"]; break;
      case "status": return $data["status"]; break;
//      case "name": return $data["name"]; break;
//      case "lastname": return $data["lastname"]; break;
//      case "birthday": return $data["birthday"]; break;
    }

    return false;

  }



  static public function is_active($condition = true) {
    if($condition === true) { if(self::get("is_active") == 1) return true; else return false; }
    elseif($condition === false) { if(self::get("is_active") == 0) return true; else return false; }
    else return false;
  }



  static public function access($who = "user") {
    switch ($who) {
      case "user": if( (self::get("access") == "-u") || (self::user_mode()) ) return true; else return false;
      case "admin": if(self::get("access") == "-a") return true; else return false;
      default: return false;
    }
  }



  static public function user_mode($condition = true) {
    if($condition === true) {
      if( (isset($_SESSION["admin"]["user_mode"])) && ($_SESSION["admin"]["user_mode"] == 1) ) return true; else return false;
    } elseif($condition === false) {
      if( (!isset($_SESSION["admin"]["user_mode"])) || ($_SESSION["admin"]["user_mode"] == 0) ) return true; else return false;
    } else return false;
  }



  public static function post_data($condition = true, $post_have = "", $post_count = "") {

    if($condition === true) {
      if(empty($_POST)) return false;
    } elseif($condition === false) {
      if(!empty($_POST)) false;
    }

    if(!empty($post_have)) {
      if(empty($_POST[$post_have])) false;
    }

    if(!empty($post_count)) {
      if(count($_POST) != $post_count) false;
    }

    return true;
  }



  public static function get_data($condition = true, $get_have = "", $get_count = "") {

    if($condition === true) {
      if(empty($_GET)) false;
    } elseif($condition === false) {
      if(!empty($_GET)) false;
    }

    if(!empty($get_have)) {
      if(empty($_GET[$get_have])) false;
    }

    if(!empty($get_count)) {
      if(count($_GET) != $get_count) false;
    }

    return true;

  }



  static public function have_hash($hash) {
    if(database::check("users", ["hash" => $hash])) return true;
    else { route::error(); return false; }
  }



  static public function create_hash($value_01 = "", $value_02 = "") {

    if((!empty($value_01)) && (!empty($value_02))) {
      $future_hash = $value_01.$value_02;
    } elseif(isset($_POST["email"])) {
      $future_hash = $_POST["email"].time();
    } elseif(self::session()) {
      $future_hash = self::get("email").time();
    } else {
      $future_hash = "random".time();
    }

    $hash_options = [
        "salt" => md5("PrintScanCopy"),
        "cost" => 12
    ];
    $user_hash = password_hash($future_hash, PASSWORD_DEFAULT, $hash_options);

    return $user_hash;

  }



  static public function delete_hash($id) {
    database::update("users", $id, "hash", "");
  }



  static public function update_hash($id, $return = false) {
    $hash = database::update("users", $id, "hash", self::create_hash(), true);
    if($return === true) return $hash; else return true;
  }



  static public function delete_cookie_hash($id = "") {
    if(!empty($id)) self::delete_hash($id);
    setcookie("user[hash]", "", (time()-3600), "/");
    setcookie("user[id]", "", (time()-3600), "/");
  }



  static public function update_cookie_hash($id) {
    self::delete_cookie_hash($id);
    $hash = self::update_hash($id, true);
    setcookie("user[id]", $id, (time()+3600*24*7), "/");
    setcookie("user[hash]", $hash, (time()+3600*24*7), "/");
  }



  static public function session_destroy() {
    self::update_hash(self::$id);
    self::delete_cookie_hash();
    session_unset();
    session_destroy();
    setcookie(session_name(), "");
    self::$id = "";
  }

}