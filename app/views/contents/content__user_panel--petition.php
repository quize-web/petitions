<div class="page-header">
  <div class="pull-right">
    <?php generate::alerts($data, "success", "col-sm-12"); ?>
    <?php generate::alerts($data, "warning", "col-sm-12"); ?>
  </div>
  <h1>Заявление</h1>
</div>

<form action="<?php echo route::$action_url; ?>">

  <div class="row">
    <div class="form-group col-sm-9 col-md-9">
      <div class="input-group">
        <div class="input-group-addon">Название</div>
        <input class="form-control" type="text" minlength="2" maxlength="64" name="name" id="name" value="Новое заявление" placeholder="Назовите Ваше заявление" required>
      </div>
    </div>
    <div class="form-group col-sm-3 col-md-3">
      <div class="input-group">
        <div class="input-group-addon">Цена</div>
        <input class="form-control" type="number" name="price" id="price" value="<?php echo @$data["template"][0]["price"]; ?>" disabled required>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="form-group col-sm-6 col-md-7">
      <div class="input-group">
        <div class="input-group-addon">Шаблон</div>
        <input class="form-control"  type="text" name="template" id="template"  value="<?php echo @$data["template"][0]["name"]; ?>" disabled required>
      </div>
    </div>
    <div class="form-group col-sm-6 col-md-5">
      <div class="input-group">
        <div class="input-group-addon">Категория</div>
        <input class="form-control" type="text" name="category" id="category"  value="<?php echo @$data["template"][0]["category"]; ?>" disabled required>
      </div>
    </div>
  </div>



  <div class="row">

    <div class="col-sm-6">

    </div>


    <div class="col-sm-6">
      <?php generate::alerts($data, "error", "col-sm-12"); ?>

      <div class="pull-right">
        <button class="btn btn-success" type="submit">Сохранить</button>
        <a class="btn btn-primary" href="#">Оплатить</a>
        <a class="btn btn-danger" href="#" title="Удалить"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
      </div>
    </div>

  </div>

</form>