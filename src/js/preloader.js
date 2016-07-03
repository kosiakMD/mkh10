/*!
 * preloader XHR
 * kosiakMD@yandex.ua
 * Anton Kosiak <kosiakMD [at] yandex.ua>
 */ 
"use strict"
// 
var preloaderXHR;
if (!preloaderXHR) {
	preloaderXHR = {}
}else{
	throw new Error("\"preloaderXHR\" is Ready Used");
}
preloaderXHR = {
	div : "loadingList",
	counter : false,
	count : 0,
	allow : false,
	add : function(file, name, text){
		file += ".json";
		console.log("#____add file: "+file);
		preloaderXHR.count++;
		preloaderXHR.allow = false;
		preloaderXHR.loadingFile(file, name, text);
		/*console.log(req.readyState);
		req.onreadystatechange = function(){
			console.log(this);
			if (this.readyState == 4 && this.status == 200){
				console.log("1 done");
				preloaderXHR.count--;
				if (preloaderXHR.count == 0)
					preloaderXHR.allow = true;
			}
			console.log(preloaderXHR.count, preloaderXHR.allow);
		}*/
	},
	change : function(xhr, callback){
		if(xhr.readyState === 3){
			//console.log(xhr.responseURL, 'loading')
			preloaderXHR.loadingFile(xhr.responseURL);
		}
		if(xhr.readyState === 4){
			if(xhr.status === 200){
				preloaderXHR.count--;
				if (preloaderXHR.count == 0)
					preloaderXHR.allow = true;
			}
		}
		if (callback)
			callback.apply();
	},
	check : function(callback, checkAllow){
		//console.log(preloaderXHR.allow);
		/*if (callback)
			if(checkAllow && checkAllow === true)
				if(preloaderXHR.allow == true)
					callback.apply();
			else
				callback.apply();
		else
			return preloaderXHR.allow;*/
		if (preloaderXHR.count == 0)
			preloaderXHR.allow = true;
		return preloaderXHR.allow;
	},
	loadingFile : function(file, name, text){
		// console.log("loading: " + file, name, text);
		//element^ progressBar with file name
		var $li = '<li data-file="' + name + '" >"' + file + '" завантажується...<div class="progress"><div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">	<span class="sr-only">Loading</span>	</div></div></li>';
		$("#loadingList").append($li);
		return this;
	},
	readyFile : function(file, name){
		$("#loadingList").find("li[data-file='" + name + "']").remove();
		preloaderXHR.count--;
		if (preloaderXHR.counter && preloaderXHR.count == 0)
			preloaderXHR.end();
		/*	preloaderXHR.allow = true;
		$(window).load(function (){
			console.log("loaded and loaded");
			preloaderXHR.end()
		})*/
		// preloaderXHR.counter && preloaderXHR.end()
	},
	start : function(){
		$("#preloader").fadeIn();
		$("body").css("overglow","hidden");
	},
	off : function(){
		$("body").css("overglow","hidden");
		setTimeout(function(){$("#preloader").fadeOut()}, 100);
	},
	end : function(){
		!window.loaded
			? $(window).load(function(){
				preloaderXHR.off();
			})
			: preloaderXHR.off();
		/*if(window.loaded){
			preloaderXHR.off();
		}
		else{
			$(window).load(function(){
				preloaderXHR.off();
			})
		}*/
	}
};