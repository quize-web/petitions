<?php

class view
{

  public function generate($template, $content, $data = array()) {
    $content = route::$views_path."/".route::$contents_path."/content__$content.php";
    include_once(route::$views_path."/".route::$templates_path."/template__$template.php");
    exit();
  }

  public static function unit($name) {
    include(route::$views_path."/".route::$units_path."/unit__$name.php");
  }

}