<?php

class controller__sign_in extends controller
{

  public function action__index() {
    route::check(user::session(false));

    $this->view->generate("main", "sign_in");
  }


  public function action__auth() {
    route::check(route::post_data());

    if( ($errors = $this->model->auth()) !== true ) $this->view->generate("main", "sign_in", $errors);
    else route::redirect("index");
  }



  public function action__forgot() {
    route::check(user::session(false));

    if(empty($_POST)) $this->view->generate("main", "sign_in--forgot");
    else {
      if( ($errors = $this->model->forgot()) !== true ) $this->view->generate("main", "sign_in--forgot", $errors);
      else $this->view->generate("main", "sign_in--forgot", $message = ["alerts" => ["info" => [
          "success" => "Если указанный E-mail зарегистрирован, то на него придет письмо, в котором Вы сможете восстановить доступ к вашему профилю!",
          "email" => $_POST["email"]
      ]]]);
    }
  }


  public function action__recovery() {
    route::check(user::session(false));

    if(route::get_data()) {
      route::check(route::get_data(true, ["hash" => ""], 1));
      user::have_hash($_GET["hash"]);
      $this->model->prerecovery();
      $this->view->generate("main", "sign_in--recovery");

    } elseif(route::post_data()) {
      if( ($data = $this->model->recovery()) !== true ) $this->view->generate("main", "sign_in--recovery", $data);
      else $this->view->generate("main", "sign_in--recovery", $message = ["alerts" => ["info" => ["success" => "Смена пароля прошла успешно. Теперь вы можете зайди под новым паролем!"]]]);
    } else route::error();

  }

}