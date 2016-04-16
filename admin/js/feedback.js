function reloadPage(ServerResponse){ 
	showMessage($('div.form-message'), ServerResponse.description, 'success', 'check'); 
	$('#MessageDialog').find('.modal-body').children().not('.form-message').remove();
	$('#SendMessageButton').remove();
}