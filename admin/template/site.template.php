<!DOCTYPE html>
<html lang="uk">
  <head>
	<meta http-equiv="content-language" content="uk">
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<base href="<?php echo Kernel::BaseURL(); ?>">
	<?php echo $MetaData; ?>
	<title><?php echo $siteCfg['site']['title']; ?> | <?php echo $Page['title']; ?></title>
	<link rel="shortcut icon" type="image/x-icon" href="site/img/favicon.ico">
	<link rel="icon" type="image/png" href="site/img/favicon/16x16.png" sizes="16x16">
	<link rel="icon" type="image/png" href="site/img/favicon/32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="site/img/favicon/48x48.png" sizes="48x48">
	<link rel="icon" type="image/png" href="site/img/favicon/96x96.png" sizes="96x96">
	<link rel="apple-touch-icon" href="site/img/apple-touch-icon.png" />
	<link rel="apple-touch-icon" sizes="57x57" href="site/img/apple-touch-icon/57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="site/img/apple-touch-icon/60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="site/img/apple-touch-icon/72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="site/img/apple-touch-icon/76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="site/img/apple-touch-icon/114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="site/img/apple-touch-icon/120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="site/img/apple-touch-icon/144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="site/img/apple-touch-icon/152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="site/img/apple-touch-icon/180x180.png">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap.alignment.min.css" rel="stylesheet">
	<link href="css/docs.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/animate.min.css" rel="stylesheet">
	<link href="css/morris.css" rel="stylesheet">
	<link href="site/css/common.css" rel="stylesheet">
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/lazy-bootstrap-carousel-v3.js"></script>
	<script src="js/jquery-scrollTo.min.js"></script>
	<script src="js/jquery-cookie.js"></script>
	<script src="js/jquery.gdocsviewer.min.js"></script>
	<script src="js/raphael-min.js"></script>
	<script src="js/morris.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;language=uk"></script>
	<?php if(in_array(date('n'), array(1, 2, 12))): ?>
	<script src="site/js/snow.js"></script>
	<?php endif; ?>
	<script src="site/js/common.js"></script>
  </head>
  <body>
  <div class="se-pre-con"></div>
  <div class="modal fade bs-example-modal-lg" id="ContactsWindow" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		     <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Адреса на карті</h4>
			</div>
			<div class="modal-body">
			<p><button type="button" id="center-map" class="btn" title="Показати на карті"><i class="fa fa-map-marker"></i></button>&nbsp;&nbsp; 21018, Україна, м.Вінниця, вул. Пирогова, 56</p>
			<div id="map_canvas"></div>
			</div>
			<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Закрити</button></div>
		</div>
	  </div>
  </div>
  <div class="modal vertical-centered fade bs-example-modal-sm" id="LoginLoader" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
	<div class="modal-content">
	 <div class="modal-body">	 
	  <center>
	   <div><img src="site/img/login-loader.gif" id="LoginLoaderImage"></div>
	   <div>Виконується вхід, зачекайте...</div>
	  </center>
	 </div>
	</div>
    </div>
  </div>
  <div class="contacts">
   <div class="container">
    <div id="up-button"><i class="fa fa-chevron-up"></i></div>
    <div id="nav-menu">
	  <div id="nav-menu-transparent"></div>
		<?php echo $PageNav; ?>
    </div>
    <div class="row">
	  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3 text-left">
	   <a class="nav-button" id="nav-menu-button"><i class="fa fa-navicon"></i><span class="hidden-xs"> Меню</span></a>
	  </div>
	  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-6 text-left">
	   <a class="hidden-xs hidden-sm"><i class="fa fa-phone contact"></i> (0432)-57-07-21</a>
	   <a href="mailto:anatomy@vnmu.edu.ua" class="hidden-xs hidden-sm" data-toggle="tooltip" data-placement="bottom" title="Написати листа"><i class="fa fa-envelope contact"></i> anatomy@vnmu.edu.ua</a>
	   <a href="#" class="hidden-xs hidden-sm" data-toggle="modal" data-target="#ContactsWindow" data-placement="bottom" title="Знайти на карті"><i class="fa fa-map-marker contact"></i> м. Вінниця, вул. Пирогова 56</a>
	  </div>
	 <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3 text-right">
	  <?php if(is_null($StudentSSID)): ?>
	  <a class="nav-button" id="sign-in-button"><i class="fa fa-sign-in"></i><span class="hidden-xs"> Вхід</span></a>
	  <?php else: ?>
	  <a href="site/cabinet" class="nav-button" data-toggle="tooltip" data-placement="bottom" title="Особистий кабінет"><i class="fa fa-user"></i></a>
	  <a class="nav-button" id="sign-out-button"><i class="fa fa-sign-out"></i><span class="hidden-xs"> Вихід</span></a>
	  <?php endif; ?>
	 </div>
    </div>
   </div>
  </div>
  <div class="login-box">
   <div class="container">
    <div class="row">
	 <div class="col-md-12">
	  <div class="row">
	  <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12 text-left" id="LoginMessages"></div>
	   <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-right">
	    <input type="text" class="form-control" name="Login" placeholder="Логін" maxlength="6">
	   </div>
	   <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 text-right">
	    <input type="password" class="form-control" name="Password" placeholder="Пароль" maxlength="6">
	   </div>
	   <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 text-left">
	    <button type="button" class="btn btn-success" id="LoginButton"><i class="fa fa-lock"></i> Вхід до системи</button>
	   </div>
	  </div>
	 </div>
	</div>
   </div>
  </div>
  <div id="carousel-logo" class="carousel slide carousel-fade" data-ride="carousel" data-pause="false" data-interval="7000">
	<div class="carousel-inner">
	    <div class="container">
		 <a href="/" id="logo">
		  <img src="site/img/logo.svg">
		  <h2>Кафедра анатомії людини</h2>
		  <h3>ВНМУ імені М.І. Пирогова</h3>
		  <div class="transparent"></div>
		 </a>
	    </div>
		<?php foreach(glob($ROOT.'/site/img/header/*.jpg') as $HeaderImage): ?>
		<div class="item">
		  <img lazy-src="site/img/header/<?php echo basename($HeaderImage); ?>">
		</div>
		<?php endforeach; ?>
	</div>
   </div>
   <div class="starting">
	 <div class="container">
	  <div class="row">
	   <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12 text-left">
		<h2>Вас вітає Кафедра анатомії людини</h2>
		<h3>ВНМУ імені М.І. Пирогова</h3>
	   </div>
	   <div class="col-lg-3 col-md-3 text-right visible-lg">
	     <img src="site/img/greeting.svg">
	   </div>
	  </div>
      </div>
   </div>
   <div class="container">
	<div class="row main">
	 <?php if(!isset($StudentCabinet)): ?>
	 <div class="col-lg-<?php echo ((!$Page['fullscreen']) ? '9' : '12'); ?> col-md-<?php echo ((!$Page['fullscreen']) ? '9' : '12'); ?> col-sm-11 col-xs-11 text-left">
	  <h2 class="page-header"><?php echo $Page['title']; ?></h2>
	    <?php if($Page['details']): ?>
	    <div class="page-info">
	     <i class="fa fa-user"></i> Опублікував: <b><?php echo $Page['author']; ?></b>
		 <div class="clearfix visible-xs"></div>
	     <i class="fa fa-folder-open"></i> Розділ: <b><?php echo $Page['category']; ?></b>
		 <div class="clearfix visible-xs"></div>
	     <i class="fa fa-clock-o"></i> <?php echo date("j ".$cfg['months'][date("n")-1]." Y р. G:i:s", strtotime($Page['created'])); ?>
		 <div class="clearfix visible-xs"></div>
	     <i class="fa fa-eye"></i> Перегляди: <?php echo number_format($Page['visits']); ?>
	   </div>
	   <?php endif; ?>
	   <div id="BirthdayBanner" class="bs-callout bs-callout-info hidden">
	   </div>
	   <?php echo $Page['html']; ?>
	 </div>
	 <?php if(!$Page['fullscreen']): ?>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-left pages-list">
         <h2 class="page-header"><?php echo $Page['category']; ?></h2>
		 <ul class="nav nav-pills nav-stacked">
		  <?php foreach($PagesList as $PageItem): ?>
		   <a href="<?php echo $PageItem['href'] ?>"><i class="fa fa-<?php echo $PageItem['icon']; ?>"></i> <?php echo $PageItem['title']; ?></a>
		  <?php endforeach; ?>
	      </ul>
       </div>
	  <?php endif; ?>
	 <?php else: ?>
	 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-11">
	 <?php if($StudentSSID->functional == 1){ include_once($ROOT.'/template/site.template.cabinet.php'); } ?>
	 <?php if($StudentSSID->functional == 2){ include_once($ROOT.'/template/site.template.journal.php'); } ?>
	 </div>
	 <?php endif; ?>
	</div>
   </div>
  <div id="specialities">
   <div class="container">
    <div class="row">
	<div class="col-lg-12 col-lg-offset-0 col-md-12 col-md-offset-0 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
	 <div class="row">
	 <div class="hidden col-lg-2 col-md-2 col-sm-6 col-xs-6 speciality">
	  <a href="site/content/13#m">
	   <img src="site/img/1.svg">
	   <div class="title">Лікувальна справа</div>
	  </a>
	 </div>
	 <div class="hidden col-lg-2 col-md-2 col-sm-6 col-xs-6 speciality">
	  <a href="site/content/13#m">
	   <img src="site/img/2.svg">
	   <div class="title">Педіатрія</div>
	  </a>
	 </div>
	 <div class="clearfix visible-sm visible-xs"></div>
	 <div class="hidden col-lg-2 col-md-2 col-sm-6 col-xs-6 speciality">
	  <a href="site/content/13#m">
	   <img src="site/img/3.svg">
	   <div class="title">Медична психологія</div>
	  </a>
	 </div>
	 <div class="hidden col-lg-2 col-md-2 col-sm-6 col-xs-6 speciality">
	  <a href="site/content/13#s">
	   <img src="site/img/4.svg">
	   <div class="title">Стоматологія</div>
	  </a>
	 </div>
	 <div class="clearfix visible-sm visible-xs"></div>
	 <div class="hidden col-lg-2 col-md-2 col-sm-6 col-xs-6 speciality">
	  <a href="site/content/13#p">
	   <img src="site/img/5.svg">
	   <div class="title">Фармація</div>
	  </a>
	 </div>
	 <div class="hidden col-lg-2 col-md-2 col-sm-6 col-xs-6 speciality">
	  <a href="site/content/13#p">
	   <img src="site/img/6.svg">
	   <div class="title">Клінічна фармація</div>
	  </a>
	 </div>
	 </div>
	</div>
    </div>
   </div>
  </div>
  <div id="footer">
   <div class="container">
    <div class="row footer-nav">
      <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1">
	   <div class="row">
		<?php echo str_replace(array('<a', '</a>'), array('<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 text-center"><a', '</a></div>'), $PageNav); ?>
	   </div>
	  </div>
	</div>
	<div class="row">
	 <div class="col-lg-2 col-md-3 hidden-sm hidden-xs text-center">
	   <img src="site/img/gs_logo.svg" class="grayscale-logo">
	 </div>
	 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 text-left">
	  <h3>Кафедра анатомії людини</h3>
	  <h4>ВНМУ імені М.І. Пирогова</h4>
	  <br>
	  <div><i class="fa fa-phone"></i> Телефон: (0432)-57-07-21</div>
	  <div><i class="fa fa-envelope"></i> Email: <a href="mailto:anatomy@vnmu.edu.ua">anatomy@vnmu.edu.ua</a></div>
	  <div><i class="fa fa-map-marker"></i> Адреса: м. Вінниця, вул. Пирогова 56</div>
	 </div>
	 <div class="col-lg-5 col-md-5 col-sm-5 col-xs-11 text-lg-right text-md-right text-sm-right text-xs-left copyrights">
	  <i id="device-type" class="fa fa-3x"></i>
	  <div>&copy; <?php echo date("Y"); ?> ВНМУ імені. М.І. Пирогова</div>
	  <div>Розробка та підтримка: <a href="https://vk.com/id23285018" target="_blank">bc_zim</a></div>
	  <div class="shares">
	     <a href="https://vk.com/share.php?url=http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>&title=<?php echo $siteCfg['site']['title']; ?> | <?php echo $Page['title']; ?>" target="_blank">
		  <span class="fa-stack fa" data-toggle="tooltip" data-placement="bottom" title="ВКонтакті">
			<i class="fa fa-square fa-stack-2x fa-inverse"></i>
			<i class="fa fa-vk fa-stack-1x"></i>
		  </span>
		</a>
		<a href="http://www.facebook.com/share.php?u=http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" target="_blank">
		  <span class="fa-stack fa" data-toggle="tooltip" data-placement="bottom" title="Facebook">
			<i class="fa fa-square fa-stack-2x fa-inverse"></i>
			<i class="fa fa-facebook fa-stack-1x"></i>
		  </span>
		</a>
		<a href="https://twitter.com/share?via=<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>&text=<?php echo $siteCfg['site']['title']; ?> | <?php echo $Page['title']; ?>" target="_blank">
		  <span class="fa-stack fa" data-toggle="tooltip" data-placement="bottom" title="Twitter">
			<i class="fa fa-square fa-stack-2x fa-inverse"></i>
			<i class="fa fa-twitter fa-stack-1x"></i>
		  </span>
		</a>
		<a href="https://plusone.google.com/_/+1/confirm?hl=uk&url=<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" target="_blank">
		  <span class="fa-stack fa" data-toggle="tooltip" data-placement="bottom" title="Google+">
			<i class="fa fa-square fa-stack-2x fa-inverse"></i>
			<i class="fa fa-google-plus fa-stack-1x"></i>
		  </span>
		</a>
		<a href="#" target="_blank">
		  <span class="fa-stack fa" data-toggle="tooltip" data-placement="bottom" title="RSS">
			<i id="rss-button" class="fa fa-square fa-stack-2x fa-inverse"></i>
			<i class="fa fa-rss fa-stack-1x"></i>
		  </span> 
		</a>
	  </div>
	 </div>
	</div>
   </div>
  </div>
  </body>
</html>