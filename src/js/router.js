/*!
 * Router
 * kosiakMD@yandex.ua
 * Anton Kosiak <kosiakMD [at] yandex.ua>
 */ 
"use strict"
//
function __simpleRouter(){
	var self = this;
	var core = {
		// path: function(method){
		roads: {},
		delete: function(path){
			delete this.roads[path];
			return true;
		},
		add: function(obj, self){
			for( var path in obj ){
				core.roads[path] = { gate : obj[path] };
			}
			// console.log(core.roads)
			return true;
			// }
		},
		gate: function(path){
			return core.roads[path].gate;
		},
		init: function(obj){
			if(obj && typeof obj === "object"){
				this.add(obj);
			}
			// document.onreadystatechange = function () {
			// $(document).ready(function () {
			var path = location.pathname.slice();
			!core.roads[path] && ( window.location.href = '/' );
			var page = core.gate(path);
			core.loadPage(page, path);
			// });
			// }
		},
		controller: function(path, callback){
			if(typeof path === "string" && callback){
				if(typeof callback === "function"){
					if(path === ""){
						for(var path in core.roads){
							!(typeof core.roads[path].controller !== 'undefined') && (core.roads[path].controller = [])
							core.roads[path].controller.push(callback)
						}
						return true;
					}else{
						!(typeof core.roads[path].controller !== 'undefined') && (core.roads[path].controller = [])
						core.roads[path].controller.push(callback)
						return true;
					}
				}
				return false;
			}else{
				// if(typeof core.roads[path].controller === "function"){
				// 	core.roads[path].controller();
				// }
				Array.isArray(this.roads[path].controller) && core.roads[path].controller.forEach(function(func){
					func();
				})
				return true;
			}
			return false;
		},
		url2obj: function(hash){ // обработка хеша
			var action
			if( hash.substr(0,2) == '#/' ) action = hash.substr(2); else action = hash;
			var properties = action.split( /&/ );
			var obj = {};
			$.each(properties,function(){
				var p = this.split( /=/ );
				obj[ p[0] ] = p[1];
			});
			return obj; // объект параметров запроса
		},
		loadPage: function(page, path){ // подгрузка контента
			console.log("loadPage " + page );
			var obj = this.url2obj(page);
			var $content = $("#view_content");
			$http( page ).get( obj ).then(
				function(data){
					console.log( "Router Success");
					$content.html(data);
					core.controller(path);
				},
				function(data){
					console.log( "ERROR: " + data );
					$content.text( "ERROR: " + data);
				}
			).then( function(path){
				console.log( "Router Done");
			});
		}
	};

	return {
		'init' : function(args) {
			return core.init(args);
		},
		'path' : function(args) {
			return {
				'add' : function(args){
					return core.add(args, core);
				},
				'delete' : function(args){
					return core.delete(args);
				},
				'gate' : function(args){
					return core.gate(args);
				}
			}
		},
		'controller' : function(path, callback) {
			return core.controller(path, callback);
		}
	}
};
