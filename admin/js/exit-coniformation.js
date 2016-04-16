$(document).ready(function(){
	$(window).on('beforeunload', function(evt){
		var message = "Внесені зміни будуть незворотньо втрачені! Залишити сторінку?";
		if(typeof evt == "undefined"){ evt = window.event; }
		if(evt){ evt.returnValue = message; }
		return message;
	});
});