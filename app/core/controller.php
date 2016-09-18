<?php

abstract class controller
{

  protected $view;
  protected $model;

  function __construct()
  {
    $this->view = new view();
    if(!empty(route::$model)) $this->model = new route::$model;
  }

  public function action__index() {

  }

}