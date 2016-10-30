<div class="row">
  <h1 class="pull-left visible-lg">Шаблоны заявлений</h1>
  <h1><a class="btn btn-default btn-lg pull-right visible-lg" href="<?php echo route::$controller_url ?>/petition">Создать новый шаблон</a></h1>
  <h1><a class="btn btn-default btn-lg hidden-lg" href="<?php echo route::$controller_url ?>/petition">Создать новый шаблон</a></h1>
</div>

<div class="row visible-lg">
  <hr>
</div>

<div class="row">
  <?php
  $edit_button = "<a href='".route::$controller_url."/petition?id={{id}}' class='btn btn-default' title='Редактировать'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>";
  $delete_button = "<a href='".route::$controller_url."/petition?id={{id}}&action=delete' class='btn btn-danger' title='Удалить'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
  generate::table($data["petitions"], true, [$edit_button, $delete_button], false);
  ?>
  <?php generate::alerts($data, "warning", "col-sm-3") ?>
</div>
