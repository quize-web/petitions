<div class="row">
  <h1 class="pull-left visible-lg">Категории заявлений</h1>
</div>
<div class="row visible-lg">
  <hr>
</div>

<div class="row">
  <?php if(!empty($data)): ?>
    <?php generate::table($data); ?>
  <?php endif; ?>
</div>