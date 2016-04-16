<?php if($RouteID !== 7): ?>
<ul class="nav nav-tabs">
  <?php if(in_array($RouteID, array(11, 15, 17, 19))): ?>
  <li<?php if($RouteID === 11) echo ' class="active"'; ?>><a href="manager/files"><i class="fa fa-hdd-o"></i> Файловий менеджер</a></li>
  <li<?php if($RouteID === 19) echo ' class="active"'; ?>><a href="manager/upload"><i class="fa fa-download"></i> Завантаження файлів</a></li>
  <li<?php if($RouteID === 15) echo ' class="active"'; ?>><a href="manager/backup/db"><i class="fa fa-database"></i> Резервна копія БД</a></li>
  <?php if(in_array($RouteID, array(15, 17))): ?>
  <li<?php if($RouteID === 17) echo ' class="active"'; ?>><a href="manager/backup/files"><i class="fa fa-file-archive-o"></i> Резервна копія файлів</a></li>
  <?php endif; ?>
  <?php endif; ?>
  <?php if(in_array($RouteID, array(18, 28, 29, 30))): ?>
  <li<?php if($RouteID === 28) echo ' class="active"'; ?>><a href="manager/stats"><i class="fa fa-area-chart"></i> Статистика</a></li>
  <?php if($ssID->privileges == 4): ?>
  <li<?php if($RouteID === 30) echo ' class="active"'; ?>><a href="manager/system"><i class="fa fa-gears"></i> Система</a></li>
  <li<?php if($RouteID === 18) echo ' class="active"'; ?>><a href="manager/users"><i class="fa fa-users"></i> Список користувачів</a></li>
  <li<?php if($RouteID === 29) echo ' class="active"'; ?>><a href="manager/logs"><i class="fa fa-clock-o"></i> Журнал подій</a></li>
  <?php endif; ?>
  <?php endif; ?>
  <?php if(in_array($RouteID, array(9, 10, 22, 26, 31))): ?>
  <li<?php if($RouteID === 9) echo ' class="active"'; ?>><a href="manager/content"><i class="fa fa-file"></i> Список сторінок</a></li>
  <?php if(in_array($RouteID, array(10))): ?>
  <li<?php if($RouteID === 10) echo ' class="active"'; ?>><a><i class="fa fa-pencil"></i> Редактор сторінок</a></li>
  <?php endif; ?>
  <li<?php if($RouteID === 22) echo ' class="active"'; ?>><a href="manager/categories"><i class="fa fa-list-alt"></i> Cписок розділів</a></li>
  <li<?php if($RouteID === 26) echo ' class="active"'; ?>><a href="manager/navigation"><i class="fa fa-compass"></i> Редактор навігації</a></li>
  <li<?php if($RouteID === 31) echo ' class="active"'; ?>><a href="manager/events"><i class="fa fa-calendar"></i> Редактор подій</a></li>
  <?php endif; ?>
</ul>
<?php endif; ?>