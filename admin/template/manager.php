<?php include_once 'manager.nav.navbar.php'; ?>
<?php include_once 'manager.modal.php'; ?>
<div class="se-pre-con"></div>
<div class="container-fluid">
  <div class="row">
     <div class="col-md-1 hidden-sm hidden-xs" id="CompactMenu">
	 <?php include_once 'manager.nav.sidebar.compact.php'; ?>
	 </div>
	 <div class="col-md-2 sidebar hidden-sm hidden-xs" id="SimpleMenu">
	<?php include_once 'manager.nav.sidebar.php'; ?>
	</div>
	<script>setupMenu();</script>
	<div class="<?php echo ((isset($_COOKIE['menuType']) && $_COOKIE['menuType'] == '0') ? 'col-md-11' : 'col-md-10 col-md-offset-2'); ?> main">
	<?php if($RouteID !== 8) include_once 'manager.nav.tabs.php'; ?>
	<div class="tab-content">
	 <div class="tab-pane active">
	  <h2 class="page-header"><?php $PageRegs = explode('|', $PageTitle); echo (($RouteID === 8) ? $PageTitle : trim($PageRegs[1])); ?></h2>
	  <div class="row">
	  <div class="alert alert-success col-md-12 hidden" id="PageMessage"><i class="fa fa-check"></i> <span class="text"></span></div>
	  </div>
	  <?php 
	  switch($RouteID){
		  case 7:
		  include_once 'manager.messages.php';
		  break;
		  
		  case 8:
		  include_once 'manager.panel.php';
		  break;
		  
		  case 9:
		  include_once 'manager.pages.php';
		  break;
		  
		  case 10:
		  include_once 'manager.pages.editor.php';
		  break;
		  
		  case 11:
		  include_once 'manager.files.php';
		  break;
		  
		  case 15:
		  include_once 'manager.backup.db.php';
		  break;
		  
		  case 17:
		  include_once 'manager.backup.files.php';
		  break;
		  
		  case 18:
		  include_once 'manager.users.php';
		  break;
		  
		  case 19:
		  include_once 'manager.upload.php';
		  break;
		  
		  case 22:
		  include_once 'manager.categories.php';
		  break;  
		  
		  case 26:
		  include_once 'manager.navigation.php';
		  break;
		  
		  case 28:
		  include_once 'manager.stats.php';
		  break;
		  
		  case 29:
		  include_once 'manager.logs.php';
		  break;
		  
		  case 30:
		  include_once 'manager.sysinfo.php';
		  break;
		  
		  case 31:
		  include_once 'manager.events.php';
		  break;
	  }
	  ?>
	 </div>
	</div>
	<?php include_once 'manager.footer.php'; ?>
	</div>
  </div>
</div>