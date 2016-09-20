<?php

class controller__about extends controller
{

  public function action__index() {
    $this->view->generate("main", "about");
  }

}