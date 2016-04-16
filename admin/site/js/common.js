$(window).load(function(){
	$(".se-pre-con").fadeOut('slow');
});
 $(document).ready(function(){
	$('a, [data-toggle="tooltip"]').tooltip();
	$('.main img:not(.no-responsive):not(.carousel > .carousel-inner > .item > img)').addClass('img-thumbnail img-responsive').css('margin', '5px 15px 5px 15px');
	$(window).scroll(function(){
		$('#up-button')['fade'+ ($(this).scrollTop() > 300 ? 'In': 'Out')]('fast');
		$('.speciality').each(function(index){
		  var Object = $(this);
		  setTimeout(function(){
			  var imagePos = Object.offset().top;
			  var topOfWindow = $(window).scrollTop();
			  if (imagePos < topOfWindow + $(window).height()){
				Object.removeClass('hidden').addClass('bounceInLeft animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){$(this).removeClass('animated');}); ;
			  }
		  }, 50 + (50 * index));
		});
	});
	$('#up-button').click(function(){ $('html, body').animate({ scrollTop:0 }, 'fast'); });
	$('#nav-menu-button').click(function(){ $('#nav-menu').slideToggle('fast'); });
	$('#sign-out-button').click(function(){
		$.cookie('u', null, {expires: 1, path: '/'});
		$.cookie('p', null, {expires: 1, path: '/'});
		if(window.location.href.indexOf('site/cabinet') != -1){
			window.location.href = '/';
		} else {
			location.reload();
		}
	});
	$('#sign-in-button').click(function(){ 
		$('.login-box').slideToggle('fast');
		$('input.invalid').removeClass('invalid').val(''); 
		$('#LoginMessages').html('');
	});
	$('#nav-menu a').click(function(){ $('#nav-menu').hide(); });
	$('body').on('click', function (e) {
		if ($(e.target).attr('id') !== 'nav-menu' 
			&& $(e.target).attr('id') !== 'nav-menu-button'
			&& $(e.target).parents('#nav-menu, .nav-button').length === 0){ 
			$('#nav-menu').slideUp('fast');
		}
	});
	var RandomSlide = $('#carousel-logo .item').eq(Math.floor((Math.random() * $('#carousel-logo .item').length)));
	RandomSlide.addClass("active").find('img').attr('src', RandomSlide.find('img').attr('lazy-src'))
	$('#carousel-logo, #carousel-museum-galery').carousel();
	$('input[name="Login"],input[name="Password"]').blur(function(){$(this).removeClass('invalid');});
	$('input[name="Login"],input[name="Password"]').keyup(function(event){
		if($(this).val().trim().length > 0 && $(this).hasClass('invalid')){$(this).removeClass('invalid');}
		if(event.which == 13){ $('#LoginButton').click(); }
	});
	$('#LoginButton').click(function(){
		var Login = $('input[name="Login"]');
		var Password = $('input[name="Password"]');
		$('input[name="Login"], input[name="Password"]').removeClass('invalid');
		if(Login.val().trim().length != 6){Login.addClass('invalid').focus();return;}
		if(Password.val().trim().length != 6){Password.addClass('invalid').focus();return;}
		$.ajax({
			type: 'POST',
			url: 'site/login', 
			cache: false,
			data: {login:Login.val().trim(), password: Password.val().trim()},
			beforeSend : function(xhr, opts){
				$('#LoginMessages').html('');
				$('#LoginLoader').modal('show');
			},
			dataType: 'json'
		}).done(function(ServerResponse){
			if(ServerResponse.status == 'success'){
				$.cookie('u', ServerResponse.id, {expires: 1, path: '/'});
				$.cookie('p', ServerResponse.password, {expires: 1, path: '/'});
				$('.login-box').slideUp('fast');
				$('.login-box, #sign-in-button').remove();
				window.location.href = 'site/cabinet';
			} else if(ServerResponse.status == 'error' && ServerResponse.code == 1){
				$('#LoginMessages').html('<i class="fa fa-exclamation-triangle"></i> Сервер авторизації тимчасово недоступний!');
			} else if(ServerResponse.status == 'error' && ServerResponse.code == 2){
				$('#LoginMessages').html('<i class="fa fa-exclamation-triangle"></i> Неправильний логін чи пароль!');
			} 
		}).fail(function(jqXHR, textStatus, errorThrown){
			$('#LoginMessages').html('<i class="fa fa-exclamation-triangle"></i> Помилка авторизації!');
		}).always(function(){
			Password.val('');
			$('#LoginLoader').modal('hide');
		});
	});
	$('.modal.vertical-centered').on('show.bs.modal', function(){
		var modal = $(this), dialog = modal.find('.modal-dialog');
		modal.css('display', 'block');
		dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
	});
	window.myLatlng=new google.maps.LatLng(49.227836,28.446493);
	window.map=new google.maps.Map(document.getElementById("map_canvas"),{zoom:14,center:window.myLatlng,mapTypeId:google.maps.MapTypeId.ROADMAP});
	var marker=new google.maps.Marker({position:myLatlng,map:map,title:'21018, Україна, м.Вінниця, вул. Пирогова, 56'});
	$('#ContactsWindow').on('shown.bs.modal',function (){google.maps.event.trigger(map,"resize");map.setCenter(window.myLatlng);});
	$('#center-map').tooltip();
	$('#center-map').click(function(){window.map.panTo(myLatlng);});
	$.get('site/staff/birthdays/get/today', function(ServerResponse){
		if(ServerResponse.length > 0){
			$('#BirthdayBanner').append('<div style="margin-bottom:7px;"><i class="fa fa-birthday-cake text-info"></i> <i class="text-info">Сьогодні святкують день народження:</i></div>');
			for(var i = 0; i < ServerResponse.length; i++){
				$('#BirthdayBanner').append('<div style="margin: 3px 0 0 20px"><i class="fa fa-user-md"></i> ' + ServerResponse[i].post.toLowerCase() + ((ServerResponse[i].graduation != '-') ? ', ' + ServerResponse[i].graduation : '') + ' <b>' + ServerResponse[i].name + '</b></div>');
			}
			$('#BirthdayBanner').removeClass('hidden');
		}
	}, 'json');
});
function showMessage(messageBox, text, status, icon){ // Виведення повідомлення про результат надсилання форми
	messageBox.removeClass().addClass('form-message hidden alert alert-' + status); // Стилізуємо повідомлення залежно від результату надсилання
	messageBox.find('i.fa').removeClass().addClass('fa fa-' + icon); // Додаємо відповідну іконку
	messageBox.find('span.text').html(text); // Додаємо текст повідомлення
	messageBox.removeClass('hidden'); // Відображуєм повідомлення
	$('html, body').animate({ scrollTop:0 }, 'fast');
}