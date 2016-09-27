<div class="row">
  <h1 class="pull-left visible-lg">Список пользователей</h1>
</div>
<div class="row visible-lg">
  <hr>
</div>

<div class="row">
  <?php if(!empty($data)): ?>
    <?php generate::table($data, true); ?>
  <?php endif; ?>
</div>