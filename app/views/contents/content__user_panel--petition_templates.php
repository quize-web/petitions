<div class="page-header">
  <h1>Выберите шаблон</h1>
</div>

<div class="row">
  <?php foreach($data["petition_templates"] as $key => $template_array): ?>

    <div class="col-sm-4">
      <div class="bg-info">
        <h2><?php echo $template_array["name"]; ?></h2>
        <h3><?php echo $template_array["category"]; ?></h3>
        <strong><?php if($template_array["pay"] != 1) echo "Бесплатный"; else echo "Платный"; ?></strong>
        <a class="btn btn-primary pull-right"
           href="<?php echo route::$action_url; ?>?template=<?php echo $template_array["id"]; ?>">Выбрать
        </a>
      </div>
    </div>

  <?php endforeach; ?>
</div>