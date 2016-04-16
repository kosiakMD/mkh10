function SavePage(){
	if($('input[name="PageTitle"]').val().trim().length < 1){
		$('html, body').animate({ scrollTop:0 }, 'fast');
		showPopover($('input[name="PageTitle"]'), '<i class="fa fa-exclamation-triangle"></i> Заповніть це поле!');
		return;
	}
	if($('select[name="PageCategory"]').val() == '0'){
		$('html, body').animate({ scrollTop:0 }, 'fast');
		showPopover($('select[name="PageCategory"]'), '<i class="fa fa-exclamation-triangle"></i> Оберіть категорію!');
		return;
	}if($.trim(tinymce.activeEditor.getContent()).length < 8){
		$('html, body').animate({ scrollTop:0 }, 'fast');
		showPopover($('#editplace'), '<i class="fa fa-exclamation-triangle"></i> Створіть контент!');
		return;
	}
	
	$.ajax({
		type: 'POST',
		url: 'manager/content/save', 
		cache: false,
		data: {
			id: $('input[name="PageID"]').val().trim(),
			title: $('input[name="PageTitle"]').val().trim(), 
			alias: (($('#PageAliasEnabled').is(':checked')) ? $('input[name="PageAlias"]').val().trim() : 'NULL'),
			category: $('select[name="PageCategory"]').val(), 
			position: $('input[name="PagePosition"]').val().trim(), 
			activity: (($('input[name="PageActive"]').is(':checked')) ? '1' : '0'), 
			fullscreen: (($('input[name="PageFullscreen"]').is(':checked')) ? '1' : '0'), 
			details: (($('input[name="PageDetails"]').is(':checked')) ? '1' : '0'), 
			content: $.trim(tinymce.activeEditor.getContent()),
			icon: $('select[name="PageIcon"]').val()
		},
		beforeSend : function(xhr, opts){
			$('div#PageMessage').addClass('hidden');
			$('.required').popover('hide');
			$('#ModalLoading').modal('show');
		},
		dataType: 'json'
	}).done(function(ServerResponse){
		if(ServerResponse.status === 'success'){
			showMessage($('div#PageMessage'), ServerResponse.description, 'success', 'check');
			$(window).unbind('beforeunload');
			setTimeout(function(){ window.location.href = 'manager/content'; }, 2000);
		}else if(ServerResponse.status === 'error'){
			showMessage($('div#PageMessage'), ServerResponse.description, 'danger', 'exclamation-triangle');
		}
	}).fail(function(jqXHR, textStatus, errorThrown){
		showMessage($('div#PageMessage'), textStatus, 'danger', 'exclamation-triangle');
	}).always(function(){
		$('#ModalLoading').modal('hide');
		$('html, body').animate({ scrollTop:0 }, 'fast');
	});
}

$(document).ready(function(){	
		tinymce.init({
			selector: "textarea",
			theme: "modern",
			height: 270,
			language: 'uk_UA',
			plugins: [
				"advlist autolink lists link image charmap print preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars code fullscreen",
				"insertdatetime media nonbreaking save table contextmenu directionality",
				"emoticons template paste textcolor colorpicker textpattern docsembed"
			],
			valid_elements : '*[*]',
			toolbar1: "save | insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image docsembedbutton",
			toolbar2: "print preview media | forecolor backcolor emoticons | code",
			image_advtab: true,
			convert_urls: false,
			templates: [
				{title: 'Test template 1', content: 'Test 1'},
				{title: 'Test template 2', content: 'Test 2'}
			],
			save_enablewhendirty: true,
			save_onsavecallback: SavePage
		});
	$('#SavePage').on('click',SavePage);
	$('.selectpicker').selectpicker({iconBase:'fa', tickIcon:'fa-check'});
	$('select[name="PageCategory"]').change(function(){
		if($(this).val() == 0){
			$('input[name="PageFullscreen"]').prop('checked', false);
		}
	});
	$('#PageAliasEnabled').click(function(){
		$('#PageAlias').prop('disabled', !$('#PageAliasEnabled').is(':checked'));
		if($('#PageAliasEnabled').is(':checked')){
			if($('input[name="PageAlias"]').val().trim().length == 0){
				var alias = $('input[name="PageTitle"]').val().trim().toLowerCase().replace(/\s+/g, '_').transliterate().replace(/[^a-z0-9\_]+/g, '');
				$('input[name="PageAlias"]').val(alias);
			}
		}
	});
});