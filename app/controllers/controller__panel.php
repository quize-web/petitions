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

  //////////////////////////////////////////////

  public function action__petitions() {
    route::check(user::session());
    if (user::is_active(false)) $this->view->generate("user_panel", "user_panel--not_active");


    if(user::access("user")) {
      $this->view->generate("user_panel", "user_panel--petitions");
    }

    elseif(user::access("admin")) {
      $petitions_array = $this->model->get_petition_templates();
      $this->view->generate("admin_panel", "admin_panel--petitions", $petitions_array);
    }

    else route::error();
  }

  //////////////////////////////////////////////

  public function action__petition() {
    route::check(user::session());
    if (user::is_active(false)) $this->view->generate("user_panel", "user_panel--not_active");


    if(user::access("user")) {
      if(route::get_data() || route::post_data()) {
        if($data = $this->model->petition())
          $this->view->generate("user_panel--wide", "user_panel--petition", $data);
      } else {
        if($petition_templates = $this->model->get_petition_templates())
          $this->view->generate("user_panel--wide", "user_panel--petition_templates", $petition_templates);
      }
    }

    elseif(user::access("admin")) {
      if(route::get_data() || route::post_data()) {
        if($data = $this->model->petition_template())
          $this->view->generate("admin_panel--wide", "admin_panel--petition", $data);
      } else {
        $this->view->generate("admin_panel--wide", "admin_panel--petition");
      }
    }

    else route::error();

  }


  /////////////////////////////////////
  // USER PANEL (use ...)
  ////////////////////////////////////

  //



  /////////////////////////////////////
  // ADMIN PANEL (use ...)
  ////////////////////////////////////

  public function action__user_mode() {
    route::check(user::session());
    route::check(user::access("admin"));

    $this->model->user_mode();
    route::redirect("controller");
  }

  //////////////////////////////////////////////

  public function action__categories() {
    route::check(user::session());
    route::check(user::access("admin"));

    $categories_array = database::get("petition_categories", ["name" => "Название"]);
    $this->view->generate("admin_panel", "admin_panel--categories", $categories_array);
  }

  //////////////////////////////////////////////

  public function action__users() {
    route::check(user::session());
    route::check(user::access("admin"));

    $users_array = $this->model->get_users();
    $this->view->generate("admin_panel", "admin_panel--users", $users_array);
  }

  //////////////////////////////////////////////

}