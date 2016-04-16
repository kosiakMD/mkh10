<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container-fluid">
	<div class="navbar-header">
	  <button type="button" class="pull-left hidden-sm hidden-xs" id="CompactMenuToggle"><i class="fa fa-<?php echo ((isset($_COOKIE['menuType']) && $_COOKIE['menuType'] == '0') ? 'in' : 'out'); ?>dent"></i></button>
	  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	  </button>
	  <a class="navbar-brand" href="manager"><i class="fa fa-home fa-1x"></i>  Панель керування</a>
	</div>
	<div class="navbar-collapse collapse">
	  <ul class="nav navbar-nav navbar-right">
	     <?php if($ssID->privileges == 4 && file_exists($ROOT.'/logs/error.log') &&  filesize($ROOT.'/logs/error.log') > 0): ?><li><a href="logs/error.log" target="_blank"><span class="label label-danger label-as-badge"><i class="fa fa-exclamation-circle"></i> <?php echo count(file($ROOT.'/logs/error.log', FILE_SKIP_EMPTY_LINES)); ?></span></a></li><?php endif; ?>
		<li><a id="nav-login"><i class="fa fa-user<?php if($ssID->privileges == 4) echo '-secret'; ?>"></i> <b><?php echo $ssID->login; ?></b></a></li>
		<li><a href="<?php echo $cfg['host']['catalog']; ?>" target="_blank"><i class="fa fa-globe"></i> Сайт</a></li>
		<?php if($ssID->privileges == 4): ?><li><a href="manager/user/messages"><i class="fa fa-envelope"></i> Повідомлення <span class="badge messages-count"><?php echo manager::newmessages(); ?></span></a></li><?php endif; ?>
		<li><a href="manager/profile/get" data-toggle="modal" data-target="#ModalDialog" data-backdrop="static" data-keyboard="false"><i class="fa fa-wrench"></i> Профіль</a></li>
		<li><a href="manager/user/signout"><i class="fa fa-power-off"></i> Вихід</a></li>
	  </ul>
	</div>
  </div>
</div>