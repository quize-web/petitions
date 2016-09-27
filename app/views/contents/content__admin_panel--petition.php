<div class="page-header">
  <div class="pull-right">
    <?php generate::alerts($data, "success", "col-sm-12"); ?>
  </div>
  <h1>Шаблон заявления</h1>
</div>

<form action="<?php echo route::$action_url; ?>" method="post">

  <div class="row">

    <div class="col-sm-4 col-md-5">
      <div class="form-group">
        <input class="form-control" type="text" name="name" placeholder="Название шаблона" value="<?php echo @$data["petition"]["name"]; ?>" required maxlength="128" minlength="2">
      </div>
    </div>

    <div class="col-sm-5 col-md-5">
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon">Категория</div>
          <select class="form-control" name="category_id" required>
            <?php foreach($categories = database::get("petition_categories") as $row => $columns): ?>
              <?php if($columns["id"] == @$data["petition"]["category_id"]): ?>
                <option value="<?php echo $columns["id"]; ?>" selected><?php echo $columns["name"]; ?></option>
              <?php else: ?>
                <option value="<?php echo $columns["id"]; ?>"><?php echo $columns["name"]; ?></option>
              <?php endif; ?>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
    </div>

    <div class="col-sm-3 col-md-2">
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon">Цена</div>
          <input class="form-control" type="number" name="price" id="price" min="0" step="50"
                 value="<?php if(empty(@$data["petition"]["price"])) echo "0"; else echo @$data["petition"]["price"]; ?>" required>
        </div>
      </div>
    </div>

  </div>


  <hr>


  <div class="row">

    <div class="col-sm-6">
      <button class="btn btn-default">Добавить поле</button>

      <hr>

<!--      <form action="--><?php //route::$current_url; ?><!--" method="post">-->
<!--        <div class="row">-->
<!--          <div class="form-group col-sm-6">-->
<!--            <input class="form-control" type="text" name="title" placeholder="Заголовок">-->
<!--          </div>-->
<!--          <div class="form-group col-sm-6">-->
<!--            <textarea class="form-control" name="description" placeholder="Описание"></textarea>-->
<!--          </div>-->
<!--        </div>-->
<!---->
<!--        <div class="row">-->
<!--          <div class="form-group col-sm-6">-->
<!--            <div class="input-group">-->
<!--              <div class="input-group-addon">Тип</div>-->
<!--              <select class="form-control" name="type" required>-->
<!--                <option value="text" selected>text</option>-->
<!--                <option value="text">number</option>-->
<!--                <option value="text">email</option>-->
<!--                <option value="text">tel</option>-->
<!--                <option value="text">date</option>-->
<!--              </select>-->
<!--            </div>-->
<!--          </div>-->
<!--          <div class="form-group col-sm-6">-->
<!--            <input class="form-control" type="text" name="name" placeholder="name" required>-->
<!--          </div>-->
<!--        </div>-->
<!---->
<!--        <div class="row">-->
<!--          <div class="form-group col-sm-6">-->
<!--            <input class="form-control" type="text" name="placeholder" placeholder="placeholder">-->
<!--          </div>-->
<!--          <div class="form-group col-sm-6">-->
<!--            <input class="form-control" type="text" name="value" placeholder="value">-->
<!--          </div>-->
<!--        </div>-->
<!---->
<!--        <div class="row">-->
<!--          <div class="col-sm-6"><button class="btn btn-success" type="submit">Сохранить</button></div>-->
<!--          <div class="checkbox col-sm-6"><label><input type="checkbox"> required?</label></div>-->
<!--        </div>-->
<!--      </form>-->

      <hr>

    </div>

    <div class="col-sm-6">
      <div class="form-group">
        <label for="template">Вступительная часть</label>
        <textarea class="form-control" name="template" id="template" rows="8"><?php echo @$data["petition"]["template"]; ?></textarea>
      </div>
      <div class="form-group">
        <label for="template_main">Основная часть</label>
        <textarea class="form-control" name="template_main" id="template_main" rows="8"><?php echo @$data["petition"]["template_main"]; ?></textarea>
      </div>

      <?php generate::alerts($data, "error", "col-xs-12"); ?>

      <div class="row">
        <div class="col-sm-4">
          <?php if(route::post_data()): ?>
            <input type="hidden" name="id" value="<?php echo @$data["petition"]["id"]; ?>">
          <?php endif; ?>
          <button class="btn btn-success" type="submit">Сохранить</button>
        </div>
        <div class="col-sm-4">
          <a class="btn btn-danger" href="<?php route::$current_url ?>&action=delete">Удалить</a>
        </div>
        <div class="col-sm-4">
          <a class="btn btn-default" href="<?php echo route::$controller_url; ?>/petitions">Все шаблоны</a>
        </div>
      </div>
    </div>

  </div>

</form>