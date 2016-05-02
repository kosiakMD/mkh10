/*!
 * Commons
 * kosiakMD@yandex.ua
 * Anton Kosiak <kosiakMD [at] yandex.ua>
 */ 
"use strict"
// 
;var console_info = [ "%c МКХ-10 mkh10.com.ua %c Developed by KEL %c https://fb.com/kosiakMD %c"+
	'\nhttp://vk.com/kosiakMD',
	"background: #000000; color: #7EBE45",
	"background: #000000; color: #ffffff",
	"color: blue", ""];
console.log.apply(console, console_info);

//-------------- PROTOTYPES and Classes
Function.prototype.method = function(methodName, f) {
	return this.prototype[methodName] = f;
};
var bind = Function.prototype.call.bind(Function.prototype.bind);
Function.method("after", function () {
	/**
	 * @var onReady - это наша ф-ция, которая будет выпонлятся по завершению всех вызовов
	 * @var after	 - это хэш функций, которые должны быть выполнены.
	 *	 именно его свойства мы передаём как колбеки (process.fs и process.db)
	 * @var ready - здесь мы будем хранить ответы каждой функции и когда все ключи,
	 *	 которые есть в after будут и тут - значит, пора вызывать onReady
	 */
	// function asyncFsAccess(a)
	// function asyncDbAccess(b)
	// var process = processFsAndDb.after('fs', 'db');
	log("^ use: AFTER with NEEDS: ", arguments)
	var onReady = this, after = {}, ready = {};
	var checkReady = function () {
		for (var i in after) if (!(i in ready)) return;
		console.log(typeof onReady)
		onReady(ready);
	};
	for (var i = 0, l = arguments.length; i < l; i++) {
		(function (key) {
			after[key] = function () {
				ready[key] = arguments;
				checkReady();
			};
		})(arguments[i]);
	}
	ready = {};
	return after;
});
// 
//-------------- Var Easy Functions
var callback = {
		success : function(data){
			// console.log(data);
			console.log(1, 'success'/*, JSON.parse(data)*/);
			//if (name) { window[name] = JSON.parse(data) }
		},
		error : function(data){
			console.log(2, 'error', data);
		}
	},
	G = Global = function(){
		return console.log(this);
	}
	/*setGlobal = (function(global) {
		return function(value) {
			global.someVarName = value;
		}
	}(this)),
	readGlobal = (function(global) {
		return function() {
			return global.someVarName;
		}
	}(this)),*/;

// 
//-------------- Commons
function byID(id){return document.getElementById(id)};
function parse(json){return !!arguments[0] ? JSON.parse(json) : ""};
function encode(json){return JSON.stringify(json)};
// function log(arg){return console.log(arguments)};
function log(){try {return console.log.apply(console, arguments);} catch (_error) {} };
function timer (callback, time){setTimeout(callback, time);};
function online(){return navigator.onLine;};
function counter(){//main count function
	var n = 0;
	return {
		count : function(){ return n++; },
		reset : function(){ n = 0 }
	};
};
function memorySizeOf(obj) {
	var bytes = 0;

	function sizeOf(obj) {
		if(obj !== null && obj !== undefined) {
			switch(typeof obj) {
			case 'number':
				bytes += 8;
				break;
			case 'string':
				bytes += obj.length * 2;
				break;
			case 'boolean':
				bytes += 4;
				break;
			case 'object':
				var objClass = Object.prototype.toString.call(obj).slice(8, -1);
				if(objClass === 'Object' || objClass === 'Array') {
					for(var key in obj) {
						if(!obj.hasOwnProperty(key)) continue;
						sizeOf(obj[key]);
					}
				} else bytes += obj.toString().length * 2;
				break;
			}
		}
		return bytes;
	};

	function formatByteSize(bytes) {
		if(bytes < 1024) return bytes + " bytes";
		else if(bytes < 1048576) return(bytes / 1024).toFixed(3) + " KiB";
		else if(bytes < 1073741824) return(bytes / 1048576).toFixed(3) + " MiB";
		else return(bytes / 1073741824).toFixed(3) + " GiB";
	};

	return formatByteSize(sizeOf(obj));
};

//-------------- jQuery method extends
jQuery.fn.extend({
	manipulate: function( func ) {
		return this.each(function() {
			func.apply(this);
		});
	}
})
// 