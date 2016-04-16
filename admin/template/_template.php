<!DOCTYPE html>
<html lang="uk">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<base href="<?php echo Kernel::BaseURL(); ?>">
    <title><?php echo $PageTitle; ?></title>
	<link rel="shortcut icon" href="img/favicon.ico" />
     <link href="css/bootstrap.min.css" rel="stylesheet">
	 <?php if(in_array($RouteID, array(7, 30))): ?>
	<link href="css/docs.min.css" rel="stylesheet">
	<?php endif; ?>
	<?php if($RouteID === 7): ?>
    <link href="css/animate.min.css" rel="stylesheet">
	<?php endif; ?>
	<link href="css/font-awesome.min.css" rel="stylesheet">
	 <?php if(in_array($RouteID, array(10, 18, 26))): ?>
	 <link href="css/bootstrap-select.min.css" rel="stylesheet">
	 <?php endif; ?>
	<?php if(in_array($RouteID, array(9, 11, 17, 18, 19, 22, 26, 29))): ?>
     <link href="css/table.css" rel="stylesheet">
	<?php endif; ?>
	<?php if($RouteID === 2): ?>
    <link href="css/auth.css" rel="stylesheet">
	<?php endif; ?>
	<?php if($RouteID === 15): ?>
	<link href="css/shCore.css" rel="stylesheet">
	<link href="css/shCoreDefault.css" rel="stylesheet">
	<?php endif; ?>
	<?php if($RouteID === 19): ?>
	<link href="css/fileinput.min.css" rel="stylesheet">
	<?php endif; ?>
	<?php if(in_array($RouteID, array(28))): ?>
	<link href="css/morris.css" rel="stylesheet">
	<?php endif; ?>
	<?php if(in_array($RouteID, array(28, 31))): ?>
	<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<?php endif; ?>
	<?php if($RouteID === 31): ?>
	<link href="css/fullcalendar.min.css" rel="stylesheet">
	<?php endif; ?>
	<?php if($RouteID !== 2): ?>
    <link href="css/common.css" rel="stylesheet">
	<?php endif; ?>
	<link href="css/jquery-labelauty.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-scrollTo.min.js"></script>
	<script src="js/jquery-cookie.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<?php if(in_array($RouteID, array(10, 26))): ?>
	<script src="js/bootstrap-select.min.js"></script>
	<?php endif; ?>
	<?php if($RouteID === 10): ?>
	<script src="js/bootstrap-select.init.js"></script>
	<?php endif; ?>
	<?php if($RouteID === 2): ?>
	<script src="js/jquery-cookie.js"></script>
	<script src="js/jquery-md5.js"></script>
	<script src="js/form.js"></script>
	<script src="js/auth.js"></script>
	<?php endif; ?>
	<?php if($RouteID === 7): ?>
	<script src="js/messages.js"></script>
	<?php endif; ?>
	<?php if(in_array($RouteID, array(9, 11, 18, 19, 22, 26, 29))): ?>
	<script src="js/jquery.table.min.js"></script>
	<script src="js/jquery.table.init.js"></script>
	<?php endif; ?>
	<?php if($RouteID === 15): ?>
	<script src="js/shCore.js"></script>
	<script src="js/shBrushSql.js"></script>
	<script src="js/shInit.js"></script>
	<?php endif; ?>
	<?php if($RouteID === 19): ?>
	<script src="js/fileinput.min.js"></script>
	<script src="js/fileinput.init.js"></script>
	<?php endif; ?>
	<script src="js/jquery-labelauty.js"></script>
	<?php if($RouteID === 10): ?>
	<script src="js/tinymce/tinymce.min.js"></script>
	<script src="js/tinymce.init.js"></script>
	<script src="js/translit.js"></script>
	<script src="js/exit-coniformation.js"></script>
	<?php endif; ?>
	<script src="js/common.js"></script>
	<?php if(in_array($RouteID, array(28))): ?>
	<script src="js/raphael-min.js"></script>
	<script src="js/morris.min.js"></script>
	<?php endif; ?>
	<?php if(in_array($RouteID, array(28, 31))): ?>
	<script src="js/moment.min.js"></script>
	<script src="js/bootstrap-datetimepicker.min.js"></script>
	<?php endif; ?>
	<?php if($RouteID === 31): ?>
	<script src="js/fullcalendar.min.js"></script>
	<?php endif; ?>
  </head>
  <body>
  <?php 
	switch($RouteID){
		case 2: $ModulePage = 'auth'; break;
		default: $ModulePage = 'manager'; break;
	}
	include_once($ModulePage.'.php'); 
  ?>
  
  </body>
</html>