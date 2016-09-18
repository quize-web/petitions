<?php

require_once("core/config.php");

require_once("core/database.php");

require_once("core/view.php");
require_once("core/model.php");
require_once("core/controller.php");
require_once("core/route.php");

require_once("classes/user.php");
require_once("classes/mail.php");
require_once("classes/recaptcha.php");
require_once("classes/alerts.php");


database::start();
user::start();
mail::start();
route::start();

?>