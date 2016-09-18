<?php

class controller__sign_in extends controller
{

  public function action__index() {
    $this->view->generate("main", "sign_in");
  }


  public function action__auth() {
    route::check_post_data();
    if( ($error = $this->model->auth()) !== true ) $this->view->generate("main", "sign_in", $error);
    else route::redirect();
  }



  public function action__forgot() {
    if(empty($_POST)) $this->view->generate("main", "sign_in--forgot");
    else {
      if( ($error = $this->model->forgot()) !== true ) $this->view->generate("main", "sign_in--forgot", $error);
      else $this->view->generate("main", "sign_in--forgot", $message = ["info" => [
          "success" => "Если указанный E-mail зарегистрирован, то на него придет письмо, в котором Вы сможете восстановить доступ к вашему профилю!",
          "email" => $_POST["email"]]]);
    }
  }


  public function action__recovery() {

    if(empty($_POST)) {
      route::check_get_data(true, "hash", 1);
      user::have_hash($_GET["hash"]);
      $this->model->prerecovery();
      $this->view->generate("main", "sign_in--recovery");

    } else {
      if( ($error = $this->model->recovery()) !== true ) $this->view->generate("main", "sign_in--recovery", $error);
      else $this->view->generate("main", "sign_in--recovery", $message = ["info" => ["success" => "Смена пароля прошла успешно. Теперь вы можете зайди под новым паролем!"]]);
    }

  }

}