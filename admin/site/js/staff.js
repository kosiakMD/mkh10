$(document).ready(function(){
	$.ajax({
		type: 'GET',
		url: 'site/staff/get',
		cache: false,
		dataType: 'json'
	}).done(function(ServerResponse){
		if(ServerResponse.status == 'success'){
			if(ServerResponse.data.length > 0){
				$('.data-wrapper').html(ServerResponse.data);
				$('.data-wrapper img').addClass('img-thumbnail img-responsive').error(function(){ $(this).attr('src', 'site/img/no-photo.jpg'); });
				$('.data-wrapper img').css('margin', '5px 15px 5px 15px');
				$('.staff-person').each(function(index){
					var Object = $(this);
					setTimeout(function(){ 
						Object.removeClass('hidden').addClass('bounceInUp animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){$(this).removeClass('animated');}); 
					}, 50 + (50 * index));
				});
			} else {
				$('.error-wrapper').fadeIn();
			}
		}
	}).always(function(){
		$('#PagePreloader').remove();
	}).fail(function(){
		$('.error-wrapper').fadeIn();
	});
});