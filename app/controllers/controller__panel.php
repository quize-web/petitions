<?php

class controller__panel extends controller
{

  public function action__index() {
    route::check_session();
    if(user::get("access") == "-u") $this->view->generate("panel", "panel--user");
    elseif(user::get("access") == "-a") $this->view->generate("panel", "panel--admin");
    else route::error();
  }

}