<?php

class timer
{

  public static function set($time, $name = "main") {
    $_SESSION["timer"] = [];
    $_SESSION["timer"][$name] = time()+60*$time;
    setcookie("timer[$name]", time()+60*$time, time()+60*$time, "/");
  }


  public static function destroy($name = "main") {
    unset($_SESSION["timer"][$name]);
    setcookie("timer[$name]", "", time()-3600, "/");
  }


  public static function work($name = "main") {
    if( (isset($_SESSION["timer"][$name])) && ($_SESSION["timer"][$name] > time()) ) return true;
    if( (isset($_COOKIE["timer"][$name])) && ($_COOKIE["timer"][$name] > time()) ) return true;
    return false;
  }


  public static function get($name = "main") {
    if( (isset($_SESSION["timer"][$name])) && (!empty($_SESSION["timer"][$name])) ) {
      $timer = $_SESSION["timer"][$name]; return ($timer - time());
    }
    if( (isset($_COOKIE["timer"][$name])) && (!empty($_COOKIE["timer"][$name])) ) {
      $timer = $_COOKIE["timer"][$name]; return ($timer - time());
    }
    else return false;
  }

}