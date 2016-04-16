$('select[name="NavType"]').change(function(){
	if($(this).val() == '2'){
		$('#NavCategoryList').removeClass('hidden');
		$('.NavLinkInput').addClass('hidden');
	} else if($(this).val() == '1'){
		$('.NavLinkInput').removeClass('hidden');
		$('#NavCategoryList').addClass('hidden');
	}
});