<div class="row placeholders">
<h5 class="page-header text-left text-muted col-md-11"><i class="fa fa-pencil"></i> Керування контентом</h5>
<div class="col-xs-12 col-sm-3 thumbnail">
<a href="manager/content">
  <i class="fa fa-file fa-4x"></i>
  <h4>Сторінки</h4>
</a>
  <span class="text-muted">Список матеріалів</span>
</div>
<div class="col-xs-12 col-sm-3 col-sm-offset-1 thumbnail">
<a href="manager/categories">
  <i class="fa fa-list-alt fa-4x"></i>
  <h4>Розділи</h4>
</a>
  <span class="text-muted">Список розділів</span>
</div>
<div class="col-xs-12 col-sm-3 col-sm-offset-1 thumbnail">
<a href="manager/navigation">
  <i class="fa fa-compass fa-4x"></i>
  <h4>Навігація</h4>
</a>
  <span class="text-muted">Редактор меню</span>
</div>
</div>
<div class="row placeholders">
<div class="col-xs-12 col-sm-3 thumbnail">
<a href="manager/events">
  <i class="fa fa-calendar fa-4x"></i>
  <h4>Редактор подій</h4>
</a>
  <span class="text-muted">Редагування календаря</span>
</div>
</div>
<div class="row placeholders">
<h5 class="page-header text-left text-muted col-md-11"><i class="fa fa-folder"></i> Файлова система</h5>
<div class="col-xs-12 col-sm-3 thumbnail">
<a href="manager/files">
  <i class="fa fa-hdd-o fa-4x"></i>
  <h4>Файловий менеджер</h4>
</a>
  <span class="text-muted">Керування файлами</span>
</div>
<div class="col-xs-12 col-sm-3 col-sm-offset-1 thumbnail">
<a href="manager/upload">
  <i class="fa fa-download fa-4x"></i>
  <h4>Завантаження</h4>
</a>
  <span class="text-muted">Завантаження файлів</span>
</div>
<div class="col-xs-12 col-sm-3 col-sm-offset-1 thumbnail">
<a href="manager/backup/files">
  <i class="fa fa-file-archive-o fa-4x"></i>
  <h4>Бекапи</h4>
</a>
  <span class="text-muted">Резервні копії</span>
</div>
</div>
<?php if($ssID->privileges == 4): ?>
<div class="row placeholders">
<h5 class="page-header text-left text-muted col-md-11"><i class="fa fa-gear"></i> Система</h5>
<div class="col-xs-12 col-sm-3 thumbnail">
<a href="manager/system">
  <i class="fa fa-gears fa-4x"></i>
  <h4>Система</h4>
</a>
  <span class="text-muted">Інформація про систему</span>
</div>
<div class="col-xs-12 col-sm-3 col-sm-offset-1 thumbnail">
<a href="manager/logs">
  <i class="fa fa-clock-o fa-4x"></i>
  <h4>Журнал подій</h4>
</a>
  <span class="text-muted">Логи</span>
</div>
<div class="col-xs-12 col-sm-3 col-sm-offset-1 thumbnail">
<a href="manager/users">
  <i class="fa fa-users fa-4x"></i>
  <h4>Користувачі</h4>
</a>
  <span class="text-muted">Керування акаунтами</span>
</div>
</div>
<?php endif; ?>
<div class="row placeholders">
<div class="col-xs-12 col-sm-3 thumbnail">
<a href="manager/stats">
  <i class="fa fa-area-chart fa-4x"></i>
  <h4>Статистика</h4>
</a>
  <span class="text-muted">Аналітична інформація</span>
</div>
</div>