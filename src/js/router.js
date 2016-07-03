/*!
 * Router
 * kosiakMD@yandex.ua
 * Anton Kosiak <kosiakMD [at] yandex.ua>
 */
"use strict"
// Dependency
if(!$http) throw new Error("$http Module is Required");
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
			if(jQuery.isEmptyObject(core.roads)) throw new Error("Router is Empty")
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
			if(jQuery.isEmptyObject(core.roads)) return
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
				core.roads[path].controller && Array.isArray(this.roads[path].controller) && core.roads[path].controller.forEach(function(func){
					func();
				})
				return true;
			}
			return false;
		},
		url2obj: function(hash){ // hash handler
			var action
			if( hash.substr(0,2) == '#/' ) action = hash.substr(2); else action = hash;
			var properties = action.split( /&/ );
			var obj = {};
			$.each(properties,function(){
				var p = this.split( /=/ );
				obj[ p[0] ] = p[1];
			});
			return obj; // request preferences object
		},
		loadPage: function(page, path){ // content loading
			console.log("loadPage " + page );
			var obj = this.url2obj(page);
			var $content = $("#view_content");
			$http( page ).get( obj )
				.then(
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

		'reset' : function () {
			core.roads = {};
			return this;
		},

		'get' : function() {
			return core.roads;
		},

		'path' : function(args) {
			var selfi = this;
			return {
				'add' : function(args){
					core.add(args, core);
					return selfi;
				},
				'delete' : function(args){
					core.delete(args);
					return selfi;
				},
				'gate' : function(args){
					core.gate(args);
					return selfi;
				}
			}
		},

		'controller' : function(path, callback) {
			var selfi = this;
			if(typeof path === "string" && callback && typeof callback === "function"){
				core.controller(path, callback);
				return selfi;
			}else{
				return {
					'add' : function (path) {

					},
					'delete' : function (arg) {
						if(!arg) throw new Error("No Path for Deleting");
						delete core.roads[arg].controller;
						return selfi;
					}
				}
			}
		}

	}
};
