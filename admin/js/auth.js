$(document).ready(function(){
	if(!navigator.cookieEnabled){
		$('#warningMessage, .panel-footer').addClass('hidden');
		$('#warningMessage').removeClass('hidden');
	} else {
		$('.panel-body:not(#warningMessage), .panel-footer').removeClass('hidden');
	}
	$('button, a').bind('mouseover', function(){ $(this).tooltip('show'); });
	$('.close').click(function(){ $(this).parent().addClass('hidden'); });
	$('input').popover({placement: 'right', container: 'body', trigger: 'manual', html: true, content: '<i class="fa fa-exclamation-triangle"></i> Заповніть це поле!'});
	$('input').on('keyup', function(){ $(this).popover('hide'); });
	function UpdateCaptcha(){
		$('#CaptchaImage').attr('src','captcha?'+Math.random());
	}
	function showError(text){
		$('#errorMessage span.alert-text').html(text);
		$('#errorMessage').removeClass("hidden");
		$('#Password').val('');
	}
	$('form[name="LoginForm"]').on('submit', function(event){
		event.preventDefault();
		
		$(this).find('input').each(function(i){
			if(!$(this).val().trim()){
				$(this).focus();
				$(this).popover('show');
				throw new Error('Form is not valid!');
			}
		});
		
		$.ajax({
			type: 'POST',
			url: 'user/signin', 
			cache: false,
			data: {hash: $.MD5($.trim($('input[name="Login"]').val()) + $.MD5($.trim($('input[name="Password"]').val())))},
			beforeSend : function(xhr, opts){
				$('#errorMessage').addClass('hidden');
				$('input').popover('hide');
				$('#LoginLoaderWindow').modal('show');
			},
			dataType: 'json'
		}).done(function(ServerResponse){
			if(ServerResponse.status === 'success'){
				$.cookie('hash', ServerResponse.hash, {expires: 1, path: window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/')+1) + 'manager'});
				$.cookie('justLogged', '1', {expires: 1, path: '/'});
				$.cookie('menuType', '1', {expires: 1, path: '/'});
				$(location).attr('href', ServerResponse.redirect);
			}else if(ServerResponse.status === 'error'){
				showError(ServerResponse.description);
			}
		}).fail(function(jqXHR, textStatus, errorThrown){
			showError(textStatus + ': ' + jqXHR.responseText);
		}).always(function(){
			$('#LoginLoaderWindow').modal('hide');
		});
	});
	$('#RefreshCaptcha').on('click', UpdateCaptcha);
	$('#MessageDialog').on('show.bs.modal', function(){
		$(this).find('form').trigger('reset');
		UpdateCaptcha();
	});
});