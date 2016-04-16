$(document).ready(function(){
	$('#ModalDialogConfirm').on('show.bs.modal', function(){
		$(this).css('z-index', '2000')
		$('.modal-backdrop.in:visible:last-child').css('z-index', '1999');
	}).on('hidden.bs.modal', function(){
		$('.modal-backdrop.in:visible:last-child').css('z-index', '1040');
	});
	$('.person-picture').bind('mouseenter.menu_events', function(){
		$('.person-picture-menu').removeClass('hidden').stop(true).slideDown('fast');
	});
	$('.person-picture').bind('mouseleave.menu_events', function(){
		$('.person-picture-menu').removeClass('hidden').stop(true).slideUp('fast');
	});
	$('.person-picture-menu a').tooltip();
	$('#PhotoDelete').click(function(){
		$('#ModalDialogConfirm').modal('show');
	});
	$('#DeletePhotoConfirmButton').click(function(){
		$.ajax({
			url: 'manager/chair/staff/photo/delete/' + $('input[name="PersonID"]').val().trim(),
			type: 'GET',
			dataType: 'json',
			beforeSend : function(xhr, opts){
				$('#ModalDialogConfirm').modal('hide');
			}
		}).done(function(ServerResponse){
			if(ServerResponse.status == 'success'){
				$('#PersonPhotoPreview').attr('src','site/img/no-photo.jpg');
				$('#PersonPhotoPreview').attr('data-src','site/img/no-photo.jpg');
				$('#PhotoDelete').hide();
			} else {
				showMessage($('div.form-message'), ServerResponse.description, 'danger', 'exclamation-triangle');
			}
		}).fail(function(jqXHR, textStatus, errorThrown){
			showMessage($('div.form-message'), textStatus + ': ' + jqXHR.responseText, 'danger', 'exclamation-triangle');
		});
	});
	$('#PhotoUpload').click(function(){ $('#PhotoUploadInput').click(); });
	$('#PhotoUploadInput').change(function(event){
		if(this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e){ $('#PersonPhotoPreview').attr('src', e.target.result); }
			reader.readAsDataURL(this.files[0]);
			$('#PhotoUploadCancel').show();
			$('div.form-message, #PhotoDelete').hide();
		}
	});
	$('#PhotoUploadCancel').click(function(){
		$('#PersonPhotoPreview').attr('src', $('#PersonPhotoPreview').data('src'));
		if($('#PersonPhotoPreview').data('src') != 'site/img/no-photo.jpg'){ $('#PhotoDelete:not(.no-photo)').show(); }
		$(this).hide();
	});
	$('#UploadPhotoForm').on('submit', function(e){
		e.preventDefault();
		var $that = $(this), formData = new FormData($that.get(0));
		$.ajax({
			url: $that.attr('action'),
			type: $that.attr('method'),
			contentType: false,
			processData: false,
			data: formData,
			dataType: 'json',
			beforeSend : function(xhr, opts){
				$('#progressbar').attr('aria-valuenow', 0);
				$('#progressbar').html('');
				$('#progressbar').css({'width': '0%'});
				$that.find('button').addClass('disabled');
				$that.find('button.close').addClass('hidden');
				$('.person-picture').fadeOut('fast');
				$('.progress').show();
				$('div.form-message').hide();
			},
			xhr: function(){
				var xhr = $.ajaxSettings.xhr();
				xhr.upload.addEventListener('progress', function(evt){
					if (evt.lengthComputable) {
						var percentComplete = Math.ceil(evt.loaded / evt.total * 100);
						$('#progressbar').attr('aria-valuenow', percentComplete);
						$('#progressbar').html(percentComplete + '%');
						$('#progressbar').css({'width': percentComplete + '%'});
					}
				}, false);
				return xhr;
			}
		}).done(function(ServerResponse){
			if(ServerResponse.status === 'success'){
				showMessage($('.form-message'), ServerResponse.description, 'success', 'check');
				$('.progress, #PersonName, button[type="submit"]').hide();
				$('.cancel-button').html('<i class="fa fa-remove"></i> Закрити');
				$('.cancel-button').click(function(){ window.location.reload(); });
			}else if(ServerResponse.status === 'error'){
				showMessage($('div.form-message'), ServerResponse.description, 'danger', 'exclamation-triangle');
				$('.person-picture').show();
			}
		}).fail(function(jqXHR, textStatus, errorThrown){
			showMessage($('div.form-message'), textStatus + ': ' + jqXHR.responseText, 'danger', 'exclamation-triangle');
			$('.person-picture').show();
		}).always(function(){
			$that.find('button.close').removeClass('hidden');
			$that.find('button').removeClass('disabled');
			$('.form-message').show();
		});
	});
});