<div class="jumbotron">


  <div class="container">
    <h1>Регистрация</h1>
  </div>


  <div class="container">
    <form action="<?php echo route::$controller_url ?>/save" method="post">

      <div class="row">
        <div class="form-group col-xs-12">
          <label for="email">Ваш E-mail адрес:</label>
          <input type="email" name="email" id="email" class="form-control" placeholder="Обязательное поле" required>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-sm-6">
          <label for="password">Ваш пароль:</label>
          <input type="password" name="password" id="password" class="form-control" placeholder="Обязательное поле" minlength="6" required>
        </div>
        <div class="form-group col-sm-6">
          <label for="password_verify">Подтвердите пароль:</label>
          <input type="password" name="password_verify" id="password_verify"  class="form-control" placeholder="Обязательное поле" minlength="6" required>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-sm-6">
          <div class="checkbox">
            <label>
              <input type="checkbox" name="user_agreement" id="user_agreement">
              Я прочел и принимаю <a href="#" target="_blank">пользовательское соглашение</a>
            </label>
          </div>
        </div>
        <div class="form-group col-sm-6">
          <?php recaptcha::insert(); ?>
        </div>
      </div>

      <?php generate::alerts($data); ?>

      <div class="row">
        <div class="col-sm-6">
          <button type="submit" class="btn btn-primary btn-lg">Зарегистрироваться</button>
        </div>
      </div>

    </form>
  </div>


</div>