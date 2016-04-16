<form action="manager/files/create/<?php echo $ObjectType;?>/query" method="post">
  <input type="hidden" name="ManagerPath" value="<?php echo $ManagerPath; ?>">
  <input type="hidden" name="ObjectType" value="<?php echo $ObjectType;?>">
  <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="myModalLabel">Створення <?php echo (($ObjectType == 'dir') ? 'каталогу' : 'файлу'); ?></h4>
  </div>
  <div class="modal-body">
   <div class="form-message hidden"><i class="fa fa-exclamation-triangle"></i> <span class="text"></span></div>
   <div class="input-group">
	  <span class="input-group-addon"><i class="fa fa-<?php echo (($ObjectType == 'dir') ? 'folder' : 'file'); ?>"></i></span>
	  <input type="text" class="form-control required special" name="NewObjectName" placeholder="Назва <?php echo (($ObjectType == 'dir') ? 'каталогу' : 'файлу'); ?>" data-minlength="1" maxlength="200">
	  <span class="input-group-addon send-loader hidden"><img src="img/loading.gif"></span></span>
   </div>
  </div>
  <div class="modal-footer">
	<button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Створити <?php echo (($ObjectType == 'dir') ? 'каталог' : 'файл'); ?></button>
	<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Відміна</button>
  </div>
</form>
<script src="js/form.js"></script>