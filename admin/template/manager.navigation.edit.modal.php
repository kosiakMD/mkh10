<form action="manager/navigation/save" method="post">
<input type="hidden" name="NavID" value="<?php echo ((isset($NavData)) ? $NavData->id : '0'); ?>">
  <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="myModalLabel"><?php echo ((isset($NavData)) ? 'Редагування' : 'Створення'); ?> пункту навігації</h4>
  </div>
  <div class="modal-body">
   <div class="form-message hidden"><i class="fa fa-exclamation-triangle"></i> <span class="text"></span></div>
   <div class="input-group">
	  <span class="input-group-addon"><i class="fa fa-edit"></i></span>
	  <input type="text" class="form-control required" name="NavName" value="<?php echo ((isset($NavData)) ? $NavData->title : ''); ?>" placeholder="Підпис пункту навігації" data-minlength="1" maxlength="255">
	  <span class="input-group-addon send-loader hidden"><img src="img/loading.gif"></span>
   </div>
   <div class="input-group">
	  <span class="input-group-addon"><i class="fa fa-picture-o"></i></span>
	  <select class="form-control selectpicker show-menu-arrow" name="NavIcon" data-size="5" data-show-subtext="true" data-selected="<?php if(isset($NavData)) echo $NavData->icon; ?>" data-show-icon="true">
	    <option value="" data-subtext="-"></option>
	    <?php include_once($ROOT.'/template/manager.icons.list.php'); ?>
	  </select>
   </div>
    <div class="input-group">
	  <span class="input-group-addon"><i class="fa fa-sort"></i></span>
	  <input type="number" class="form-control required" id="NavPosition" name="NavPosition" value="<?php echo ((isset($NavData)) ? $NavData->position : ((isset($NewPosition)) ? $NewPosition : '')); ?>" min="1" max="9999" placeholder="Позиція" data-minlength="1" maxlength="4">
   </div>
    <div class="input-group">
	  <span class="input-group-addon"><i class="fa fa-cogs"></i></span>
	  <select class="form-control" name="NavType">
	    <option value="1"<?php echo ((isset($NavData) && $NavData->type == 1) ? ' selected' : ''); ?>>Посилання</option>
	    <option value="2"<?php echo ((isset($NavData) && $NavData->type == 2) ? ' selected' : ''); ?>>Категорія</option>
	  </select>
   </div>
   <div id="NavCategoryList" class="input-group<?php echo ((!isset($NavData) || (isset($NavData) && $NavData->type == 1)) ? ' hidden' : ''); ?>">
	  <span class="input-group-addon"><i class="fa fa-list-alt"></i></span>
	  <select class="form-control" name="NavCategory">
	   <?php echo $CategoriesList; ?>
	  </select>
   </div>
   <div class="NavLinkInput input-group<?php echo ((isset($NavData) && $NavData->type == 2) ? ' hidden' : ''); ?>">
	  <span class="input-group-addon"><i class="fa fa-link"></i></span>
	  <input type="text" class="form-control" name="NavLink" value="<?php echo ((isset($NavData) && $NavData->type == 1) ? $NavData->href : ''); ?>" placeholder="Посилання на сторінку" maxlength="255">
   </div>
   <div class="NavLinkInput input-group<?php echo ((isset($NavData) && $NavData->type == 2) ? ' hidden' : ''); ?>">
	  <span class="input-group-addon"><i class="fa fa-reply"></i></span>
	  <select class="form-control" name="NavBlank">
	    <option value="0"<?php echo ((isset($NavData) && !$NavData->blank) ? ' selected' : ''); ?>>Негайний перехід</option>
	    <option value="1"<?php echo ((isset($NavData) && $NavData->blank) ? ' selected' : ''); ?>>В новому вікні</option>
	  </select>
   </div>
  </div>
  <div class="modal-footer">
	<button type="submit" class="btn btn-success"><i class="fa fa-<?php echo ((isset($NavData)) ? 'floppy-o' : 'plus'); ?>"></i> <?php echo ((isset($NavData)) ? 'Зберегти' : 'Створити'); ?> пункт навігації</button>
	<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Відміна</button>
  </div>
</form>
<script src="js/form.js"></script>
<script src="js/navigation.edit.js"></script>
<script src="js/bootstrap-select.init.js"></script>