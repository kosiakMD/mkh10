/*!
 * Debugger
 * kosiakMD@yandex.ua
 * Anton Kosiak <kosiakMD [at] yandex.ua>
 */ 
"use strict"
// 
;(function(){
	var Debugger;
	if (!Debugger) {
		Debugger = {}
	}
	else{
		throw new Error("\"Debugger\" is Ready Used");
	}
	if( !localStorage.Debugger || !JSON.parse( localStorage.Debugger ) ) return;
	var Debugger = { 
		on: true,
		timer : {},
		id: '_Debugger',
		maxHeight: '400px',
		overflow: 'auto',
		padding: '10px',
		background: 'whitesmoke',
		color: 'black',
		timerTextColor: 'darkred' //color of timers' texts
	};
	var div = document.createElement('div');
	div.id = Debugger.id;
	div.style.maxHeight = Debugger.maxHeight;
	div.style.overflow = Debugger.overflow;
	div.style.padding = Debugger.padding;
	div.style.background = Debugger.background;
	div.style.color = Debugger.color;
	// Create Debugger DIV
	document.getElementsByTagName('body')[0].appendChild(div);
	var logger = document.getElementById( Debugger.id );
	// console.log
	Debugger.on && (console.log = function (message){
		if(typeof message == 'object') {
			logger.innerHTML += (JSON && JSON.stringify ? JSON.stringify(message) : message) + '<br>';
		}else{
			logger.innerHTML += message + '<br>';
		}
	});
	// console.time
	Debugger.on && (console.time = function (name){
		Debugger.timer[name] = new Date;
	});
	// console.timeEnd
	Debugger.on && (console.timeEnd = function (name){
		var time = new Date - Debugger.timer[name];
		var text = '<span style="color:'+ Debugger.timerTextColor +' ;">' + name + ': ' + time + ' ms' + '</span>';
		logger.innerHTML += text + '<br>';
		delete Debugger.timer[name];
	});
})();