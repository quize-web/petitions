<?php

class controller__sign_up extends controller
{

  public function action__index() {
    route::check_session(false);
    $this->view->generate("main", "sign_up");
  }

  public function action__save() {
    route::check_post_data();
    if($error = $this->model->verify()) { $this->view->generate("main", "sign_up", $error); exit(); }
    if($data = $this->model->save()) $this->view->generate("main", "sign_up--save", $data);
      else $this->view->generate("main", "sign_up", $error = ["error" => ["database" => "Ошибка при добавлении нового пользователя в базу данных!"]]);
  }

  public function action__activate() {
    route::check_get_data(true, "hash", 1);
    if($this->model->activate()) $this->view->generate("main", "sign_up--activate"); else route::error();
  }

}