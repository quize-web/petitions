<?php

class model__sign_in
{

  public function auth() {

    if(
        (empty($_POST["email"])) ||
        (empty($_POST["password"])) ||
        (strlen($_POST["email"]) > 64) ||
        (strlen($_POST["password"]) < 6) ||
        (!(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL)))
    ) $error["error"]["auth"] = "Пароль или E-mail введены не корректно!";

    if(!recaptcha::verify()) $error["error"]["recaptcha"] = "Вы не подтвердили, что Вы - человек.";


    $filters = array(
        "email" => FILTER_SANITIZE_EMAIL,
        "password" => FILTER_UNSAFE_RAW
    );

    $filtered_array = filter_input_array(INPUT_POST, $filters);
    $email = $filtered_array["email"];
    $password = $filtered_array["password"];

    if($id = database::check("users", ["email" => $email], true)) {
      if($password_hash = database::check("users", ["id" => $id], true, "password")) {
        if(password_verify($password, $password_hash)) {
        } else $error["error"]["auth"] = "Пароль или E-mail введены не корректно!";
      } else $error["error"]["auth"] = "Пароль или E-mail введены не корректно!";
    } else $error["error"]["auth"] = "Пароль или E-mail введены не корректно!";

    if(isset($error)) return $error;

    $_SESSION["user"]["id"] = $id;

    if(isset($_POST["remember"])) user::update_cookie_hash($id);
    else user::delete_cookie_hash();

    return true;

  }



  public function forgot() {

    if (
        (empty($_POST["email"])) ||
        (strlen($_POST["email"]) > 64) ||
        (!(filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL)))
    ) $error["error"]["auth"] = "E-mail введен не корректно!";

    if (!recaptcha::verify()) $error["error"]["recaptcha"] = "Вы не подтвердили, что Вы - человек.";

    if(isset($error)) return $error;


    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    if( $user_array = database::check("users", ["email" => $email], true, "all") ) {
      $to = $user_array["email"];
      $hash = $user_array["hash"];
      $hash_url = route::$controller_url."/recovery?hash=".$hash;
      $mail_body = "<a href='$hash_url' target='_blank'>Восстановить</a> пароль.";
      mail::send($to, "Восстановление пароля", $mail_body);
    }

    return true;

  }



  public function prerecovery() {

    $id = database::check("users", ["hash" => $_GET["hash"]], true);
    $_SESSION["recovery"]["id"] = $id;

  }



  public function recovery() {

    if( (empty($_POST["password"])) || (strlen($_POST["password"]) < 6) ) { $error["error"]["password"] = "Пароль слишком короткий!";
    } elseif (($_POST["password"]) !== ($_POST["password_verify"])) $error["error"]["password"] = "Пароли не совпадают!";
    if(!recaptcha::verify()) $error["error"]["recaptcha"] = "Вы не подтвердили, что Вы - человек.";
    if(isset($error)) return $error;

    $password = filter_var($_POST["password"], FILTER_SANITIZE_SPECIAL_CHARS);
    $hash_options = ["salt" => md5("PrintScanCopy"), "cost" => 12];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT, $hash_options);

    $id = $_SESSION["recovery"]["id"];
    database::update("users", $id, "password", $hashed_password);
    user::update_hash($id);

    user::session_destroy();
    return true;

  }

}