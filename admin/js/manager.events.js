function DeleteEventConfirm(){
	$('#DeleteConfirmButton').attr('href', $(this).data('href'));
	$('#ModalDialogConfirm').modal('show');
};
$(document).ready(function(){
	$('#ModalDialogConfirm').on('show.bs.modal', function(){
		$(this).css('z-index', '2000')
		$('.modal-backdrop.in:visible:last-child').css('z-index', '1999');
	}).on('hidden.bs.modal', function(){
		$('.modal-backdrop.in:visible:last-child').css('z-index', '1040');
	});
	$('#calendar').fullCalendar({
		eventLimit: true,
		events: events,
		eventClick: function(calEvent, jsEvent, view) {
			if(calEvent.allowed == 1){
				$('#ModalDialog').modal({remote:'manager/events/edit/' + calEvent.id});
			}
		}
	});	
});
