<div class="jumbotron">

  <div class="container">
    <h1>Восстановление пароля</h1>
    <?php if(!empty($data["alerts"]["info"]["success"])): ?>
      <p><?php echo $data["alerts"]["info"]["success"]; ?></p>
      <p><a href="http://<?php echo $data["alerts"]["info"]["email"] ?>/" class="btn btn-primary btn-lg" target="_blank">Перейти к почтовому ящику</a></p>
    <?php endif; ?>
  </div>


  <?php if(empty($data["alerts"]["info"]["success"])): ?>
  <div class="container">
    <form action="<?php echo route::$controller_url ?>/forgot" method="post">

      <div class="row">
        <div class="form-group form-group-lg col-xs-12">
          <label for="email">Введите Ваш E-mail адрес:</label>
          <input type="email" name="email" id="email" class="form-control" maxlength="64" required>
        </div>
      </div>

      <?php generate::alerts($data); ?>

      <div class="row">
        <div class="form-group col-sm-6">
          <?php recaptcha::insert(); ?>
        </div>
        <div class="col-sm-6">
          <button type="submit" class="btn btn-primary btn-lg pull-right">Восстановить пароль</button>
        </div>
      </div>

    </form>
  </div>
  <?php endif; ?>


</div>