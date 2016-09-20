<?php

class controller__sign_up extends controller
{

  public function action__index() {
    route::check(user::session(false));

    $this->view->generate("main", "sign_up");
  }

  public function action__save() {
    route::check(user::post_data());

    if($error = $this->model->verify()) { $this->view->generate("main", "sign_up", $error); exit(); }
    if($email = $this->model->save()) $this->view->generate("main", "sign_up--save", $email);
      else $this->view->generate("main", "sign_up", $error = ["error" => ["database" => "Ошибка при добавлении нового пользователя в базу данных!"]]);
  }

  public function action__activate() {
    route::check(user::get_data(true, "hash", 1));

    if($this->model->activate()) $this->view->generate("main", "sign_up--activate");
    else route::error();
  }

  public function action__resend() {
    route::check(user::is_active());

    if(timer::work("resend")) route::redirect("/panel");
    elseif($this->model->resend()) route::redirect("/panel");
    else route::error();
  }

}