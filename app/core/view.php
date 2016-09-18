<?php

class view
{

  public function generate($template, $content, $data = array()) {
    $content = route::$views_path."/content__$content.php";
    include_once(route::$views_path."/template__$template.php");
  }

  public static function unit($name) {
    include_once(route::$views_path."/unit__$name.php");
  }

}