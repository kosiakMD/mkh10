function loadMessage(){
	$.ajax({
		type: 'POST',
		url: 'manager/user/messages/get',
		cache: false,
		dataType: 'json'
	}).done(function(ServerResponse){
		$('.messages-wrapper').html(ServerResponse.text);
		$('.messages-count').html(ServerResponse.count);
		$('.delete-message').click(deleteMessage);
		$('.delete-message').tooltip();
	}).fail(function(jqXHR, textStatus, errorThrown){
		$('.messages-wrapper').html('<div class="bs-callout bs-callout-danger text-left text-danger"><i class="fa fa-exclamation-circle"></i> Не вдалося завантажити список повідомлень!</div>');
	}).always(function(){
		$('#MessagesPreloader').remove();
	});
}

function deleteMessage(){
	var Message = $(this).parent();
	$.ajax({
		type: 'GET',
		url: 'manager/user/messages/delete/' + Message.data('id'),
		cache: false,
		dataType: 'json',
		beforeSend : function(xhr, opts){
			Message.find('.delete-message').tooltip('destroy');
			Message.find('.delete-message').html('<img src="img/loading.gif">');
		}
	}).done(function(ServerResponse){
		if(ServerResponse.status == 'success'){
			Message.find('.delete-message').hide();
			Message.addClass('bounceOutRight animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
				Message.remove();
				if($('.message').length == 0){
					$('.messages-wrapper').html('Немає нових повідомлень...');
					$('.messages-count').html('');
				}
				loadMessage();
			});
		}
	}).always(function(){
		Message.find('.delete-message').html('&times;');
		Message.find('.delete-message').tooltip();
	});
}

$(document).ready(function(){
	loadMessage();
});