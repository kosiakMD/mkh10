<!DOCTYPE html>
<html lang="uk" ng-app="multiLang" manifest="icd.appcache" >
<head>
	<meta http-equiv="Content-Type" content="text/html; application/javascript; charset=UTF-8" other="text/html">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>МКХ-10 - ADMIN</title>

	<link rel="shortcut icon" href="../public/img/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" sizes="270x270" href="../public/img/apple-touch-icon-270x270.png" />

	<!-- Bootstrap core CSS -->
		<link href="../public/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- My CSS -->
		<!-- <link href="../../public/css/style.min.css" rel="stylesheet"> -->
		<!-- <link href="../../public/css/style.css" rel="stylesheet"> -->

		<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
		<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
		<!--script src="./Off Canvas Template for Bootstrap_files/ie-emulation-modes-warning.js" type="text/javascript"></script-->

	<style type="text/css">
	.element:hover{background: rgba(100,100,100,0.3)}
	.element:hover input{
		background: rgba(0,250,250,0.1);
	}
	.element input:focus{
		background: rgb(171, 215, 228);
	}
	</style>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>

<body >
	<!--[if lt IE 8]>
		<p class="browserupgrade">Ви використовуєте <strong>застарілий</strong>браузер. Будь ласка <a href="http://browsehappy.com/">оновіть браузер<a> щоб поліпшити свій досвід.</p>
		<p class="browserupgrade">You are using an <strong>outdated</strong>browser. Please <a href="http://browsehappy.com/">upgrade your browser<a> to improve your experience.</p>
	<![endif]-->

	<!-- Rreloader XHR -->
	<div id="preloader" class="" style="display:none; position:fixed; width:100%; height:100%; z-index:9999; background: rgba(250,250,250,0.5) url(../public/img/loader.gif) no-repeat 50% 50%; z-index: 1031;">
		<ul id="loadingList" style="position:absolute; bottom: 0; color:white; list-style: none; width: 50%; left: 50%; margin-left: -25%;"></ul>
	</div>

	<!-- Modal Window -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title text-center" id="myModalLabel">{{ml.modal.Update}}</h4>
				</div>
				<div class="modal-body">
					<!-- <div>There is update for downloading available.</div> -->
					<div id="update_lang" class="hidden">{{ml.modal.Laguage}}</div>
					<div id="update_db" class="hidden">{{ml.modal.DB}}</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="loadDismiss" class="pull-left btn btn-default" data-dismiss="modal">{{ml.modal.Dismiss}}</button>
					<button type="button" id="loadButton" data="" class="btn btn-primary">{{ml.modal.Download}}</button>
				</div>
			</div>
		</div>
	</div>

	<!-- NAVigation MENU navbar -->
	<nav id="top_menu" class="navbar navbar-fixed-top navbar-inverse ">
		<!-- container -->
		<div class="container">
			<!-- nav-header -->
			<div class="navbar-header" itemscope itemtype="http://schema.org/Product">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<span class="hidden" itemprop="name">МКХ 10 - Міжнародна класифікація хвороб</span>
				<a class="navbar-brand" href="http://mkh10.com.ua" itemprop="url">
					<span>МКХ 10</span>
				</a>
			</div>
			<!-- /nav-header -->
			<!-- navbar-collapse -->
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="">
						<a href="/">
							<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
							Головна
						</a>
					</li>
					<li class="" data-toggle="tooltip" data-placement="bottom" title="Альтернативна версія МКХ 10">
						<a href="./web" >
							<span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>
							Класи
						</a>
					</li>
					<li class="active" data-toggle="tooltip" data-placement="bottom" title="Альтернативна версія МКХ 10">
						<a href="./web" >
							<span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>
							Блоки
						</a>
					</li>
					<li class="" data-toggle="tooltip" data-placement="bottom" title="Альтернативна версія МКХ 10">
						<a href="./web" >
							<span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>
							Нозології
						</a>
					</li>
					<li class="" data-toggle="tooltip" data-placement="bottom" title="Альтернативна версія МКХ 10">
						<a href="./web" >
							<span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>
							Діагнози
						</a>
					</li>
					<li class="dropdown ">
						<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
							<span class="glyphicon glyphicon-flag" aria-hidden="true"></span> {{ml.menu.Language}} <span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li class="dropdown-header">{{ml.name}} ({{ml.code}}: {{ml.version}})</li>
							<li role="separator" class="divider"></li>
							<li ng-repeat="al in ml.langs">
								<a href="" data-lang="{{al.code}}" class="technic changeLang">{{al.name}} ({{al.code}}: {{al.version}})</a>
							</li>
						</ul>
					</li>
					<li>
					</li>
				</ul>
				
				<div class="pull-right">
					<button id="add_string" disabled="disabled" class="btn btn-default  glyphicon glyphicon-arrow-left" title="New Line"></button>
					<button id="add_string" disabled="disabled" class="btn btn-default  glyphicon glyphicon-arrow-right" title="New Line"></button>
					<button id="add_string" class="btn btn-default  glyphicon glyphicon-triangle-bottom" title="New Line"></button>
					<button id="add_string" class="btn btn-default  glyphicon glyphicon-triangle-top" title="New Line"></button>
					<button id="add_string" class="btn btn-success " title="New Line">+</button>
				</div>
			</div><!-- /nav-collapse -->
		</div><!-- /container -->
	</nav><!-- /NAVigation navbar -->

	<!--	CONTENT	-->
<br><br><br>
	<!--container-->
	<div class="container-fluid">
		
		<!--row-->
		<div id="view_content" class="row row-offcanvas " ng-view="content">
			<!-- inner html -->
			<div class="container">
				<!-- <div class="col-xs-12 text-center"> -->
					<div class="col-md-1 col-xs-3 ">Letter1</div>
					<div class="col-md-1 col-xs-3 ">Number1</div>
					<div class="col-md-1 col-xs-3 ">Letter2</div>
					<div class="col-md-1 col-xs-3 ">Number2</div>
					<div class="col-md-8 col-xs-12 text-center">Label</div>
				<!-- </div> -->
			</div>
			<div id="list" class="container">
				<?php
					$json_file = json_decode( file_get_contents('../public/db/blocks.json') );
					 // print_r( $json_file );
					$n = 0;
					foreach ($json_file as $block => $val) { $n++;?>
					<div class="row element">
						<div class="col-md-1 number text-center"><?=$n?></div>
						<div class="row col-xs-10 col-md-3">
							<input class="col-md- col-xs-3 text-center" value="<?=$val->l1?>" />
							<input class="col-md- col-xs-3 text-center" value="<?=$val->n1?>" />
							<input class="col-md- col-xs-3 text-center" value="<?=$val->l2?>" />
							<input class="col-md- col-xs-3 text-center" value="<?=$val->n2?>" />
						</div>
						<div class="col-md-1 col-xs-2 pull-right">
							<button class="btn btn-danger btn-xs col-xs-12 action" data-action="delete" data-target="" title="Delete">-</button>
						</div>
							<input class="col-md-7 col-xs-12" value="<?=$val->label?>" />
						<br>
					</div>
					<? } ?>
			</div>
			<div id="sample" class="container hidden">
				<div class="row element">
						<div class="col-md-1 number text-center"></div>
						<div class="row col-xs-10 col-md-3">
						<input class="col-md- col-xs-3 text-center" value="" />
						<input class="col-md- col-xs-3 text-center" value="" />
						<input class="col-md- col-xs-3 text-center" value="" />
						<input class="col-md- col-xs-3 text-center" value="" />
					</div>
						<div class="col-md-1 col-xs-2 pull-right">
							<button class="btn btn-danger btn-xs col-xs-12 action" data-action="delete" data-target="" title="Delete">-</button>
						</div>
						<input class="col-md-7 col-xs-12" value="" />
					<br>
				</div>
			</div>
			<div id="trash" class="hidden"></div>
		</div>
		<!--/row-->
		<hr>
	</div><!--/.container-->

	<footer class="footer footer-inverse">
		<div class="container">

		</div>
	</footer>


	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<!--script src="./Off Canvas Template for Bootstrap_files/jquery.min.js"></script>
	<script src="./Off Canvas Template for Bootstrap_files/bootstrap.min.js"></script-->


	<script src="../public/js/vendor/jquery-1.11.3.min.js" ></script>

	<script src="../public/libs/jqui/jquery-ui.min.js" ></script>

	<script src="../public/libs/bootstrap/js/bootstrap.min.js" ></script>
	<script>
		$(window).load(function(){});
		$(function () {
		})

		//-------------- ACTions
		$("body").on('click change switchChange.bootstrapSwitch', ".action", function(e){
			e.preventDefault();
			var action = $(this).data("action"),
					el = $(this);
			action = action.split(" ");
			$(action).each(function(key, value){
				console.log("\t^ action -> " + value)
				switch (value){
					case "delete":
						console.log("delete");
						var $trash = el.parent().parent();
						$trash.data("position", $trash.index());
						console.log($trash.data("position"));
						$trash.appendTo("#trash");
					break;
					default:
						console.log("action empty");
					break;
				}
			});
			// send({fn : "updateItems"});
		});
		$("#add_string").click(function(){
			$("html, body").animate({ scrollTop: $(document).height() }, 100);
			// $("html, body").css({scrollTop: $(document).height()});
			var numb = $("#list .element").last().find(".number").text();
			$("#sample .element").clone().find(".number").text(numb).end().appendTo("#list");
		});
		$(document).keyup(function(e) {//console.log(e);
			// [ Escape ] pressed while dialog open
			// if (e.keyCode == 27 && $("#dialog").css("display") == "block") {}
			// [ CTRL + Del ] pressed
			/*if ( e.ctrlKey && e.which === 46 ) {
				if( $autobuy_val.attr("disabled") ){
					$autobuy_ok.click();
					$autobuy_val.focus().select();
				}else{
					$autobuy_val.focus().select();
				}
			}*/
			if ( e.ctrlKey && e.which === 46 ) {
				console.log("ctrl+Del");
			}
			if( e.ctrlKey && e.which == 90 ) {
				console.log("ctrl+Z");
				var $el = $("#trash .element").last(),
						pos = $el.data("position");
				$el.insertAfter( $("#list .element").eq(pos-1) );
			}
		});
		function save(){
			$("#preloader").toggle();
			var arr = [];
			$("#list .element").each(function(){
				var val_0 =  $(this).find("input").eq(0).val(),
					val_1 =  $(this).find("input").eq(1).val(),
					val_2 =  $(this).find("input").eq(2).val(),
					val_3 =  $(this).find("input").eq(3).val(),
					val_4 =  $(this).find("input").eq(4).val();
				if( !val_0 || !val_1 || !val_2 || !val_3 || !val_4 ){
					return true;
				}
				var obj = {
					l1 : val_0,
					n1 : val_1,
					l2 : val_2,
					n2 : val_3,
					label : val_4
				}
				arr.push(obj);
			});
			console.log(arr)
			// console.log( JSON.stringify(arr) );
			$("#preloader").toggle();
		}
	</script>
</body>
</html>