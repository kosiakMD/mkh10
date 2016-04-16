function updateMenuStatus(){	
	var Blocks = {};
	$('[id^=collapse]').each(function(index){
		Blocks[$(this).attr('id')] = {};
		Blocks[$(this).attr('id')].status = (($(this).hasClass('in')) ? ' in' : '');
		Blocks[$(this).attr('id')].icon = (($(this).hasClass('in')) ? 'up' : 'down');
	});
	$.cookie('menuStatus', JSON.stringify(Blocks), {expires: 365, path: '/'});
}
function setupMenu(){
	if($.cookie('menuType') == '0'){
		$('#SimpleMenu').animate({width:'hide'}, 1);
	}
}
$(window).load(function(){setTimeout(function(){$(".se-pre-con").fadeOut('slow');},500);});
$(document).ready(function(){	
	$('[id^=collapse]').on('show.bs.collapse',function(){$(this).parent().find('li a[data-toggle="collapse"] i.fa').attr('class','fa fa-chevron-up');});
	$('[id^=collapse]').on('hide.bs.collapse', function(){$(this).parent().find('li a[data-toggle="collapse"] i.fa').attr('class', 'fa fa-chevron-down');});
	$('[id^=collapse]').on('shown.bs.collapse hidden.bs.collapse', updateMenuStatus);
	$('button, a, img, span[data-toggle="tooltip"]'	).bind('mouseover', function(){ $(this).tooltip('show'); });
	$('.confirmation').popover({html: true, content: function(){ return $(this).attr('data-popover-content') + '<br><div style="text-align: right; margin: 5px 0 5px 0;"><button type="button" data-href="' + $(this).attr('data-popover-href') + '" class="btn btn-danger" onclick="coniformationSend($(this));"><i class="fa fa-check"></i> Так</button> <button class="btn btn-default" onClick="$(\'.confirmation\').popover(\'hide\');"><i class="fa fa-remove"></i> Ні</button></div>'; }});
	$('[data-toggle="popover"]').popover();
	$('.confirmation').on('click', function(e){ $('.confirmation').not(this).popover('hide'); });
	$('body').on('click', function (e) {
		if ($(e.target).data('toggle') !== 'popover'
			&& $(e.target).parents('[data-toggle="popover"]').length === 0
			&& $(e.target).parents('.popover.in').length === 0) { 
			$('[data-toggle="popover"]').popover('hide');
		}
	});
	$('.modal').on('show.bs.modal', function(){var $bodyWidth = $('body').width();$('body').css({'overflow-y': 'hidden'}).css({'padding-right': ($('body').width()-$bodyWidth)});});
	$('.modal.vertical-centered').on('show.bs.modal', function(){var modal = $(this),dialog = modal.find('.modal-dialog');modal.css('display', 'block');dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));});
	$('.modal').on('hidden.bs.modal', function(){$('body').css({'padding-right': '0', 'overflow-y': 'auto'});});
	$('body').on('hidden.bs.modal', '.modal', function(){$(this).removeData('bs.modal');});
	$('#SelectAll').click(function(){$('.table input[type="checkbox"]').prop('checked', $(this).is(':checked'));});
	$(window).on('resize', function(){$('.modal:visible').each(reposition);});
	$('#up_scroller').click(function(){ $('html, body').animate({ scrollTop:0 }, 'fast'); });
	
	$('#DeleteAll').click(function(event){
		event.preventDefault();
		var FilesList = '';
		$('.table tbody').find('input[type="checkbox"]:checked').each(function(i){
			if($(this).val().trim()){ FilesList += $(this).val().trim().substring(0, $(this).val().trim().length-1) + '|'; }
		});
		/* доробити */
		alert(FilesList.substring(0, FilesList.length-1));
	});
	
	$('button#CreateBackup').click(function(){
		$('#ModalLoading').modal('show');
		$.get('manager/backup/files/create', function(){ window.location.reload(); });
	});
	
	$('span.page-status').click(function(){
		var page = $(this);
		$('#ModalLoading').modal('show');
		$.get(page.attr('data-href') + '/' + ((page.attr('data-status') == '1') ? 'off' : 'on') + '/' + page.attr('data-id'), function(ServerResponse){
			$('#ModalLoading').modal('hide');
			page.removeClass().addClass('page-status label label-' + ((ServerResponse.status == '0') ? 'danger' : 'success')).html((ServerResponse.status == '0') ? 'Пас.' : 'Акт.');
			page.attr('data-status', ServerResponse.status);
		}, 'json');
	});
	
	if(!$.cookie('menuType')){ $.cookie('menuType', '1', {expires: 1, path: '/'}); }
	if($.cookie('menuStatus') != 'undefined'){ updateMenuStatus(); }
	if($.cookie('justLogged') == '1'){
		$('#nav-login').popover({html: true, container: '#nav-login', content: '<div class="alert alert-info"><i class="fa fa-info-circle"></i> Ви знаходитесь в режимі редагування.</div>', placement: 'bottom'});
		$('#nav-login').on('hidden.bs.popover', function(){ 
			$(this).popover('destroy'); 
			$.cookie('justLogged', null, {expires: -1, path: '/'});
		});
		$('#nav-login').popover('show');
		setTimeout(function(){ $('#nav-login').popover('hide'); }, 4000);
	}
	
	$('#CompactMenuToggle').click(function(){
		$('#SimpleMenu').animate({width:'toggle'}, 100, function(){
			if($('#SimpleMenu').is(':visible')){
				$('.main').removeClass('col-md-11').addClass('col-md-10 col-md-offset-2');
				$.cookie('menuType', '1', {expires: 1, path: '/'});
			} else {
				$('.main').removeClass('col-md-10 col-md-offset-2').addClass('col-md-11');
				$.cookie('menuType', '0', {expires: 1, path: '/'});
			}
			$('#CompactMenuToggle > i').removeClass().addClass('fa fa-' + (($('#SimpleMenu').is(':visible')) ? 'out' : 'in') + 'dent')
		});
	});
	
	$('.to-labelauty').labelauty();
	$('.to-labelauty-icon').labelauty({label: false});
});

function showMessage(messageBox, text, status, icon){ // Виведення повідомлення про результат надсилання форми
	messageBox.removeClass().addClass('form-message hidden alert alert-' + status); // Стилізуємо повідомлення залежно від результату надсилання
	messageBox.find('i.fa').removeClass().addClass('fa fa-' + icon); // Додаємо відповідну іконку
	messageBox.find('span.text').html(text); // Додаємо текст повідомлення
	messageBox.removeClass('hidden'); // Відображуєм повідомлення
	$('html, body').animate({ scrollTop:0 }, 'fast');
}

function showPopover(input, text){
	input.popover({placement: 'top', container: 'body', trigger: 'manual', html: true, content: text});
	input.on('shown.bs.popover', function (){ setTimeout(function(){ input.popover('hide'); }, 2000); });
	input.popover('show');
}

function reloadPage(ServerResponse){
	$('.modal').modal('hide');
	setTimeout(function(){
		$('#ModalLoading').modal('show');
		setTimeout(function(){
			if(ServerResponse.hasOwnProperty('hash')){ $.cookie('hash', ServerResponse.hash, {expires: 1, path: window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/')+1) + 'manager'}); }
			window.location.reload();
		}, 2000);
	}, 400);
}

function coniformationSend(object){	
	$.ajax({ // Надсилаємо дані через ajax
		type: 'GET', // Метод надсилання
		url: object.attr('data-href'), // Посилання для прийому
		async: true, // Асинхронно
		cache: false, // Не кешувати
		dataType: 'json', // Тип зворотніх даних
		beforeSend : function(xhr, opts){
			$('#PageMessage').addClass('hidden'); // Перед відправкою приховуєм повідомлення про результати
			$('.confirmation').popover('hide');
			$('#ModalLoading').modal('show');
		}
	}).done(function(ServerResponse){
		if(ServerResponse.status === 'success'){ // Якщо надсидання прошло успішно
			showMessage($('div#PageMessage'), ServerResponse.description, 'success', 'check'); // Виводимо повідомлення про успіх
			reloadPage(ServerResponse);
		}else if(ServerResponse.status === 'error'){ // Помилка при обробці даних
			showMessage($('div#PageMessage'), ServerResponse.description, 'danger', 'exclamation-triangle'); // Виводим повідомлення про помилку
		}
	}).fail(function(jqXHR, textStatus, errorThrown){
		showMessage($('div#PageMessage'), textStatus + ': ' + jqXHR.responseText, 'danger', 'exclamation-triangle'); // При надсиланні данх на сервер щось пішло не так :(
	}).always(function(){
		$('#ModalLoading').modal('hide');
	});
}