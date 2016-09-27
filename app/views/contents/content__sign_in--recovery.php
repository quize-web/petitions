<div class="jumbotron">


  <div class="container">
    <h1>Восстановление пароля</h1>
    <?php if(!empty($data["alerts"]["info"]["success"])): ?>
        <p><?php echo $data["alerts"]["info"]["success"]; ?></p>
        <p><a href="<?php echo route::$controller_url ?>" class="btn btn-primary btn-lg">Войти</a></p>
    <?php endif; ?>
  </div>


  <?php if(empty($data["alerts"]["info"]["success"])): ?>
    <div class="container">
      <form action="<?php echo route::$controller_url ?>/recovery" method="post">

        <div class="row">
          <div class="form-group form-group-lg col-sm-6">
            <label for="email">Ваш новый пароль:</label>
            <input type="password" name="password" id="password" class="form-control" maxlength="64" required>
          </div>
          <div class="form-group form-group-lg col-sm-6">
            <label for="email">Подтвердите Ваш новый пароль:</label>
            <input type="password" name="password_verify" id="password_verify" class="form-control" maxlength="64" required>
          </div>
        </div>

        <?php generate::alerts($data); ?>

        <div class="row">
          <div class="form-group col-sm-6">
            <?php recaptcha::insert(); ?>
          </div>
          <div class="col-sm-6">
            <button type="submit" class="btn btn-primary btn-lg pull-right">Изменить пароль</button>
          </div>
        </div>

      </form>
    </div>
  <?php endif; ?>


</div>