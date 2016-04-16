<form action="manager/categories/create/save" method="post">
<input type="hidden" name="CategoryID" value="<?php echo ((isset($CategoryData)) ? $CategoryData->id : '0'); ?>">
  <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="myModalLabel"><?php echo ((isset($CategoryData)) ? 'Редагування' : 'Створення'); ?> розділу</h4>
  </div>
  <div class="modal-body">
   <div class="form-message hidden"><i class="fa fa-exclamation-triangle"></i> <span class="text"></span></div>
   <div class="input-group">
	  <span class="input-group-addon"><i class="fa fa-list-alt"></i></span>
	  <input type="text" class="form-control required" name="NewCategoryName" value="<?php echo ((isset($CategoryData)) ? $CategoryData->name : ''); ?>" placeholder="Назва розділу" data-minlength="1" maxlength="255">
	  <span class="input-group-addon send-loader hidden"><img src="img/loading.gif"></span>
   </div>
   <div class="input-group">
       <span class="input-group-addon"><i class="fa fa-sort-alpha-asc"></i></span>
	  <select class="form-control required"name="NewCategorySortField">
		<option value="1"<?php echo ((isset($CategoryData) && $CategoryData->sorting_field == 1) ? ' selected' : '');?>>За датою додавання</option>
		<option value="2"<?php echo ((isset($CategoryData) && $CategoryData->sorting_field == 2) ? ' selected' : '');?>>За назвою сторінки</option>
		<option value="3"<?php echo ((isset($CategoryData) && $CategoryData->sorting_field == 3) ? ' selected' : '');?>>За вказаним номером позиції</option>
	  </select>
   </div>
   <div class="input-group">
       <span class="input-group-addon"><i class="fa fa-sort"></i></span>
	  <select class="form-control required"name="NewCategorySortType">
		<option value="1"<?php echo ((isset($CategoryData) && $CategoryData->sorting_type == 1) ? ' selected' : '');?>>&uarr;</option>
		<option value="2"<?php echo ((isset($CategoryData) && $CategoryData->sorting_type == 2) ? ' selected' : '');?>>&darr;</option>
	  </select>
   </div>
  </div>
  <div class="modal-footer">
	<button type="submit" class="btn btn-success"><i class="fa fa-<?php echo ((isset($CategoryData)) ? 'floppy-o' : 'plus'); ?>"></i> <?php echo ((isset($CategoryData)) ? 'Зберегти' : 'Створити'); ?> розділ</button>
	<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Відміна</button>
  </div>
</form>
<script src="js/form.js"></script>