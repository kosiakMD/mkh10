/*!
 * $http Promise Defer
 * kosiakMD@yandex.ua
 * Anton Kosiak <kosiakMD [at] yandex.ua>
 * https://github.com/kosiakMD/-http.defered
 */ 
"use strict"
//
// Dependency
if(!jQuery) throw new Error("jQuery library is Required");
// Self AJAX XHR with Promise Defer - faster then jQuery Ajax in 1.9-1.5
function $http(url){
 
	// A small example of object
	var core = {

		// Method that performs the ajax request
		ajax : function (method, url, args) {

			// Creating a promise
			var deferred = new $.Deferred()// function() {//original^: = new Promise( function (resolve, reject) {

				// Instantiates the XMLHttpRequest
				var client = new XMLHttpRequest();
				var uri = url;

				if (args && (method === 'POST' || method === 'PUT')) {
					uri += '?';
					var argcount = 0;
					for (var key in args) {
						if (args.hasOwnProperty(key)) {
							if (argcount++) {
								uri += '&';
							}
							uri += encodeURIComponent(key) + '=' + encodeURIComponent(args[key]);
						}
					}
				}

				client.open(method, uri, true);
				client.send();
				var _timer = "XHR \""+method+"\" url: "+url /*+" "+(new Date())*/;
				console.time(_timer);

				client.onload = function () {
					if (this.status == 200) {
						// Performs the function "resolve" when this.status is equal to 200
						console.timeEnd(_timer)
						deferred.resolve(this.response);//original^: resolve(this.response);
					} else {
						// Performs the function "reject" when this.status is different than 200
						log("ERROR^: ");
						console.timeEnd(_timer);
						// client.open(method, uri, true);
						// client.send();
						deferred.reject(this.statusText);//original^: reject(this.statusText);
					}
				};
				client.onerror = function () {
					deferred.reject(this.statusText);//original^: reject(this.statusText);
				};

			// });

			// Return the promise
			return deferred.promise();//original^: return promise();
		}
	};

	// Adapter pattern
	return {
		'get' : function(args) {
			return core.ajax('GET', url, args);
		},
		'post' : function(args) {
			return core.ajax('POST', url, args);
		},
		'put' : function(args) {
			return core.ajax('PUT', url, args);
		},
		'delete' : function(args) {
			return core.ajax('DELETE', url, args);
		}
	};
};