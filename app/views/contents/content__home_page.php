<div class="jumbotron">
  <div class="container">
    <h1>Главная страница!</h1>
    <p>
      <?php

      $array = [
          "user_exist" => "yeah",
          "user_active" => "yeah",
          "petitions" => [
              "name" => "kek",
              "test" => "lol"
          ],
          "alerts" => [
              "error" => [
                  "error01",
                  "error02"
              ],
              "info" => [
                  "info01",
                  "info02"
              ]
          ]
      ];

      echo "<pre>"; print_r($array); echo "</pre>";

      echo "<pre>"; print_r($string = route::array_to_string($array)); echo "</pre>";

      echo "<pre>"; print_r($fist_array = route::string_to_array($string)); echo "</pre>";

      ?>
    </p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores ducimus excepturi exercitationem maxime natus obcaecati placeat? Commodi doloribus est suscipit?</p>
    <p><a class="btn btn-primary btn-lg" href="/about" role="button">Подробнее &raquo;</a></p>
  </div>
</div>

<div class="container">
  <!-- Example row of columns -->
  <div class="row">
    <?php foreach($data as $post): ?>
      <article class="col-sm-6 col-lg-4">
        <h1><?php echo $post["title"] ?></h1>
        <p><?php echo $post["content"] ?></p>
        <p><a class="btn btn-default" href="#" role="button">Подробнее &raquo;</a></p>
      </article>
    <?php endforeach; ?>
  </div>
</div>