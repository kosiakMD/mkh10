function addGroupDialog(){
	$('#ModalGroupDialog').on('show.bs.modal', function(){
		$(this).css('z-index', '2000')
		$('.modal-backdrop.in:visible:last-child').css('z-index', '1999');
	}).on('hidden.bs.modal', function(){
		$('.modal-backdrop.in:visible:last-child').css('z-index', '1040');
		$('#FacultiesList').val('0');
		$('#FacultiesList').change();
	});
	$('#ModalGroupDialog').modal('show');
}
$('input[name="NewPersonBirthday"]').datetimepicker({locale:"uk",viewMode:"years",useCurrent:false,ignoreReadonly: true,showClear:true,format:"YYYY-MM-DD"});
$('#GroupListTags').tagsinput({trimValue:true,maxTags:9,maxChars:3,itemValue:'id',itemText:'group'});
$('select[name="NewPersonPost"]').change(function(){$('.groups')[($(this).val()>1) ? 'removeClass' : 'addClass']('hidden');})
$('#GroupListTags').tagsinput('input').on('focus', addGroupDialog);
$('#GroupListTags').on('beforeItemRemove', function(event){
	$(this).tagsinput('input').off();
	$(this).tagsinput('input').blur(function(){
		$(this).on('focus', addGroupDialog);
	});	
});
$('#AddGroupConfirmButton').click(function(event){ 
	event.preventDefault(); 
	if($('#GroupsList').val().trim() != '0'){
		$('#GroupListTags').tagsinput('add', {"id":$('#GroupsList').val().trim(), "group":$('#GroupsList option:selected').text()});
		$('#ModalGroupDialog').modal('hide');
	}
})
$('#GeneratePasswordButton').tooltip();
$('#GeneratePasswordButton').click(function(){
	$('input[name="NewPersonPassword"]').val(function(){
		var result = '';
		var words = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
		var max_position = words.length - 1;
		for(i = 0; i < 6; i++){
			position = Math.floor ( Math.random() * max_position );
			result = result + words.substring(position, position + 1);
		}
		return result;
	});
});