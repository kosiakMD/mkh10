<?php
include_once 'table.php';
?>
<div class="row text-right">
<div class="btn-group dropup pull-left">
  <button type="button" class="btn btn-default"><i class="fa fa-list-alt"></i> Операції з виділеними: </button>
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
  <ul class="dropdown-menu" role="menu">
	<li><a href="#" id="DeleteAll"><i class="fa fa-trash"></i> Видалити всі</a></li>
	<li class="divider"></li>
	<li><a href="#"><i class="fa fa-file-zip-o"></i> Додати до ZIP-архіву</a></li>
  </ul>
</div>
<a href="manager/files/create/file<?php echo ((!empty($ManagerPath)) ? '/' : '').$ManagerPath; ?>" data-toggle="modal" data-target="#ModalDialog" data-backdrop="static" data-keyboard="false" class="btn btn-success"><i class="fa fa-file"></i> Новий файл</a>
<a href="manager/files/create/dir<?php echo ((!empty($ManagerPath)) ? '/' : '').$ManagerPath; ?>" data-toggle="modal" data-target="#ModalDialog" data-backdrop="static" data-keyboard="false" class="btn btn-success"><i class="fa fa-folder-open"></i> Нова папка</a>
<a href="manager/upload<?php echo ((!empty($ManagerPath)) ? '/' : '').$ManagerPath; ?>" class="btn btn-default"><i class="fa fa-download"></i> Завантажити</a>
</div>