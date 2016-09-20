<?php

class recaptcha
{

  const key = "6LcO_wYUAAAAALNbujskNGAiPVDRmUJw6sKnDcdB";
  const secret_key = "6LcO_wYUAAAAANepuRbhOEfhlj7gW5lGRWD6J9XQ";

  static public function verify() {

    $remote_ip = $_SERVER["REMOTE_ADDR"];
    $g_recaptcha_response = $_REQUEST["g-recaptcha-response"];
    $recaptcha = new \ReCaptcha\ReCaptcha(self::secret_key);
    $response = $recaptcha->verify($g_recaptcha_response, $remote_ip);
    if ($response->isSuccess()) {
      return true;
    } else {
      return false;
    }

  }


  static public function insert() {
    echo "<div class='g-recaptcha' data-sitekey='".self::key."'></div>";
  }

}