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

  public function get_petition_templates() {
    $data["petitions"] = database::get( "petition_templates", [
        "name" => "Название",
        "category_id -> petition_categories -> name" => "Категория",
        "price" => "Цена",
        "id" => ""]);
    if(route::action("deleted")) $data["alerts"]["warning"]["deleted"] = "Удалено!";
    return $data;
  }

  //////////////////////////////////////////////

  public function petition_template() { // TODO: РАЗДЕЛИТЬ НА КЛАССЫ

    if(route::get_data()) {

      if(route::get_data(true, ["id" => ""])) { // при имеющимся в бд заявлении

        $id = $_GET["id"];

        if(route::action("delete")) {
          database::delete("petition_templates", $id);
          route::redirect("/panel/petitions", ["action" => "deleted"]);
        }

        if(route::action("petition_saved")) $data["alerts"]["success"]["saved"] = "Шаблон сохранен!";
        if(route::action("field_saved")) $data["alerts"]["success"]["saved"] = "Поле сохранено!";

        if($data["petition"] = database::check("petition_templates", ["id" => $id], true, "all")) {
          if($data["fields"] = database::get("template_fields", ["*"], ["template_id" => $id]));

          if(isset(route::string_to_array($_GET, "", "__", true)["alerts"]))
            $data["alerts"] = route::string_to_array($_GET, "", "__", true)["alerts"];

          return $data;
        } else route::redirect("/panel/petitions");


      } else { // при создании нового (в бд еще не существует заявление)
        if(isset(route::string_to_array($_GET, "", "__", true)["alerts"]))
          $data["alerts"] = route::string_to_array($_GET, "", "__", true)["alerts"];
        return $data;
      }



    } elseif(route::post_data()) {

      if(route::post_data(true, ["is_petition" => "true"])) { // ДЛЯ ЗАЯВЛЕНИЯ

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
            "template_main" => FILTER_SANITIZE_SPECIAL_CHARS
        );
        $filtered_array = filter_input_array(INPUT_POST, $filters);
        if($filtered_array["price"] > 0) $filtered_array["pay"] = 1;

        if( (isset($_POST["id"])) && (!empty($_POST["id"])) ) {
          $id = $_POST["id"];
          database::update_new("petition_templates", [$id], $filtered_array); // TODO: ПЕРЕИМЕНОВАТЬ КЛАСС
        } else {
          $id = database::insert("petition_templates", $filtered_array, false, true);
        }

        route::redirect("action", ["id" => $id, "action" => "petition_saved"]); // route::redirect("action", ["id" => $id, "alerts__success__saved" => "Шаблон сохранен!"]);
        return true;


      } elseif(route::post_data(true, ["is_field" => "true"])) { // ДЛЯ ПОЛЯ

        if( (empty($_POST["name"])) || (strlen($_POST["name"]) < 2) ) $data["alerts"]["error"]["name"] = "Введите корректное имя поля! (слишком короткое)";
        elseif (strlen($_POST["name"]) > 32) $data["alerts"]["error"]["name"] = "Введите корректное имя поля! (слишком длинное)";
        if( (empty($_POST["type"])) || (
            ($_POST["type"] != "text") &&
            ($_POST["type"] != "number") &&
            ($_POST["type"] != "email") &&
            ($_POST["type"] != "tel") &&
            ($_POST["type"] != "date")) ) $data["alerts"]["error"]["type"] = "Введите тип поля корректно!";
        if( (empty($_POST["template_id"])) || ($_POST["template_id"] < 0) || (!(filter_input(INPUT_POST, "template_id", FILTER_SANITIZE_NUMBER_FLOAT))) ) $data["alerts"]["error"]["template_id"] = "Прежде чем добавлять поля, сохраните заявление!";


        if(isset($data)) {
          $data = route::array_to_string($data, "&", "__", false);
          if(isset($_POST["template_id"])) $data["id"] = $_POST["template_id"];
          route::redirect("action", $data);
        }

        $filters = array(
            "name" => FILTER_SANITIZE_STRING,
            "type" => FILTER_SANITIZE_STRING,
            "title" => FILTER_SANITIZE_STRING,
            "description" => FILTER_SANITIZE_STRING,
            "placeholder" => FILTER_SANITIZE_STRING,
            "value" => FILTER_SANITIZE_STRING,
            "template_id" => FILTER_SANITIZE_NUMBER_FLOAT
        );
        $filtered_array = filter_input_array(INPUT_POST, $filters);
        if(isset($_POST["required"])) $filtered_array["required"] = 1; else $filtered_array["required"] = 0;

        if( (isset($_POST["id"])) && (!empty($_POST["id"])) ) {
          $id = $_POST["id"];
          database::update_new("template_fields", [$id], $filtered_array);
        } else {
          database::insert("template_fields", $filtered_array, false, true);
        }

        $template_id = $_POST["template_id"];
        route::redirect("action", ["id" => $template_id, "action" => "field_saved"]); // route::redirect("action", ["id" => $id, "alerts__success__saved" => "Поле сохранено!"]);
        return true;


      } else route::redirect("panel/petitions");



    } else { // НОВОЕ ЗАЯВЛЕНИЕ


      return true;
//      if($id = database::insert("petition_templates", [], true, true)) route::redirect("action", ["id" => $id]);
//      else return false;

    }

  }

}