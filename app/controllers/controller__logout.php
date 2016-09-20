<?php

class controller__logout extends controller
{

  public function action__index() {
    route::check(user::session());

    $this->model->logout();
  }

}