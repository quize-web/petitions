<?php

class model__panel
{

  //////////////////////////////////////////////
  // USER PANEL
  //////////////////////////////////////////////

  //



  //////////////////////////////////////////////
  // ADMIN PANEL
  //////////////////////////////////////////////

  public function user_mode() {
    if( (!isset($_SESSION["admin"]["user_mode"])) || ($_SESSION["admin"]["user_mode"] != 1) ) {
      $_SESSION["admin"]["user_mode"] = 1;
    } elseif($_SESSION["admin"]["user_mode"] == 1) {
      $_SESSION["admin"]["user_mode"] = 0;
    }
  }

  //////////////////////////////////////////////

  public function get_users()
  {
    $users_array = database::get("users", [
        "email" => "E-mail",
        "is_active" => "Профиль активирован?"]);
    return $users_array;
  }

  //////////////////////////////////////////////

  public function get_petition_templates()
  {
    $petitions_array = database::get( "petition_templates", [
        "name" => "Название",
        "category_id -> petition_categories -> name" => "Категория",
        "price" => "Цена",
        "id" => ""]);
    return $petitions_array;
  }

  //////////////////////////////////////////////

  public function petition_template() {

    if(route::get_data()) {

      $id = $_GET["id"];

      if( (isset($_GET["action"])) && ($_GET["action"] == "delete") ) {
        database::delete("petition_templates", $id);
        route::redirect("/panel/petitions", ["action" => "deleted"]); // TODO: ДОБАВИТЬ АЛЕРТ
      }
      if( (isset($_GET["action"])) && ($_GET["action"] == "saved") ) $data["alerts"]["success"]["saved"] = "Сохранено!";

      if($data["petition"] = database::check("petition_templates", ["id" => $id], true, "all")) {
        if(isset(route::string_to_array($_GET, "", "__", true)["alerts"]))
          $data["alerts"] = route::string_to_array($_GET, "", "__", true)["alerts"];
        return $data;
      } else return false;


    } elseif(route::post_data()) {

      if( (empty($_POST["name"])) || (strlen($_POST["name"]) < 2) ) $data["alerts"]["error"]["name"] = "Введите корректное название! (слишком короткое)";
      elseif (strlen($_POST["name"]) > 128) $data["alerts"]["error"]["name"] = "Введите корректное название! (слишком длинное)";
      if( (empty($_POST["price"])) || ($_POST["price"] < 0) || (!(filter_input(INPUT_POST, "price", FILTER_SANITIZE_NUMBER_FLOAT))) ) $data["alerts"]["error"]["price"] = "Введите цену корректно!";
      if( (empty($_POST["category_id"])) || ($_POST["category_id"] < 0) || (!(filter_input(INPUT_POST, "price", FILTER_SANITIZE_NUMBER_FLOAT))) ) $data["alerts"]["error"]["price"] = "Корректно выберите категорию!";

      if(isset($data)) {
        $data = route::array_to_string($data, "&", "__", false);
        if(isset($_POST["id"])) $data["id"] = $_POST["id"];
        route::redirect("action", $data);
      }

      $filters = array(
          "name" => FILTER_SANITIZE_STRING,
          "price" => FILTER_SANITIZE_NUMBER_FLOAT,
          "category_id" => FILTER_SANITIZE_NUMBER_FLOAT,
          "template" => FILTER_SANITIZE_SPECIAL_CHARS,
          "template_main" => FILTER_SANITIZE_SPECIAL_CHARS,
      );
      $filtered_array = filter_input_array(INPUT_POST, $filters);
      if($filtered_array["price"] > 0) $filtered_array["pay"] = 1;
      
      if( (isset($_POST["id"])) && (!empty($_POST["id"])) ) {
        $id = $_POST["id"];
        database::update_new("petition_templates", [$id], $filtered_array); // TODO: ПЕРЕИМЕНОВАТЬ КЛАСС
      } else {
        $id = database::insert("petition_templates", $filtered_array, false, true);
      }

      route::redirect("action", ["id" => $id, "action" => "saved"]); // route::redirect("action", ["id" => $id, "alerts__success__saved" => "Сохранено!"]);
      return true;


    } else {


      return true;
//      if($id = database::insert("petition_templates", [], true, true)) route::redirect("action", ["id" => $id]);
//      else return false;

    }

  }

}