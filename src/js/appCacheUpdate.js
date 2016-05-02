/*!
* App Cache Update
 * Application Cache Update with Boostrap Modal integration
 * or Confirm if absents
 * kosiakMD@yandex.ua
 * Anton Kosiak <kosiakMD [at] yandex.ua>
 */ 
"use strict"
// 
window.applicationCache.addEventListener('updateready', function(e) {
	if (window.applicationCache.status == window.applicationCache.UPDATEREADY) {
		window.applicationCache.swapCache();
		if( $("#modalTemplate").length ){
			var $modal = $("#modalTemplate");
			$modal.modal();
			$modal.find(".modal-body").text('Доступна нова версія Веб-додатку. Завантажити?');
			$modal.find(".btn-confrim").click(function(){
				window.location.reload();
			});
		}
		else{
			if (confirm('Доступна нова версія Веб-додатку. Завантажити?')) {
				window.location.reload();
			}
		}
	}
}, false);