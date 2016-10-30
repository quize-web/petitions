<div class="row">
  <h1 class="pull-left visible-lg">Мои заявления</h1>
  <h1><a class="btn btn-default btn-lg pull-right visible-lg" href="<?php echo route::$controller_url ?>/petition">Новое заявление</a></h1>
  <h1><a class="btn btn-default btn-lg hidden-lg" href="<?php echo route::$controller_url ?>/petition">Новое заявление</a></h1>
</div>
<div class="row visible-lg">
  <hr>
</div>

<div class="row">
  <table class="table table-hover">
    <thead>
    <tr>
      <th>#</th>
      <th>Название</th>
      <th>Шаблон</th>
      <th>Категория</th>
      <th>Цена</th>
      <th>Статус</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <th>1</th>
      <td>Название 1</td>
      <td>Шаблон 1</td>
      <td>Категория 1</td>
      <td>150 руб.</td>
      <td class="bg-warning"><strong>Ожидает оплаты</strong></td>
      <th>
        <a href="#" class="btn btn-success">Оплатить</a>
        <span class="label label-warning">7 дн.</span>
      </th>
      <th>
        <a href="#" class="btn btn-default" title="Редактировать"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
        <span class="label label-warning">5 мин.</span>
      </th>
      <th><a href="#" class="btn btn-danger" title="Удалить"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></th>
    </tr>
    <tr>
      <th>2</th>
      <td>Название 2</td>
      <td>Шаблон 2</td>
      <td>Категория 2</td>
      <td>250 руб.</td>
      <td class="bg-success"><strong>Оплачено</strong></td>
      <th>
        <a href="#" class="btn btn-success">Скачать</a>
        <span class="label label-warning">7 дн.</span>
      </th>
      <th>
        <a href="#" class="btn btn-default disabled" title="Редактировать"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
        <span class="label label-danger">недоступно</span>
      </th>
      <th><a href="#" class="btn btn-danger" title="Удалить"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></th>
    </tr>
    </tbody>
  </table>
</div>