<?php

final class database
{

  private static $instance;
  private function __construct() {}
  private function __clone() {}

  private static $host = "localhost";
  private static $dbname = "petitions";
  private static $user = "root";
  private static $password = "";

  private static $pdo;



  public static function start() {

    if(!(self::$instance instanceof self)) {
      self::$instance = new self();
    }


    try {
      self::$pdo = new PDO("mysql:host=".self::$host.";dbname=".self::$dbname, self::$user, self::$password);
    } catch (PDOException $e) {
      echo "Возникла ошибка при соеденении с базой данных. Ошибка: ".$e->getMessage();
    }


    return self::$instance;

  }

  //////////////////////////////////////////////

  public static function check($table_name, $check__array, $return = false, $what_return = "id") {

    $pdo = self::$pdo;

    $check__string = "";
    $check__values = [];

    foreach($check__array as $column => $value) {
      $check__string .= "`$column` = ? AND ";
      $check__values[] = $value;
    }
    $check__string = trim($check__string, " AND ");

    $query = $pdo->prepare("SELECT * FROM `$table_name` WHERE $check__string;");
    $query->execute($check__values); if(!$query) die(print "Ошибка при выборке данных: {$pdo->errorInfo()["2"]}.");
    $data = $query->fetchAll(PDO::FETCH_ASSOC);

    if(!empty($data)) {
      if($return == true) {
        if($what_return == "all") {
          return $data[0];
        } else return $data[0][$what_return];
      } else return true;
    } else return false;

  }

  //////////////////////////////////////////////

  public static function get($table_names, $what_return = ["*"], $condition = [], $return_value = false) {

    $pdo = self::$pdo;


    $main_table_name = "`$table_names`";
    $table_names = "`$table_names`";
    $condition__string = "";
    $condition__values = [];
    $what_return__string = "";


    foreach($what_return as $column => $name) {
      if(preg_match("/ -> /", $column)) {
        $column = explode(" -> ", $column);
        $table_names .= ", `$column[1]`"; // [~~~_id -> tname -> column]
        $condition__string .= " AND $main_table_name.`$column[0]` = `$column[1]`.`id`";
      }
      $condition__string = trim($condition__string, " AND ");
    }


    if($what_return != ["*"]) {
      foreach($what_return as $column => $name) {

        if(!empty($column_name = $name)); else $column_name = $column;

        if(preg_match("/ -> /", $column)) { // это все для объеденения с другой таблицей --- [~~~_id -> tname -> column]
          $column = explode(" -> ", $column);
          if($column_name != $name) { // задаем ключ объекту массива если он не задан, просчитываем варианты
            if(!empty(explode("_id", $column[0], -1))) $column_name = explode("_id", $column[0])[0]; // прием с эксплодом, если не содержится разделителя в строке, то возвращает пустой массив
            elseif(!empty(explode("id_", $column[0], -1))) $column_name = explode("id_", $column[0])[1];
            else $column_name = "$column[1]__$column[2]"; } // задаем имя столбца, чтобы вдруг не совпадало с именем столбца основной таблицы

          $what_return__string .= ", `$column[1]`.`$column[2]` as '$column_name'";

        } else $what_return__string .= ", $main_table_name.`$column` as '$column_name'";
      }

      $what_return__string = trim($what_return__string, ", ");
    } else $what_return__string = "*";


    if(!empty($condition)) {
      foreach($condition as $column => $value) {
        $condition__string .= " AND `$column` = ?";
        $condition__values[] = $value;
      }
      $condition__string = trim($condition__string, " AND ");
    }


//    return "SELECT $what_return__string FROM $table_names WHERE $condition__string;";
    if( !empty($condition__string) || !empty($condition__values) ) {
      $query = $pdo->prepare("SELECT $what_return__string FROM $table_names WHERE $condition__string;");
      $query->execute($condition__values); if(!$query) die(print "Ошибка при выборке данных: {$pdo->errorInfo()["2"]}.");
    } else {
      $query = $pdo->prepare("SELECT $what_return__string FROM $table_names;");
      $query->execute(); if(!$query) die(print "Ошибка при выборке данных: {$pdo->errorInfo()["2"]}.");
    }


    if($return_value !== true) $data = $query->fetchAll(PDO::FETCH_ASSOC);
    elseif($return_value === true) {
      $what_return__string = trim(explode(".", explode(" as ", $what_return__string)[0])[1], "`"); // тримим и эксплодим вид `tname`.`value` as 'name' в value
      $data = $query->fetch(PDO::FETCH_ASSOC)[$what_return__string];
    } else return "Ошибка в аргументе return_value!";

    if(empty($data)) return false;
    else return $data;

  }

  //////////////////////////////////////////////

  public static function update_new($table_name, $ids = [], $updates = [], $return = false) {

    $pdo = self::$pdo;

    $update_columns = "";
    $update_values = [];
    foreach($updates as $column => $value) {
      $update_columns .= ", `$column` = ?";
      $update_values[] = $value;
    }
    $update_columns = trim($update_columns, ", ");

    $ids__string = "";
    foreach($ids as $id) {
      $ids__string .= "OR `id` = ?";
      $update_values[] = $id;
    }
    $ids__string = trim($ids__string, "OR ");


    $query = $pdo->prepare("UPDATE `$table_name` SET $update_columns WHERE $ids__string;");
    $query->execute($update_values); if(!$query) die(print "Ошибка при изменении данных: {$pdo->errorInfo()["2"]}.");
    if($return === true) return $updates; else return true;

  }

  //////////////////////////////////////////////

  public static function update($table_name, $id, $column, $value, $return = false) {

    $pdo = self::$pdo;

    $query = $pdo->prepare("UPDATE `$table_name` SET `$column` = :value WHERE `id` = :id;");
    $query->execute(["id" => $id, "value" => $value]); if(!$query) die(print "Ошибка при изменении данных: {$pdo->errorInfo()["2"]}.");
    if($return === true) return $value; else return true;

  }

  //////////////////////////////////////////////

  public static function insert($table_name, $data, $empty = false, $return_id = false) {

    $pdo = self::$pdo;


    if($empty === true) {

      $query = $pdo->prepare("INSERT INTO `$table_name` () VALUES ();");
      $query->execute(); if(!$query) die(print "Ошибка при добавлении данных: {$pdo->errorInfo()["2"]}.");

      $id = $pdo->lastInsertId();
      $query = $pdo->prepare("SELECT * FROM `$table_name` WHERE `id` = '".$id."';");
      $query->execute(); if(!$query) die(print "Ошибка при выборке данных: {$pdo->errorInfo()["2"]}.");
      $data = $query->fetchAll(PDO::FETCH_ASSOC);

      if(empty($data)) die(print "Ошибка при добавлении данных.");
      elseif($return_id === true) return $id;
      else return true;


    } elseif($empty === false) {

      $values = [];
      $columns = "";
      $qmarks = "";
      $where_string = "";


      foreach($data as $column => $value) {
        if(empty($value)) continue;
        $values[] = $value;

        $columns .= "$column, ";
        $qmarks .= "?, ";
      }

      $columns = trim($columns, ", ");
      $qmarks = trim($qmarks, ", ");


      $query = $pdo->prepare("INSERT INTO `$table_name` ($columns) VALUES ($qmarks);");
      $query->execute($values); if(!$query) die(print "Ошибка при добавлении данных: {$pdo->errorInfo()["2"]}.");

      $id = $pdo->lastInsertId();
      $query = $pdo->prepare("SELECT * FROM `$table_name` WHERE `id` = '".$id."';");
      $query->execute($values); if(!$query) die(print "Ошибка при выборке данных: {$pdo->errorInfo()["2"]}.");
      $data = $query->fetchAll(PDO::FETCH_ASSOC);

      if(empty($data)) die(print "Ошибка при добавлении данных.");
      elseif($return_id === true) return $id;
      else return true;

    } else return false;

  }

  //////////////////////////////////////////////

  public static function delete($table_name, $id) {

    $pdo = self::$pdo;

    $query = $pdo->prepare("DELETE FROM `$table_name` WHERE `id` = ?;");
    $query->execute([$id]); if(!$query) die(print "Ошибка при выборке данных: {$pdo->errorInfo()["2"]}.");

  }

}