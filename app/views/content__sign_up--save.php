<div class="jumbotron">
  <div class="container">
    <h1>Вы зарегистрированы!</h1>
    <p>
      Осталось только активировать Ваш профиль для дальнейшей работы!
    </p>
    <p>
      Для этого Вы должны зайти на Вашу электронную почту <a href="http://<?php echo $data["email"] ?>/" target="_blank"><?php echo $data["email"] ?></a>, открыть полученное от нас письмо и следовать дальнейшим указаниям.
    </p>
  </div>
</div>

<div class="container">
  <?php echo "<pre>"; print_r($data); echo "</pre>"; ?>
</div>