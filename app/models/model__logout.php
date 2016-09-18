<?php

class model__logout
{

  static public function logout() {
    user::session_destroy();
    route::redirect();
  }

}