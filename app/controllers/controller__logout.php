<?php

class controller__logout extends controller
{

  public function action__index() {
    $this->model->logout();
  }

}