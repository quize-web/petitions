<?php

class model__sign_up
{

  public function verify() {

    if( (empty($_POST["email"])) || (!(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL))) || (strlen($_POST["email"]) > 64) ) { $error["error"]["email"] = "Введите E-mail корректно!";
    } elseif(database::check("users", ["email" => $_POST["email"]])) $error["error"]["email"] = "Пользователь с такой электронной почтой уже существует!";
    if( (empty($_POST["password"])) || (strlen($_POST["password"]) < 6) ) { $error["error"]["password"] = "Пароль слишком короткий!";
    } elseif (($_POST["password"]) !== ($_POST["password_verify"])) $error["error"]["password"] = "Пароли не совпадают!";
    if(!isset($_POST["user_agreement"])) $error["error"]["user_agreement"] = "Необходимо принять пользовательское соглашение!";
    if(!recaptcha::verify()) $error["error"]["recaptcha"] = "Вы не подтвердили, что Вы - человек.";

//    if(!empty($_POST["birthday"])) if(!filter_input(INPUT_POST, "birthday", FILTER_SANITIZE_NUMBER_FLOAT)) $error["error"]["birthday"] = "Введите дату корректно!";
//    if(!empty($_POST["name"])) if(strlen($_POST["name"]) < 2) $error["error"]["name"] = "Введите корректное имя! (слишком короткое)";
//                               elseif (strlen($_POST["name"]) > 32) $error["error"]["name"] = "Введите корректное имя! (слишком длинное)";
//    if(!empty($_POST["lastname"])) if(strlen($_POST["lastname"]) < 2) $error["error"]["lastname"] = "Введите корректную фамилию! (слишком короткая)";
//                                   elseif (strlen($_POST["lastname"]) > 32) $error["error"]["lastname"] = "Введите корректную фамилию! (слишком длинная)";

    if(isset($error)) return $error; else return false;

  }



  public function save() {

    if(!function_exists("hash__password")) { // багает PHP если без проверки
      function hash__password($value) {
        $password = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
        $hash_options = [
            "salt" => md5("PrintScanCopy"),
            "cost" => 12
        ];
        $password_hash = password_hash($password, PASSWORD_DEFAULT, $hash_options);
        return $password_hash;
      }
    }

    $filters = array(
        "email" => FILTER_SANITIZE_EMAIL,
        "password" => array(
            "filter" => FILTER_CALLBACK,
            "options" => "hash__password"
        )
//        "name" => FILTER_SANITIZE_STRING,
//        "lastname" => FILTER_SANITIZE_STRING,
//        "birthday" => FILTER_SANITIZE_NUMBER_FLOAT
    );
    $filtered_array = filter_input_array(INPUT_POST, $filters);

    $filtered_array["hash"] = user::create_hash();

    $hash_url = route::$controller_url."/activate?hash=".$filtered_array["hash"];
    $mail_body = "<a href='$hash_url' target='_blank'>Подтвердить</a> профиль.";
//  $mail_body = $filtered_array["email"];
    if(database::insert("users", $filtered_array)) {
      if(!mail::send($filtered_array["email"], "Подтверждение Вашего профиля", $mail_body)) { echo "ОШИБКА В ОТПАВКЕ ПОЧТЫ!<br>"; return false; }
      else {
        timer::set(10, "resend");
        return $filtered_array["email"];
      }
    } else {
      return false;
    }

  }



  public function resend() {

    $id = user::get("id");
    $email = user::get("email");

    if( (!empty($_COOKIE["user"]["hash"])) && (!empty($_COOKIE["user"]["id"])) ) user::update_cookie_hash($id);
    else user::update_hash($id);

    $hash = user::get("hash");

    $hash_url = route::$controller_url."/activate?hash=".$hash;
    $mail_body = "<a href='$hash_url' target='_blank'>Подтвердить</a> профиль.";
    if(!mail::send($email, "Подтверждение Вашего профиля", $mail_body)) { echo "ОШИБКА В ОТПАВКЕ ПОЧТЫ!<br>"; return false; }
    else {
      timer::set(15, "resend");
      return true;
    }

  }



  public function activate() {

    if($id = database::check("users", ["hash" => $_GET["hash"]], true)) {
      if(!database::check("users", ["id" => $id, "is_active" => 1])) {

        database::update("users", $id, "is_active", 1);
        user::update_hash($id);

        if(user::session()) user::session_destroy();
        else {
          session_unset();
          session_destroy();
          setcookie(session_name(), "");
        }

        timer::destroy("resend");

        return true;

      } else return false;
    } else return false;

  }

}