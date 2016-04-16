<form action="manager/events/save" method="post">
<input type="hidden" name="EventID" value="<?php echo ((isset($EventData)) ? $EventData->id : '0'); ?>">
  <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="myModalLabel"><?php echo ((isset($EventData)) ? 'Редагування' : 'Створення'); ?> події</h4>
  </div>
  <div class="modal-body">
   <div class="form-message hidden"><i class="fa fa-exclamation-triangle"></i> <span class="text"></span></div>
   <div class="input-group">
	  <span class="input-group-addon"><i class="fa fa-list-alt"></i></span>
	  <input type="text" class="form-control required" name="NewEventName" value="<?php echo ((isset($EventData)) ? $EventData->description : ''); ?>" placeholder="Опис події" data-minlength="1" maxlength="255">
	  <span class="input-group-addon send-loader hidden"><img src="img/loading.gif"></span>
   </div>
   <div class="form-group">
		<div class="input-group date">
			<span class="input-group-addon">
				<i class="fa fa-calendar"></i>
			</span>
			<input type="text" class="form-control readonly" name="NewEventDate" value="<?php echo ((isset($EventData)) ? $EventData->date : ''); ?>" placeholder="Дата події" readonly>
		</div>
   </div>
   <div class="input-group">
	  <span class="input-group-addon"><i class="fa fa-paint-brush"></i></span>
	  <select class="form-control required" name="NewEventLevel">
	   <option value="1"<?php echo ((isset($EventData) && $EventData->level == 1) ? ' selected' : ''); ?>>Червоний</option>
	   <option value="2"<?php echo ((isset($EventData) && $EventData->level == 2) ? ' selected' : ''); ?>>Жовтий</option>
	   <option value="3"<?php echo ((isset($EventData) && $EventData->level == 3) ? ' selected' : ''); ?>>Синій</option>
	   <option value="4"<?php echo ((isset($EventData) && $EventData->level == 4) ? ' selected' : ''); ?>>Блакитний</option>
	   <option value="5"<?php echo ((isset($EventData) && $EventData->level == 5) ? ' selected' : ''); ?>>Зелений</option>
	   <option value="6"<?php echo ((isset($EventData) && $EventData->level == 6) ? ' selected' : ''); ?>>Сірий</option>
	  </select>
    </div>
  </div>
  <div class="modal-footer">
     <?php if(isset($EventData)): ?>
	 <button type="button" data-href="manager/events/delete/<?php echo $EventData->id; ?>" class="btn btn-danger pull-left" id="DeleteEventButton"><i class="fa fa-trash"></i> Видалити</button>
	 <?php endif; ?>
	<button type="submit" class="btn btn-success"><i class="fa fa-calendar-<?php echo ((isset($EventData)) ? 'check' : 'plus'); ?>-o"></i> <?php echo ((isset($EventData)) ? 'Зберегти' : 'Створити'); ?> подію</button>
	<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Відміна</button>
  </div>
</form>
<script src="js/form.js"></script>
<script>
$('#DeleteEventButton').click(DeleteEventConfirm);
$('input[name="NewEventDate"]').datetimepicker({locale:"uk",useCurrent:false,ignoreReadonly:true,format:"YYYY-MM-DD HH:mm:ss"});
</script>