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



  static public function session_exist() {
    if(isset($_SESSION["user"]["id"])) return true; else return false;
  }



  static public function get($column) {

    $data = database::check("users", ["id" => self::$id], true, "all");

    switch($column) {
      case "id": return $data["id"]; break;
      case "access": return $data["access"]; break;
      case "is_active": return $data["is_active"]; break;
      case "status": return $data["status"]; break;
      case "email": return $data["email"]; break;
      case "name": return $data["name"]; break;
      case "lastname": return $data["lastname"]; break;
      case "birthday": return $data["birthday"]; break;
    }

    return false;

  }



  static public function create_hash($value_01 = "", $value_02 = "") {

    if((!empty($value_01)) && (!empty($value_02))) {
      $future_hash = $value_01.$value_02;
    } elseif(isset($_POST["email"])) {
      $future_hash = $_POST["email"].time();
    } elseif(self::session_exist()) {
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



  static public function have_hash($hash) {
    if(database::check("users", ["hash" => $hash])) return true; else route::error();
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