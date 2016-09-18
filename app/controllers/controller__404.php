<?php

class controller__404 extends controller
{

  public function action__index() {
    $this->view->generate("main", "error_404");
  }

}