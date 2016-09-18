<?php

final class database
{

  private static $instance;
  private function __construct() {}
  private function __clone() {}

  private static $host = "localhost";
  private static $dbname = "mvc-shop";
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



  public static function update($table_name, $id, $column, $value, $return = false) {

    $pdo = self::$pdo;

    $query = $pdo->prepare("UPDATE `$table_name` SET `$column` = :value WHERE `id` = :id;");
    $query->execute(["id" => $id, "value" => $value]); if(!$query) die(print "Ошибка при изменении данных: {$pdo->errorInfo()["2"]}.");
    if($return === true) return $value; else return true;
  }



  public static function insert($table_name, $data) {

    $pdo = self::$pdo;


    $values = [];
    $columns = "";
    $qmarks = "";
    $where_string = "";


    foreach($data as $column => $value) {
      if(empty($value)) continue;
      $values[] = $value;

      $columns .= "$column, ";
      $qmarks .= "?, ";

      $where_string .= "`$column` = ? AND ";
    }

    $columns = trim($columns, ", ");
    $qmarks = trim($qmarks, ", ");
    $where_string = trim($where_string, " AND ");


    $query = $pdo->prepare("INSERT INTO `$table_name` ($columns) VALUES ($qmarks);");
    $query->execute($values); if(!$query) die(print "Ошибка при добавлении данных: {$pdo->errorInfo()["2"]}.");

    $query = $pdo->prepare("SELECT * FROM `$table_name` WHERE $where_string;");
    $query->execute($values); if(!$query) die(print "Ошибка при выборке данных: {$pdo->errorInfo()["2"]}.");
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    if(empty($data)) return false; else return true;

  }



  public static function delete($table_name, $id) {

    $pdo = self::$pdo;

    $query = $pdo->prepare("DELETE FROM `$table_name` WHERE `id` = ?;");
    $query->execute([$id]); if(!$query) die(print "Ошибка при выборке данных: {$pdo->errorInfo()["2"]}.");

  }

}