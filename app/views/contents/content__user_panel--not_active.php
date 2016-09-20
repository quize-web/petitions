<div class="container">
  <div class="jumbotron">

    <h1>Внимание!</h1>
    <p><strong>Ваш профиль еще не активирован.</strong></p>

    <hr>

    <p>Внимательно проверьте <a href="http://<?php echo user::get("email") ?>/" target="_blank">Ваш почтовый ящик</a> на наличие письма активации.</p>

    <?php if(timer::work("resend")):?>

      <p>Письмо не пришло? Вы сможете выслать его повторно через <?php echo timer::get("resend"); ?> секунд.</p>

    <?php else: ?>
      <p>
        Письмо не пришло?
        <a class="btn btn-primary btn-lg" href="<?php route::$host ?>/sign_up/resend" role="button">Выслать письмо повторно!</a>
      </p>
    <?php endif; ?>

  </div>
</div>