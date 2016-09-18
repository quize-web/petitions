<header>
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header pull-left">
<!--        <a class="navbar-brand" href="/">-->
<!--          <img src="/assets/template/img/diamond.svg" alt="logo" title="diamond" height="20">-->
<!--        </a>-->
        <a class="navbar-brand" href="/">MVC Shop</a>
      </div>
      <div class="navbar-right pull-right">
        <?php if(!user::session_exist()): ?>
          <a href="/sign_in" class="btn btn-primary navbar-btn">Войти</a>
          <a href="/sign_up" class="btn btn-primary navbar-btn">Зарегистрироваться</a>
        <?php else: ?>
            <span class="navbar-text">Привет, <?php echo user::get("email") ?></span>
          <a href="/panel" class="btn btn-primary navbar-btn">Личный кабинет</a>
          <a href="/logout" class="btn btn-primary navbar-btn">Выйти</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>
</header>