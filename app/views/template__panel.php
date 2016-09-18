<!DOCTYPE html>
<html lang="ru">
<head>
  <?php view::unit("head"); ?>
</head>
<body class="admin-panel">


<?php view::unit("header--panel"); ?>


<main>
  <?php include_once($content); ?>
</main>


<?php view::unit("footer"); ?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="/assets/template/js/bootstrap.min.js"></script>

</body>
</html>