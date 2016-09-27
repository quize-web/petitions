<div class="jumbotron">


  <div class="container">
    <h1>Вход</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores ducimus excepturi exercitationem maxime natus obcaecati placeat? Commodi doloribus est suscipit?</p>
  </div>


  <div class="container">
    <form action="<?php echo route::$controller_url ?>/auth" method="post">

      <div class="row">
        <div class="form-group form-group-lg col-sm-6">
          <label for="email">Ваш E-mail адрес:</label>
          <input type="email" name="email" id="email" class="form-control" maxlength="64" required>
        </div>
        <div class="form-group form-group-lg col-sm-6">
          <label for="password">Ваш пароль:</label>
          <input type="password" name="password" id="password" class="form-control" minlength="6" required>
        </div>
      </div>
      <div class="row">
      </div>

      <?php generate::alerts($data); ?>

      <div class="row">
        <div class="form-group col-sm-6">
          <?php recaptcha::insert(); ?>
        </div>
        <div class="col-sm-6">
          <div class="checkbox pull-left">
            <label>
              <input type="checkbox" name="remember" id="remember"> Запомнить меня <span class="label label-primary">на месяц</span>
            </label>
          </div>
          <button type="submit" class="btn btn-primary btn-lg pull-right">Войти</button>
        </div>
      </div>

    </form>
  </div>


</div>