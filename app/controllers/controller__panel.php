<?php

class controller__panel extends controller
{

  public function action__index() {
    route::check(user::session());

    if (user::is_active(false)) $this->view->generate("user_panel", "user_panel--not_active");

    if(user::access("user")) $this->view->generate("user_panel", "user_panel");
    elseif(user::access("admin")) $this->view->generate("admin_panel", "admin_panel");
    else route::error();
  }



  public function action__petitions() {
    route::check(user::session());

    if (user::is_active(false)) $this->view->generate("user_panel", "user_panel--not_active");

    if(user::access("user")) $this->view->generate("user_panel", "user_panel--petitions");
    elseif(user::access("admin")) $this->view->generate("admin_panel", "admin_panel--petitions");
    else route::error();
  }



  public function action__petition() {
    route::check(user::session());

    if (user::is_active(false)) $this->view->generate("user_panel", "user_panel--not_active");

    if(user::access("user")) {
      $this->view->generate("user_panel", "user_panel--petition");
    }
    elseif(user::access("admin")) {
      $this->view->generate("admin_panel", "admin_panel--petition");
    } else route::error();
  }


  /////////////////////////////////////
  // USER PANEL (use ...)
  ////////////////////////////////////

  //



  /////////////////////////////////////
  // ADMIN PANEL (use ...)
  ////////////////////////////////////

  //

  public function action__user_mode() {
    route::check(user::session());
    route::check(user::access("admin"));

    $this->model->user_mode();
    route::redirect("controller_index");
  }

}