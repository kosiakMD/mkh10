$(document).ready(function(){
	$('.selectpicker').selectpicker({iconBase:'fa',tickIcon:'fa-check'});
	$('.selectpicker').each(function(index){$(this).val($(this).data('selected'));});
	$('.selectpicker').selectpicker('render');
});