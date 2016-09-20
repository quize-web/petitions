<?php

class model__panel
{

public function user_mode() {
  if( (!isset($_SESSION["admin"]["user_mode"])) || ($_SESSION["admin"]["user_mode"] != 1) ) {
    $_SESSION["admin"]["user_mode"] = 1;
  } elseif($_SESSION["admin"]["user_mode"] == 1) {
    $_SESSION["admin"]["user_mode"] = 0;
  }
}

}