$(document).ready(function(){
	function validForm(form){ //Валідація форми
		var input = form.find('input.required, textarea.required'); // Отримуємо список всіх полів форми
		var valid = true; // За замовчуванням форма проходить валідацію
		input.each(function(i){ //Проходимо по всіх елементах форми
			var text = $(this).val().trim(); // Текст поточного елементу
			if(text.length < $(this).attr('data-minlength') || ($(this).hasClass('special') && text.match(/[\/\*\?\:\"\<\>\|\\]+/))){
				$(this).popover('show'); // Видаємо повідомлення про помилку
				valid = false; // Форма не пройшла валідацію :(
				return false; // Виходимо з циклу перевірки
			}
		});
		return valid; // Повертаємо результат перевірки
	}
	
	$('form').on('submit', function(event){ // Перехоплення надсилання форми
		event.preventDefault();
		
		var form = $(this); // Отримуємо об'єкт форми
		
		form.find('.required').popover({ // Ініціалізація підказок
			placement: 'right', 
			container: 'body', 
			trigger: 'manual', 
			html: true, 
			content: '<i class="fa fa-exclamation-triangle"></i> Невірно заповнено поле!'
		});
		
		form.find('.required').on('shown.bs.popover', function (){
			setTimeout(function(){ form.find('.required').popover('hide') }, 2000);  // Автозакриття підказок
		});
		
		if(!validForm(form)) return false; // Перевіряємо форму
		
		$.ajax({ // Надсилаємо дані через ajax
			type: form.attr('method'), // Метод надсилання
			url: form.attr('action'), // Посилання для прийому
			async: true,
			cache: false, // не кешувати
			dataType: 'json', // Тип зворотніх даних
			data: form.serialize(), // Отримуємо дані з форми
			beforeSend : function(xhr, opts){
				form.find('button').addClass('disabled');
				form.find('button.close').addClass('hidden');
				form.find('div.form-message').addClass('hidden'); // Перед відправкою приховуєм повідомлення про результати
				$('span.send-loader').removeClass('hidden');
			}
		}).done(function(ServerResponse){
			if(ServerResponse.status === 'success'){ // Якщо надсилання прошло успішно
				reloadPage(ServerResponse); // Перезавантажуємо сторінку
			}else if(ServerResponse.status === 'error'){ // Помилка при обробці даних
				showMessage(form.find('div.form-message'), ServerResponse.description, 'danger', 'exclamation-triangle'); // Виводим повідомлення про помилку
			}
		}).fail(function(jqXHR, textStatus, errorThrown){
			showMessage(form.find('div.form-message'), textStatus + ': ' + jqXHR.responseText, 'danger', 'exclamation-triangle'); // При надсиланні даних на сервер щось пішло не так :(
		}).always(function(){
			form.find('input[type="password"], input.cleared').val('');
			form.find('button.close').removeClass('hidden');
			form.find('button').removeClass('disabled');
			$('span.send-loader').addClass('hidden');
			if($('.captcha').length > 0){ $('#CaptchaImage').attr('src','captcha?'+Math.random()); }
		});
	});
});