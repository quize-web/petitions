<?php

class controller__main extends controller
{

  public function action__index() {
    $data = $this->model->getdata();
    $this->view->generate("main", "home_page", $data);
  }

}