<div class="modal vertical-centered fade bs-example-modal-sm" id="ModalDialogConfirm" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalDialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
	<div class="modal-content">
	 <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="myModalLabel">Підтвердження</h4>
	 </div>
	 <div class="modal-body">
	    <i class="fa fa-exclamation-triangle fa-2x" style="vertical-align:middle;margin-right:7px;"></i> Видалити дану подію?
	 </div>
	 <div class="modal-footer">
	   <a class="btn btn-danger" id="DeleteConfirmButton"><i class="fa fa-check"></i> Так</a>
	   <button class="btn btn-default" onClick="$('#ModalDialogConfirm').modal('hide');"><i class="fa fa-remove"></i> Ні</button>
     </div>
	</div>
  </div>
</div>
<div id="calendar"></div>
<div class="row text-right">
<hr>
  <a href="manager/events/edit" data-toggle="modal" data-target="#ModalDialog" class="btn btn-success"><i class="fa fa-calendar-plus-o"></i> Додати подію</a>
</div>
<script>
var events = <?php echo $EventsData; ?>;
</script>
<script src="js/manager.events.js"></script>