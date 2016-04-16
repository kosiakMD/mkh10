$('#StatButton').hide();
$(document).ready(function(){
	$('#ModalLoading').on('hide.bs.modal', function(){
		$('.marks').removeClass('marks').off('dblclick').removeAttr('title').css('cursor', 'default');
	});
	$('#PrintButton').off('click').on('click', function(){
		$('.contacts, .print-button, .starting, #carousel-logo, #specialities, #footer, #JournalToolbar, #journal-data td:nth-child(1), #journal-data th:nth-child(1), .table.fixedCol').addClass('hidden-print');
		$('#journal-data').removeClass('table-responsive');
		$('.main').parent().removeClass().addClass('container-fluid');
		window.print();
		$('#journal-data').addClass('table-responsive');
		$('.main').parent().removeClass().addClass('container');
	});
});