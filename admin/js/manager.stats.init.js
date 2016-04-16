$(document).ready(function(){
	$('.start').data("DateTimePicker").maxDate($('.end').val());
	$('.end').data("DateTimePicker").minDate($('.start').val());
	$('.start').data("DateTimePicker").minDate($('.daterange').data('start-date'));
	$('.end').data("DateTimePicker").maxDate($('.daterange').data('end-date'));
	
	var chart = Morris.Area({
	  element:'graph',
	  data:[],
	  xkey:'date',
	  ykeys:['visits'],
	  labels:['Перегляди'],
	  resize: true,
	  smooth: true,
	  hideHover: true
	});
	function updateData(){
		$.ajax({
			type: 'POST',
			url: 'manager/stats/get',
			cache: false,
			data: {startDate: $('input[name="start"]').val(),endDate: $('input[name="end"]').val()},
			dataType: 'json',
			beforeSend : function(xhr, opts){
				$('div#PageMessage, #graph').hide();
			}
		}).done(function(ServerResponse){
			chart.setData(ServerResponse);
			$('#graph').fadeIn();
		}).fail(function(jqXHR, textStatus, errorThrown){
			showMessage($('div#PageMessage'), textStatus + ': ' + jqXHR.responseText, 'danger', 'exclamation-triangle');
		}).always(function(){
			$('#ModalLoading').modal('hide');
		});
		//setTimeout(updateData, 2000);
	}
	$('.start, .end').each(function(){
		$(this).datetimepicker().on('dp.change', function(event){
			$('#ModalLoading').modal('show');
			updateData();
		});
	});
	updateData();
});