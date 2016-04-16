<div class="row">
 <div class="col-md-12">
  <div class="bs-callout bs-callout-info">
   <h4><i class="fa fa-server"></i> Веб-сервер</h4>
    <div><i class="fa fa-<?php echo Kernel::GetServerOS(); ?>"></i> <b>Операційна система:</b> <?php echo php_uname('s').' '.php_uname('r').' '.php_uname('v'); ?></div>
    <div><i class="fa fa-server"></i> <b>Сервер:</b> <?php echo apache_get_version(); ?></div>
    <div><i class="fa fa-globe"></i> <b>Адреса сервера:</b> <?php echo $_SERVER['SERVER_ADDR'].'('.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].')'; ?></div>
    <div><i class="fa fa-cog"></i> <b>Версія PHP:</b> <?php echo PHP_VERSION; ?> <i class="fa fa-plus-circle php-ext" data-container="body" data-toggle="popover" data-placement="right" title="Розширення PHP" data-content="<?php echo implode(", ", get_loaded_extensions()); ?>"></i></div>
    <div><i class="fa fa-plug"></i> <b>SAPI-інтерфейс:</b> <?php echo php_sapi_name(); ?></div>
    <div><i class="fa fa-folder-open"></i> <b>Домашня директорія:</b> <?php echo $_SERVER['DOCUMENT_ROOT']; ?></div>
  </div>
  <div class="bs-callout bs-callout-info">
   <h4><i class="fa fa-database"></i> MySQL-сервер</h4>
	<div><i class="fa fa-globe"></i> <b>MySQL-сервер:</b> <?php echo $MySQLi->Handle->host_info; ?></div>
	<div><i class="fa fa-cog"></i> <b>Версія MySQL-сервера:</b> <?php echo $MySQLi->Handle->server_info; ?></div>
	<div><i class="fa fa-exchange"></i> <b>Версія протоколу:</b> <?php echo $MySQLi->Handle->protocol_version; ?></div>
	<div><i class="fa fa-key"></i> <b>Версія MySQL-клієнта:</b> <?php echo $MySQLi->Handle->client_info; ?></div>
	<div><i class="fa fa-user"></i> <b>Користувач:</b> <?php echo $cfg['mysql']['user'].'@'.$cfg['mysql']['host']; ?></div>
	<div><i class="fa fa-check-circle"></i> <b>Порівняння:</b> <?php echo $MySQLi->Handle->get_charset()->collation; ?></div>
     <div><i class="fa fa-language"></i> <b>Кодування:</b> <?php echo $MySQLi->Handle->get_charset()->charset; ?></div>
  </div>
  <div class="bs-callout bs-callout-info">
   <h4><i class="fa fa-gears"></i> Система</h4>
    <div><i class="fa fa-star"></i> <b>Версія системи:</b> powertext <?php echo $cfg['system']['version']; ?></div>
  </div>
 </div>
</div>