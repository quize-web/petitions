<div class="jumbotron">


  <div class="container">
    <h1>Регистрация</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores ducimus excepturi exercitationem maxime natus obcaecati placeat? Commodi doloribus est suscipit?</p>
  </div>


  <div class="container">
    <form action="<?php echo route::$controller_url ?>/save" method="post">

      <div class="row">
        <div class="form-group col-xs-12">
          <label for="email">Ваш E-mail адрес:</label>
          <input type="email" name="email" id="email" class="form-control" maxlength="64" placeholder="Обязательное поле" required>
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
        <div class="form-group col-sm-4">
          <label for="name">Ваше имя:</label>
          <input type="text" name="name" id="name" class="form-control" minlength="2" maxlength="32" placeholder="Не обязательное поле">
        </div>
        <div class="form-group col-sm-4">
          <label for="lastname">Ваша фамилия:</label>
          <input type="text" name="lastname" id="lastname" class="form-control" minlength="2" maxlength="32" placeholder="Не обязательное поле">
        </div>
        <div class="form-group col-sm-4">
          <label for="birthday">Ваша дата рождения:</label>
          <input type="date" name="birthday" id="birthday" class="form-control" placeholder="Не обязательное поле">
        </div>
      </div>
      <div class="row">
        <div class="form-group col-sm-6">
          <div class="checkbox">
            <label>
              <input type="checkbox" name="user_agreement" id="user_agreement">
              Я прочел и принимаю пользовательское соглашение
            </label>
          </div>
        </div>
        <div class="form-group col-sm-6">
          <?php recaptcha::insert(); ?>
        </div>
      </div>

      <?php alerts::show($data); ?>

      <div class="row">
        <div class="col-sm-6">
          <button type="submit" class="btn btn-primary btn-lg">Зарегистрироваться</button>
        </div>
      </div>

    </form>
  </div>


</div>