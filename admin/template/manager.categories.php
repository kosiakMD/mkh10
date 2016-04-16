<?php 
include_once 'table.php';
?>
<div class="row text-right">
  <a href="manager/categories/edit" data-toggle="modal" data-target="#ModalDialog" class="btn btn-success"><i class="fa fa-list-alt"></i> Створити розділ</a>
  <div class="btn-group dropup pull-left">
  <button type="button" class="btn btn-default"><i class="fa fa-list-alt"></i> Операції з виділеними: </button>
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
  <ul class="dropdown-menu" role="menu">
	<li><a href="#"><i class="fa fa-remove"></i> Видалити</a></li>
	<li><a href="#"><i class="fa fa-trash"></i> Очистити</a></li>
  </ul>
  </div>
</div>