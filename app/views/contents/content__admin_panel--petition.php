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
        <input class="form-control" type="text" name="name" placeholder="Название шаблона" minlength="2" maxlength="128" value="<?php echo @$data["petition"]["name"]; ?>" required>
      </div>
    </div>

    <div class="col-sm-5 col-md-5">
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-addon">Категория</div>
          <select class="form-control" name="category_id" required>
            <?php foreach($categories = database::get("petition_categories") as $row => $columns): ?>
                <option value="<?php echo $columns["id"]; ?>"
                    <?php if($columns["id"] == @$data["petition"]["category_id"]) echo "selected"; ?>>
                  <?php echo $columns["name"]; ?>
                </option>
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

    <div class="col-sm-6 pull-right">
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
          <?php if(route::get_data()): ?>
            <input type="hidden" name="id" value="<?php echo @$data["petition"]["id"]; ?>">
          <?php endif; ?>
          <input type="hidden" name="is_petition" value="true">
          <button class="btn btn-success" type="submit">Сохранить</button>
        </div>
        <div class="col-sm-4">
          <a class="btn btn-danger" href="<?php echo route::$current_url; ?>&action=delete">Удалить</a>
        </div>
        <div class="col-sm-4">
          <a class="btn btn-default" href="<?php echo route::$controller_url; ?>/petitions">Все шаблоны</a>
        </div>
      </div>
    </div>

</form>


<div class="col-sm-6 pull-left">

  <button class="btn btn-default" id="add_field">Добавить поле</button>
  <hr>

  <div id="petition_fields">

    <?php if( (isset($data["fields"])) && (!empty($data["fields"])) ): ?>
      <?php foreach($data["fields"] as $key => $field_array): ?>
        <div class="petition-field">
          <form action="<?php echo route::$action_url; ?>" method="post">
            <div class="row">
              <div class="form-group col-sm-6">
                <input class="form-control" type="text" name="title" placeholder="Заголовок" value="<?php echo @$field_array["title"]; ?>">
              </div>
              <div class="form-group col-sm-6">
                <textarea class="form-control" name="description" placeholder="Описание" value="<?php echo @$field_array["description"]; ?>"></textarea>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-sm-6">
                <div class="input-group">
                  <div class="input-group-addon">Тип</div>
                  <?php $types = ["text", "number", "email", "tel", "date"]; ?>
                  <select class="form-control" name="type" required>
                    <?php foreach($types as $type): ?>
                      <option value="<?php echo $type; ?>"
                          <?php if(@$field_array["type"] == $type) echo "selected"; ?>>
                        <?php echo $type; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="form-group col-sm-6">
                <input class="form-control" type="text" name="name" placeholder="name" value="<?php echo @$field_array["name"]; ?>" required>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-sm-6">
                <input class="form-control" type="text" name="placeholder" placeholder="placeholder" value="<?php echo @$field_array["placeholder"]; ?>">
              </div>
              <div class="form-group col-sm-6">
                <input class="form-control" type="text" name="value" placeholder="value" value="<?php echo @$field_array["value"]; ?>">
              </div>
            </div>
            <div class="row">
              <?php if(route::get_data()): ?>
                <input type="hidden" name="template_id" value="<?php echo $_GET["id"]; ?>">
              <?php endif; ?>
              <input type="hidden" name="is_field" value="true">
              <input type="hidden" name="id" value="<?php echo @$field_array["id"]; ?>">
              <div class="col-sm-6"><button class="btn btn-success" type="submit">Сохранить</button></div>
              <div class="checkbox col-sm-6"><label><input name="required" type="checkbox" <?php if(@$field_array["required"] == 1) echo "checked"; ?>> required?</label></div>
            </div>
          </form>
        </div>
        <hr>
      <?php endforeach; ?>
    <?php endif; ?>

  </div>

</div>

</div>



<!-- ШАБЛОН ПОЛЯ ДЛЯ JS -->
<script type="text/html" id="petition_field_template">
          <form action="<?php echo route::$action_url; ?>" method="post">
            <div class="row">
              <div class="form-group col-sm-6">
                <input class="form-control" type="text" name="title" placeholder="Заголовок">
              </div>
              <div class="form-group col-sm-6">
                <textarea class="form-control" name="description" placeholder="Описание"></textarea>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-sm-6">
                <div class="input-group">
                  <div class="input-group-addon">Тип</div>
                  <?php $types = ["text", "number", "email", "tel", "date"]; ?>
                  <select class="form-control" name="type" required>
                    <?php foreach($types as $type): ?>
                      <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="form-group col-sm-6">
                <input class="form-control" type="text" name="name" placeholder="name" required>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-sm-6">
                <input class="form-control" type="text" name="placeholder" placeholder="placeholder">
              </div>
              <div class="form-group col-sm-6">
                <input class="form-control" type="text" name="value" placeholder="value">
              </div>
            </div>
            <div class="row">
              <?php if(route::get_data()): ?>
                <input type="hidden" name="template_id" value="<?php echo $_GET["id"]; ?>">
              <?php endif; ?>
              <input type="hidden" name="is_field" value="true">
              <div class="col-sm-6"><button class="btn btn-success" type="submit">Сохранить</button></div>
              <div class="checkbox col-sm-6"><label><input name="required" type="checkbox"> required?</label></div>
            </div>
          </form>
        <hr>
</script>