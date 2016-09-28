<div class="row">
  <h1 class="pull-left visible-lg">Шаблоны заявлений</h1>
  <h1><a class="btn btn-default btn-lg pull-right visible-lg" href="<?php echo route::$controller_url ?>/petition">Новый шаблон</a></h1>
  <h1><a class="btn btn-default btn-lg hidden-lg" href="<?php echo route::$controller_url ?>/petition">Новый шаблон</a></h1>
</div>

<div class="row visible-lg">
  <hr>
</div>

<div class="row">
  <?php
  $edit_button = "<a href='".route::$controller_url."/petition?id={{id}}' class='btn btn-default'>Редактировать</a>";
  $delete_button = "<a href='".route::$controller_url."/petition?id={{id}}&action=delete' class='btn btn-danger'>Удалить</a>";
  generate::table($data["petitions"], true, [$edit_button, $delete_button], false);
  ?>
  <?php generate::alerts($data, "warning", "col-sm-3") ?>
</div>
