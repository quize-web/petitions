<header>
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header pull-left">
<!--        <a class="navbar-brand" href="/">-->
<!--          <img src="/assets/template/img/diamond.svg" alt="logo" title="diamond" height="20">-->
<!--        </a>-->
        <a class="navbar-brand" href="/"><?php echo config::$site_name; ?> | Admin Panel</a>
        <a href="<?php echo route::$controller_url ?>/user_mode" class="btn btn-primary navbar-btn">USER Mode</a>
        <span class="label label-danger">Disabled</span>
      </div>
      <div class="navbar-right pull-right">
        <span class="navbar-text">Привет, <?php echo user::get("email") ?></span>
        <a href="/logout" class="btn btn-primary navbar-btn">Выйти</a>
      </div>
    </div>
  </nav>
</header>