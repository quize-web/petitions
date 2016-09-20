<!DOCTYPE html>
<html lang="ru">
<head>
  <?php view::unit("head"); ?>
</head>
<body>


<?php view::unit("header"); ?>


<main>
  <?php include_once($content); ?>
</main>


<?php view::unit("footer"); ?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="/assets/template/js/bootstrap.min.js"></script>
<script src="/assets/template/js/scripts.js"></script>

</body>
</html>