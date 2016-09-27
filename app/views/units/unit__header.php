<header>
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header pull-left">
<!--        <a class="navbar-brand" href="/">-->
<!--          <img src="/assets/template/img/diamond.svg" alt="logo" title="diamond" height="20">-->
<!--        </a>-->
        <?php if(route::page("/")): ?>
          <span class="navbar-brand"><?php echo config::$site_name; ?></span>
        <?php else: ?>
          <a class="navbar-brand" href="/"><?php echo config::$site_name; ?></a>
        <?php endif; ?>
      </div>
      <div class="navbar-right pull-right">

        <?php if(!user::session()): ?>
          <?php if(!route::page("/sign_in")): ?>
            <a href="/sign_in" class="btn btn-primary navbar-btn">Войти</a>
          <?php else: ?>
            <a href="/sign_in/forgot" class="btn btn-primary navbar-btn">Забыл пароль</a>
          <?php endif; ?>
        <?php if(!route::page("/sign_up")): ?>
          <a href="/sign_up" class="btn btn-primary navbar-btn">Зарегистрироваться</a>
          <?php else: ?>
            <a href="/sign_in/forgot" class="btn btn-primary navbar-btn">Забыл пароль</a>
          <?php endif; ?>

        <?php else: ?>
            <span class="navbar-text">Привет, <?php echo user::get("email") ?></span>
          <a href="/panel" class="btn btn-primary navbar-btn">Личный кабинет</a>
          <a href="/logout" class="btn btn-primary navbar-btn">Выйти</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>
</header>