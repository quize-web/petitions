<!DOCTYPE html>
<html lang="ru">
<head>
  <?php view::unit("head"); ?>
</head>
<body class="admin-panel">


<?php view::unit("header--user_panel"); ?>


<main>
  <div class="container">


    <div class="row">
      <ul class="nav nav-tabs">
        <?php view::unit("panel_nav--user_panel") ?>
      </ul>
    </div>

    <div class="row">

      <div class="col-lg-12">
        <?php include_once($content); ?>
      </div>

    </div>


  </div>
</main>


<?php view::unit("footer"); ?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="/assets/template/js/bootstrap.min.js"></script>
<script src="/assets/template/js/scripts.js"></script>

</body>
</html>