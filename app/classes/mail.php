<?php

final class mail
{

  private static $instance;
  private function __construct() {}
  private function __clone() {}

  const server_inbox = "quize.web@yandex.ru";
  const site_inbox = "quize.web@yandex.ru";
//  const site_inbox = "mail@mvc-shop.ru";

  private static $mail;


  public static function start() {

    if(!(self::$instance instanceof self)) {
      self::$instance = new self();
    }


    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.yandex.ru";
    $mail->Username = self::server_inbox;
    $mail->Password = "PrintScanCopy1922";
    $mail->SMTPSecure = "ssl";
    $mail->Port = 465;
    $mail->CharSet = "UTF-8";
    $mail->isHTML(true);

    self::$mail = $mail;


    return self::$instance;

  }



  public static function send($to, $subject, $content) {

    $mail = self::$mail;

    try {
      $mail->setFrom(self::site_inbox, "MVC-SHOP");
      $mail->addAddress($to, "Пользователь MVC-SHOP");
      $mail->addCC(self::server_inbox, "Администратор MVC-SHOP");
      $mail->addReplyTo(self::site_inbox, "MVC-SHOP REPLY TO");
      $mail->Subject = $subject;
      $mail->Body = $content;
      $mail->AltBody = "ALT_$content";
      $mail->send();
      return true;
    } catch (phpmailerException $e) {
      echo $e->errorMessage();
      return false;
    }

  }

}