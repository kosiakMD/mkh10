 <!--<ul class="nav nav-sidebar">
  <li class="active"><a href="manager"><span class="glyphicon glyphicon-home"></span> Панель керування</a></li>
 </ul>-->
  <?php $menuStatus = ((isset($_COOKIE['menuStatus'])) ? json_decode(stripslashes($_COOKIE['menuStatus']), true) : false); ?>
  <ul class="nav nav-sidebar">
   <li><a data-toggle="collapse" href="#collapseA"><i class="fa fa-chevron-<?php echo (($menuStatus && array_key_exists('collapseA', $menuStatus)) ? $menuStatus['collapseA']['icon'] : 'up'); ?>"></i> Керування контентом</a></li>
   <div id="collapseA" class="panel-collapse collapse<?php echo (($menuStatus && array_key_exists('collapseA', $menuStatus)) ? $menuStatus['collapseA']['status'] : ' in'); ?>">
	<li><a href="manager/content"><i class="fa fa-file"></i> Список сторінок</a></li>
	<li><a href="manager/categories"><i class="fa fa-list-alt"></i> Список розділів</a></li>
    <li><a href="manager/navigation"><i class="fa fa-compass"></i> Редактор навігації</a></li>
	<li><a href="manager/events"><i class="fa fa-calendar"></i> Редактор подій</a></li>
   </div>
  </ul>
 <ul class="nav nav-sidebar">
   <li><a data-toggle="collapse" href="#collapseB"><i class="fa fa-chevron-<?php echo (($menuStatus && array_key_exists('collapseB', $menuStatus)) ? $menuStatus['collapseB']['icon'] : 'down'); ?>"></i> Файлова система</a></li>
   <div id="collapseB" class="panel-collapse collapse<?php echo (($menuStatus && array_key_exists('collapseB', $menuStatus)) ? $menuStatus['collapseB']['status'] : ''); ?>">
	<li><a href="manager/files"><i class="fa fa-hdd-o"></i> Файловий менеджер</a></li>
	<li><a href="manager/upload"><i class="fa fa-download"></i> Завантаження файлів</a></li>
	<li><a href="manager/backup/files"><i class="fa fa-file-archive-o"></i> Резервна копія</a></li>
   </div>
  </ul>
  <ul class="nav nav-sidebar">
   <li><a data-toggle="collapse" href="#collapseC"><i class="fa fa-chevron-<?php echo (($menuStatus && array_key_exists('collapseC', $menuStatus)) ? $menuStatus['collapseC']['icon'] : 'up'); ?>"></i> Система</a></li>
   <div id="collapseC" class="panel-collapse collapse<?php echo (($menuStatus && array_key_exists('collapseC', $menuStatus)) ? $menuStatus['collapseC']['status'] : ' in'); ?>">
   <li><a href="manager/stats"><i class="fa fa-area-chart"></i> Статистика</a></li>
   <?php if($ssID->privileges == 4): ?>
   <li><a href="manager/system"><i class="fa fa-gears"></i> Система</a></li>
   <li><a href="manager/users"><i class="fa fa-users"></i> Список користувачів</a></li>
   <li><a href="manager/logs"><i class="fa fa-clock-o"></i> Журнал подій</a></li>
   <?php endif; ?>
   </div>
  </ul>