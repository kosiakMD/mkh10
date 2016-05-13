/*!
 * keleborn.mail@gmail.com
 * (c) 2015 МКХ 10 - http://mkh10.com.ua
 * Anton Kosiak <keleborn.mail [at] gmail.com>
 * The library ICD of World Health Organization not under the MIT license :
 * https://who.com 
 */
"use strict"
// 

//-------------- VARS
;var APP = {
		width1 : 0,
		width2 : 0,
		stepCatalog : 0
	},
	storage = localStorage,
	version = {},
	//ml Lang = {},
	ICD = {},
	classes = [], blocks = [], diagnoses = [], nosologies = [];//for Counter of BD
// 
//-------------- HANDLER
function APP_INIT(){
	console.log("\n| APP_INIT");
	initRouter();
	console.log("online^: ", online())
	online() 
		? ONLINE_MODE() 
		: OFFLINE_MODE()
	/*online 
		? ONLINE_MODE(
			checkStorage 
				? STORAGE_MODE(
					!storage.ICD
						? SECOND_BOOT_MODE() 
						: FIRST_BOOT_MODE()
				) 
				: NO_STORAGE_MODE()
		) 
		: OFFLINE_MODE()*/
};
//-------------- MODES
function FIRST_BOOT_MODE(update){
	console.log("\n|---> ----> FIRST_BOOT_MODE\n");
	loadAll();
};
/* //ml function SECOND_BOOT_MODE(){
	console.log("\n|---> ----> SECOND_BOOT_MODE\n");
	BD_init();
	//paint();
	$.when(
		load("public/version", "version")
	).then(function(){
		//translate();
		//paint();
		var newDB = false,
				newLang = false,
				$modal = $('#myModal'),
		//get current Lang data
			myLang = Lang.code,
			myVersion = Lang.version,
			myName = Lang.name;
			// log(version.Lang[myLang].version, myVersion)
		//check current Lang data
		if(version.Lang[myLang].version != myVersion){//if Lang DB available
			console.log("#_____ available other Lang version: "+version.Lang[myLang].version);
			$modal.find("#update_lang").removeClass("hidden");
			newLang = true;
		};
		//get current ICD data
			myLang = ICD.code;
			myVersion = ICD.version;
			myName = Lang.name;
		// log(version.ICD[myLang].version, myVersion)
		//check current ICD data
		if(version.ICD["uk"].version != myVersion){//if new DB available
			console.log("#_____ available other ICD version: "+version.ICD["uk"].version);
			$modal.find("#update_db").removeClass("hidden");
			newDB = true;
		};
		(newDB || newLang) && function(){//if any update is available SHOW MODAL
			$modal.modal("show");
			// $modal.find("#loadDismiss").click(function(){
			// 	paint();
			// });
			$modal.find("#loadButton").click(function(){//if "OK" (Download) button clicked 
				console.log(newLang, newDB);
				preloaderXHR.start();
				if(newLang && !newDB){//if update only Lang available MODAL
					loadLang()
					.then(function(){
						translate();
						preloaderXHR.end();
					});
				}
				else if(newDB && !newLang){//if update only DB available MODAL
					loadDB()
					.then(function(){
						paint();
						preloaderXHR.end();
					});
				}
				else{//if update both Lang and DB available MODAL
					$.when(
						loadLang(),
						loadDB()
					)
					.then(function(){
						paint();
						translate();
						preloaderXHR.end();//OFF Preloader
					});
				};
				$modal.modal("hide")
					.find("#update_lang").addClass("hidden")
					.end().find("#update_db").addClass("hidden");
			});
		}()
		preloaderXHR.end();
		//for(a in ICD.version){if(ICD.version.hasOwnProperty(a))log(a)}
	}, function(){
		OFFLINE_MODE();
	});
};*/
function SECOND_BOOT_MODE(){
	console.log("\n|---> ----> SECOND_BOOT_MODE\n");
	BD_init();
	//paint();
	$.when(
		load("public/version", "version")
	).then(function(){
		//translate();
		//paint();
		var newDB = false,
				$modal = $('#myModal'),
		//get current ICD data
			myVersion = ICD.version;
		// log(version.ICD[myLang].version, myVersion)
		//check current ICD data
		if(version.ICD["uk"].version != myVersion){//if new DB available
			console.log("#_____ available other ICD version: "+version.ICD["uk"].version);
			$modal.find("#update_db").removeClass("hidden");
			newDB = true;
		};
		newDB && function(){//if DB update is available SHOW MODAL
			$modal.modal("show");
			$modal.find("#loadButton").click(function(){//if "OK" (Download) button clicked 
				console.log(newDB);
				preloaderXHR.start();
				loadDB()
					.then(function(){
						paint();
						preloaderXHR.end();
					});
				$modal.modal("hide")
					.find("#update_lang").addClass("hidden")
					.end().find("#update_db").addClass("hidden");
			});
		}()
		preloaderXHR.end();
		//for(a in ICD.version){if(ICD.version.hasOwnProperty(a))log(a)}
	}, function(){
		OFFLINE_MODE();
	});
};
function STORAGE_MODE(){
	console.log("\n|---> STORAGE_MODE\n");
	storage.version
		? SECOND_BOOT_MODE() 
		: FIRST_BOOT_MODE();
};
function NO_STORAGE_MODE(){
	console.log("\n|---> NO_STORAGE_MODE\n");
	$("li.settings").hide();
	loadAll();
};
function ONLINE_MODE(){
	console.log("\n| ONLINE_MODE\n")
	checkStorage 
		? STORAGE_MODE() 
		: NO_STORAGE_MODE()
	/*if (checkStorage){
		STORAGE_MODE();
	}
	else{
		NO_STORAGE_MODE();
	}*/
};
function OFFLINE_MODE(){
	console.log("\n| OFFLINE_MODE\n");
	BD_init();
	$(document).ready(function (){
		//routerEnd().then(paint);
		//ml translate();
		adaptation();
		preloaderXHR.end();
	});
}; 
//-------------- Functions
function menu_href(){
	// var href = location.href.split("#");
	// href = href[1];
	// $("a[href$='"+href+"']").parents("li").last().addClass('active');
	var href = location.pathname;
	// console.log(href, $("ul.nav a[href$='" + href + "']"));
	$("ul.nav a[href]").each(function(){
		$(this).parents("li").last().removeClass('active');
	});
	$("ul.nav a[href$='" + href + "']").each(function(){
		$(this).parents("li").last().addClass('active');
	});
};
function alphabet(){
	var el = this;//console.log(el);
	for(var i=65; i<91; i++){
		var letter = String.fromCharCode(i),
				op = document.createElement('option');
		op.setAttribute('value', letter);
		op.innerHTML = letter;
		el.append(op);
	}
	return true;
};
function numbers(){
	$('select.numbers').each(function(){
		var op;
	/*if IE !!! faster !!!
			console.time("1");
			for(var i=0; i<10; i++){
				op += "<option value='" + i + "'>" + i + "</option>";
			}
				this.innerHTML = op;
			console.timeEnd("1");
	*/
		// console.time("2");
		for(var i=0; i<10; i++){
			var op = document.createElement('option');
			op.setAttribute('value', i) ;
			op.innerHTML = i;
			this.appendChild(op)
		}
		// console.timeEnd("2");
	});
	return true;
};
function paint(){
	console.log("paint START ----")
	//getStorage();
	// translate();
	$('body').removeAttr("style");
	alphabet.call( $('#letter') );
	numbers();
	formCatalog.call( $('#catalog1'), ICD.classes, 'class', 0 );
	// adaptation();
	Width2();
	liveSearch();
	console.log("paint END ----")
};
// - Width & Hieght Adaptations
function Width1(){
	APP.width1 = $("#catalog-wrapper").width();
	$(".list").width(APP.width1-2);
	//console.log('w1',APP.width1);
	return true;
};
function Width2(){
	APP.width2 = $('#autocomplete').outerWidth();
	//console.log('w2',APP.width2);
	return true;
};
function Width3(){
	$('.ui-autocomplete').outerWidth(APP.width2 - 2);
	//console.log('w2',APP.width2);
	return true;
};
function adaptation(slide, width) {
	console.log("adaptation", slide);
	var h = $("#top_menu").height();
	$("#view_content").css({
		"margin-top" : h + 10,
		'min-height' : $(window).height() - $("footer").outerHeight() - h - 10 
	});
	slide && slideCatalog();
	width && Width2() && Width3();
	Width1();
	return true;
};
// - Catalog
function catalogHandler(){
	console.log("catalogHandler");
	var element = $(this).attr('element'),
			ind = $(this).attr('number'),
			newElements = [];
	activeElement( $(this), element );
	var start = 0, finish = 0;
	// - Class || Block click
	if( element == 'class' || element == 'block' ){
		var l1 = $(this).attr('l1'),
				n1 = $(this).attr('n1'),
				l2 = $(this).attr('l2'),
				n2 = $(this).attr('n2');
				// code1 = l1.charCodeAt(0),
				// code2 = l2.charCodeAt(0);
		// - Class click - get Blocks
		if( element == 'class' ){
			// new loop
			for(var prop in ICD.count.class){
				if(prop == l1 + n1 + l2 + n2){
					finish = start + ICD.count.class[prop]
					break;
				}
				start += ICD.count.class[prop];
			}
			newElements = ICD.blocks.slice(start, finish);
			// old loop
			/*for(var n in ICD.blocks){
				var char1 = ICD.blocks[n].l1.charCodeAt(0);//console.log('ch1',n,ICD.blocks[n].l1,char1);
				var char2 = ICD.blocks[n].l2.charCodeAt(0);//console.log('ch2',n,ICD.blocks[n].l2,char2);
				if( char1 >= code1 && char2 < code2 || char1 >= code1 && char2 <= code2 && ICD.blocks[n].n1 >= n1 && ICD.blocks[n].n1 <= n2 && ICD.blocks[n].n2 >= n1 && ICD.blocks[n].n2 <= n2 ){
					//console.log(ICD.blocks[n].l1,ICD.blocks[n].n1,ICD.blocks[n].l2,ICD.blocks[n].n2,ICD.blocks[n].label);
					newElements.push(ICD.blocks[n]);
				}
			}*/
			formCatalog.call( $('#catalog2'), newElements, 'block', ind );
		// - Block click - get Nosologies
		}else{
			// new loop
			for(var prop in ICD.count.block){
				if(prop == l1 + n1 + l2 + n2){
					finish = start + ICD.count.block[prop]
					break;
				}
				start += ICD.count.block[prop];
			}
			newElements = ICD.nosologies.slice(start, finish);
			// old loop
			/*for(var n in ICD.nosologies){
				var char0 = ICD.nosologies[n].l.charCodeAt(0);
				if( char0 > code1 && char0 < code2 || char0 == code1 && ICD.nosologies[n].n1 >= n1 && char0 == code2 && ICD.nosologies[n].n1 <= n2 || char0 == code1 && ICD.nosologies[n].n1 >= n1 && char0 != code2 || char0 == code2 && ICD.nosologies[n].n1 <= n2 && char0 != code1 ){
					newElements.push( ICD.nosologies[n]);
				}
			}*/
			formCatalog.call($('#catalog3'), newElements, 'nosology', ind);
		}
	// -  Nosology click - get Diagnoses
	}else if( element == 'nosology' ){
		var l = $(this).attr('l'),
				n1 = $(this).attr('n1');
		// new loop
		for(var prop in ICD.count.nosology){
			if(prop == l + n1){
				finish = start + ICD.count.nosology[prop]
				break;
			}
			start += ICD.count.nosology[prop];
		}
		newElements = ICD.diagnoses.slice(start, finish);
		// old loop
		/*for(var n in ICD.diagnoses){
			if( ICD.diagnoses[n].l == l && ICD.diagnoses[n].n1 == n1 )
				newElements.push(ICD.diagnoses[n]);
		}*/
		formCatalog.call($('#catalog4'), newElements, 'diagnose', ind);
	// - Diagnose
	}else{
		return;
	}
	newElements.length = 0;
	slideCatalog(element);
};
function formCatalog(list, element, ind, letters){
	// console.log('formCatalog');
	console.time('formCatalog');
	var catalog = this.find('ul');
	catalog.empty();
	switch(element) {
		// - Diagnose
		case 'diagnose':
			for(var n in list){
				var text = list[n].label
					.replace(/[А]([0-9]{2})/,"A$1")//delete Cyrilic letters
					.replace(/[В]([0-9]{2})/,"B$1")
					.replace(/[Е]([0-9]{2})/,"E$1")
					.replace(/(\([A-Z][0-9]{2}(\.[0-9]{1}){0,}(\+|\*)\))/, 
						"<button class='iLink btn-sm btn-primary'><b>$1</b></button>");//add iLink
				var li = $('<li><b>' + list[n].l + list[n].n1 + '.' + list[n].n2 + '</b> ' + text + '</li>');
				li.attr({
					'class' : 'element list-group-item',
					'element' : element,
					'l' : list[n].l,
					'n1' : list[n].n1,
					'n2' : list[n].n2,
					'number' : n
				});
				catalog.append(li);
			}
			// console.log("before Trigger", element)
			// $(document).trigger("catalogReady");
			break;
		// - Nosology
		case 'nosology':
			for(var n in list){
				var span = "";
				if ( ICD.count ){
					var count = ICD.count.nosology[list[n].l + list[n].n1];
					var span = '<span class="badge pull-right">' + count + '</span>';
				}
				li = $('<li>' + span + '<b>' + list[n].l /*+ '.'*/ + list[n].n1 + '</b>  ' + list[n].label + '</li>');
				li.attr({
					'class' : 'element list-group-item',
					'element' : element,
					'l' : list[n].l,
					'n1' : list[n].n1,
					'number' : n
				});
				catalog.append(li);
			}
			// console.log("before Trigger", element)
			// $(document).trigger("catalogReady");
			break;
		//  - Catalog & Block
		default:
			for(var n in list){
				var span = "";
				if ( ICD.count ){
					var count = ICD.count[element][list[n].l1 + list[n].n1 + list[n].l2 + list[n].n2];
					var span = '<span class="badge pull-right">' + count + '</span>';
				}
				var li = $('<li>'+ span +'<b>' + list[n].l1 /*+ '.'*/ + list[n].n1 + '-' + list[n].l2 /*+ '.'*/ + list[n].n2 + '</b>  ' + list[n].label + '</li>');
				li.attr({
					'class' : 'element list-group-item',
					'element' : element,
					'l1' : list[n].l1,
					'n1' : list[n].n1,
					'l2' : list[n].l2,
					'n2' : list[n].n2,
					'number' : n
				});
				catalog.append(li);
			}
			// console.log("before Trigger", element)
			// $(document).trigger("catalogReady");
			break;
	}
	console.timeEnd('formCatalog');
	return true;
};
function activeElement(el){
	if( el && el.hasClass("element") ){
		var type = el.attr("element");
		activeElement[type] = el;
		el.parent().children(".active").removeClass("active");
		return el.addClass("active");
	}/*
	else{
		return activeElement.active[type];
	}*/
};
function scrollCatalog(el){
	// console.log("scrollCatalog");
	if(el && typeof el === "object"){
		var pos = el.offset();
		// console.log(el, pos.top)
		screen.width > 690
			? $("html, body").animate({ scrollTop: pos.top - $(window).height()/2 })
			: $("html, body").scrollTop( pos.top - $(window).height()/2 );
	}else{
		var height = $('#top_menu').height(),
				pos = $('#catalog').offset();
		if( ($(window).scrollTop() + height) > pos.top){
			screen.width > 690
				? $("html, body").animate({ scrollTop: pos.top - height })
				: $("html, body").scrollTop( pos.top - height );
		}
	}
	Width1();
	return true;
}
function slideCatalog(type, back){
	// console.log('slideCatalog');
	// console.log(screen.width)
	// console.log(type);
	var step;
	if (type){
		switch (type) {
			case 'class':
				step = 0;
				break;
			case 'block':
				step = 1;
				break;
			case 'nosology':
				step = 2;
				break;
			case 'diagnos':
				step = 3;
				break;
			default:
				step = 4;
				break;
		}
		back || step++;
		if(step > APP.stepCatalog){// Forward
			APP.stepCatalog++;
			// scrollCatalog();
		}else{// Back
			APP.stepCatalog--;
			// scrollCatalog( activeElement[type] );
		};
	}
	// calibrate catalog width - scrollbar hide change width of page
	$("#catalog").height( $("#catalog" + (step+1) ).height() );
	APP.width1 = $("#catalog-wrapper").width();
	// slide if more powerfull core - basing on screen width
	screen.width > 690
		? $('#catalog').animate({"left" : -APP.width1 * APP.stepCatalog})
		: $('#catalog').css("left", -APP.width1 * APP.stepCatalog);
	scrollCatalog( back && activeElement[type] );
	$(document).trigger("catalogReady");
	return true;
};
function startCatalog(animation){
	APP.stepCatalog = 0;
	animation
		? $('#catalog').animate({"left" : -APP.width1 * APP.stepCatalog})
		: $('#catalog').css("left",-APP.width1 * APP.stepCatalog);
};
function catalogView( type ){
	// if type and not default #tabs width
	if(!type && type !== 0){
		// if storage and Stteing is in
		// read from localStorage Setting
		console.log("catalogView EMPTY", type);
		if( storage && storage.catalogView ){
			if(storage.catalogView == 1 ) return;
			type = +storage.catalogView;
			// write the Setting into data for "toggleFunc" order
			$("#tabs").data('toggleStatus', type - 1);
			console.log("not 1")
		}else{
			return false;
		}
	}
	/*( !type && type !== 1 && type !== 0) && ( 
		console.log("catalogView EMPTY", type),
		// read from localStorage Settings
		type = +storage.catalogView, 
		// write the Setting into data for "toggleFunc" order
		$("#tabs").data('toggleStatus', type - 1),
		// change icon for change-size if full-width (#3)
		type === 3 && $(".resize_content").toggleClass('glyphicon-resize-full glyphicon-resize-small')
	);*/
	console.log("catalogView HANDLER", type);
	var width, marginLeft;
	switch (type){
		case 0 : width = '', marginLeft = '';
			break; 
		case 2 : width = '75%', marginLeft = '12.5%';
			break;
		case 3 : width = screen.width, marginLeft = '0';
			break;
		case 1 : width = '50%', marginLeft = '25%';
			break;
		default: throw new Error("unReg arg for catalogView");
			break;
	}
	// save Setting to localStorage if type != 0
	// '0' only fpr default CSS
	type && (storage.catalogView = type);
	// unify handler
	var action = (type === 0) ? ('css') : 'animate' ;
	$('#tabs')[action]({
		width: width,
		marginLeft: marginLeft
	}, adaptation.bind(null, true, true) );
}
// - Search
function searchList(){
	console.time("searchList");
	var min = 0,
			max = ICD.diagnoses.length;
	ICD.concat = [];
	
	//concat Diagnoses && Nosologies
	for(var k = 0; k < ICD.nosologies.length; k++){
		ICD.concat.push( ICD.nosologies[k] );

		var l = ICD.nosologies[k]['l'];//console.log(l)
		var n1 = ICD.nosologies[k]['n1'];//console.log(n1)

		/*for(var n in ICD.diagnoses){
			if (ICD.diagnoses[n].l == l && ICD.diagnoses[n].n1 == n1){
				ICD.concat.push( ICD.diagnoses[n] );
				conti
			}
		}*/
		for( ; min < max; ){
			// console.log(min, k);
			// console.log(l, n1, "| |", ICD.diagnoses[min].l, ICD.diagnoses[min].n1, ".", ICD.diagnoses[min].n2/*, ICD.diagnoses[min].label */);
			if(ICD.diagnoses[min].l == l && ICD.diagnoses[min].n1 == n1){
				ICD.concat.push( ICD.diagnoses[min] );
				min++;
			}else if(ICD.diagnoses[min].l < l || ICD.diagnoses[min].n1 < n1){
				break;
			}else{
				break;
				// continue;
			}
		}
	}
	console.timeEnd("searchList");
};
function selectValidate(){
	//console.log('validation begin');
	$(".result").hide();
	if($('#letter').val() == '-'){
		$("#result1").show();
	}else if($('#number1a').val() == '-' || $('#number1b').val() == '-'){
		$("#result2").show();
	}else if($('#number2').val() == '-'){
		searchBySelect('nosologies');
	}else
		searchBySelect('diagnoses');
};
function searchBySelect(cat){
	console.time('searchBySelect');
	var result,
			letter = $('#letter').val(),//console.log(letter);
			number1 = $('#number1a').val() + '' + $('#number1b').val();//console.log(number1);
	if( cat == 'nosologies' ){
		var nos = ICD.nosologies;
		for(var i in nos){
			if( nos[i].l == letter && nos[i].n1 == number1 ){
				var $iLink = "<a class='iLink btn btn-primary'>" + nos[i].l /*+'.'*/ + nos[i].n1 + "</a>";
				result = $iLink + ' '+ nos[i].label;
			}
		}
	}else{
		var number2 = $('#number2').val(),//console.log(number2);
				dis = ICD.diagnoses;
		for(var i in dis){
			if( dis[i].l == letter && dis[i].n1 == number1 && dis[i].n2 == number2 ){
				var $iLink = "<a class='iLink btn btn-primary'>" + dis[i].l + dis[i].n1 +'.'+ dis[i].n2 + "</a>";
				result = $iLink + ' ' + dis[i].label;
			}
		}
	}
	$("#result0").html( result || "Жодного результату" ).show();
	console.timeEnd('searchBySelect');
};
function liveSearch(){
	console.log("liveSearch");
	var q = 0;
	$( "#autocomplete" ).autocomplete({
		//source: ICD.nosologies,
		// autoFocus: true,
		source: ICD.concat,//ICD[$("#changeSource button.active").attr("source")] || ICD.diagnoses,
		minLength: 3,
		appendTo: "#auto_results",
		//while element is on focus
		focus: function( event, ui ) {
			// console.log('focus');
			// console.log(event)
			if (/*event.toElement || */event.eventPhase == 3)
				return;
			var pos = $('.ui-state-focus').offset();
			$(window).scrollTop( pos.top - $(window).height()/2 );
		},
		//when element was selected
		select: function( event, ui ) {
			//console.log(ui.item.l);
			//number = nosologies.indexOf(ui.item.value);
			// var item = ICD.nosologies[ui.item.value];
			var code = ui.item.n2
				? ui.item.l + ui.item.n1 + '.' + ui.item.n2
				: ui.item.l + ui.item.n1;
			$( "#result" ).html( '<a class="iLink btn btn-primary">' + code + '</a> ' + ui.item.label );
			//$( "#autocomplete" ).val( item.l+'.'+item.n1+'.'+item.n2+' '+item.name );
			$( "#autocomplete-id" ).val( ui.item.l2 );
			$( "#autocomplete-description" ).html( ui.item.n1 );
			$(this).blur();
			$(window).scrollTop(0);
			// $( "#autocomplete-icon" ).attr( "src", "images/" + ui.item.icon );
			return false;
		},
		search: function(){
			console.time('FastSearching');
		},
		response: function(){
			console.timeEnd('FastSearching');
			q=0;
			console.time('FastDrawing');
		},
		open: function(){
			console.timeEnd('FastDrawing');
		},
		create: function(e){
			// console.log("create", e);
			// e = e.target.value;
			$(this).data('ui-autocomplete')._renderItem = function( ul, item ){
			// console.log( this/*.term, $("#autocomplete").val()*/ );
				var type;
				switch (q){
					case 3 : type = 'success';
						break;
					case 0 : type = 'info';
						break;
					case 1 : type = 'warning';
						break;
					case 2 : type = 'danger';
						break;
				}
				type = 'list-group-item-' + type;
				q++;
				if (q == 4) q=0;
				var code = item.l + item.n1;
				item.n2 && ( code += '.' + item.n2);
				var re = new RegExp( "("+this.term+")", "i");
				var text = item.label.replace( re, "<b><u>$1</u></b>" );
				return $( '<li>' )
					// .data( "item.autocomplete", item )
					.append( '<b>' + code + '</b> ' + text )
					// .append( item.label )
					.addClass( 'list-group-item ' + type )
					.addClass( item.n2 && "sub" )
					// .addClass( type )
					.appendTo( ul )
					//.parent()
					//.addClass('list-group-item col-xs-4')
					//.css('width',0);
				// return $(ul).append('<li class="list-group-item '+type+' "><b>'+code+'</b> '+text+'</li>')
			},
			$(this).data('ui-autocomplete')._resizeMenu = function( ul, item ){
				//this.menu.element.outerWidth(APP.width2);
				this.menu.element.width(APP.width2-2);
			}
		}
	});
};
// - Commons functions
function checkStorage(){
	var check = 'check';
	try {
		storage.setItem(check, check);
		storage.removeItem(check);
		return true;
	} catch(e) {
		return false;
	}
};
function cache(){
	log("??? Check Cache");
	var no = "",
			text = "Ваш бразуер " + no + "підтримує веб-додаток";
	applicationCache
		? (function(){
				log(text);
			})()
		: (function(){
				no = "no";
				log(text);
			})();
	$("#localCheck").append(text);
};
function save(name, obj){
	console.log("save^: "+ name);
	if(!checkStorage) return;
	storage[name] = encode(obj);
	return true;
};
// - Multi Lang
function mlDefine($scope) {
	//ml $scope.ml = Lang.text;
	//ml $scope.ml.code = Lang.code;
	//ml $scope.ml.name = Lang.name;
	//ml $scope.ml.version = Lang.version;
	//ml $scope.ml.langs = [];
	//ml for(var lang in version.Lang){
	//ml 	if(lang != $scope.ml.code){
	//ml 		version.Lang[lang].code = lang;
	//ml 		$scope.ml.langs.push(version.Lang[lang]);
	//ml 	};
	//ml };
}
function translate(){
	//ml console.log("translate");
	//ml var appElement = document.querySelector('[ng-controller="TranslateController"]'),
	//ml 		$scope = angular.element(appElement).scope();
	//ml //log("___________", angular.element(appElement).scope);
	//ml // $(window).load(function($scope){log($scope.$apply)
	//ml 	$scope.$apply(mlDefine, [$scope]);
	//ml // })
	//ml return true;
};
function getLang(){
	//ml console.log("getLang");
	//ml var lang = navigator.language || navigator.browserLanguage;
	//ml lang = lang.slice(0,2);
	//ml console.log(lang);
	//ml if(!version.Lang.hasOwnProperty(lang))
	//ml 	lang = "uk";
	//ml return lang;
};
/*function checkLoad(xhr, name){
	log("checkLoad")
			if(xhr.readyState === 4){
				if(xhr.status === 200){
					console.log("---------" + name + " READY");
					console.timeEnd("timer");
				}
				else{
					log("FAIL")
					var z = counter()
					log(z.count())
				}
			}
			return xhr;
};*/
// - Loading
function load(file, name, method){
	// path && (file = path + file);
	// if(!!file) return false;
	console.log("load: " + file + ".json && save as \{" + name + "\}", "method: " + method);
	preloaderXHR.add(file, name);//ON Preloader
	var meth = method || "get",
			deferred = new $.Deferred( function() {//Promise
		$http( file + ".json")[meth]()//load json file
			.then(
				function(data){//if data load Good (XHR)
					// callback.success;
					if(name === 'ICD'){
						data = parse(data);
						var names = ['count','classes','blocks','nosologies','diagnoses'];
						for (var i = names.length - 1; i >= 0; i--) {
							window[name][ names[i] ] = data[i];
						}
					}
					/*if(name.match(/\./)){//if name has "."
						var temp = name.split(".");//split to object : property
						if( !window[ temp[0] ] ) window[ temp[0] ] = {};//if no object - create it
						window[ temp[0] ][ temp[1] ] = parse(data);//asign object : property
						// checkStorage && save(temp[0], window[ temp[0] ]);//if storage available save it
					}*/
					else{
						window[name] = parse(data);//asign object : property
						// checkStorage && save(name, window[name]);//if storage available save it
					}
					preloaderXHR.readyFile(file, name);
					deferred.resolve();
				},
				function(data, url){//if data load fail (XHR)
					callback.error(data, url);
					deferred.reject();
				}
			);
		});
	return deferred.promise();
};
function loadLang(lang){
	//ml var abr = lang || getLang();
	//ml return load("public/lang/" + abr, "Lang", "post")//.then(translate)
	//ml .then(function(){
	//ml 	save("Lang", Lang);
	//ml })
}
function loadDB(){
	return $.when(
		/*load("public/db/count", "ICD.count"),
		load("public/db/classes", "ICD.classes"),
		load("public/db/blocks", "ICD.blocks"),
		load("public/db/nosologies", "ICD.nosologies"),
		load("public/db/diagnoses", "ICD.diagnoses")*/
		load('public/db/db', 'ICD')
	).then(function (){
		// ICD = version.ICD["uk"/*getLang()*/];
		for (var prop in version.ICD["uk"]) {
			ICD[prop] = version.ICD["uk"][prop];
		};
		save( "ICD", ICD );
		// translate();
		searchList();
		paint();
		preloaderXHR.end();
	});
};
function loadAll(){
	load("public/version", "version")
	.then(function(){
		save("version", version);
		//ml loadLang()
		//ml .then(
			loadDB()
		//ml );
	});
};
function BD_init(){
	console.log("&\t BD_init");
	version = parse(storage.version);
	//ml Lang = parse(storage.Lang);
	ICD = parse(storage.ICD);
	searchList();
};
// - Router
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
			if(path && typeof path === "string" && callback){
				if(typeof callback === "function"){
					this.roads[path].controller = callback;
					return true;
				}
				return false;
			}else{
				if(typeof core.roads[path].controller === "function"){
					core.roads[path].controller();
				}
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
	}

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

function initRouter(){
	console.log("#____Router Initialization");
	window.$Router = __simpleRouter();
	$Router.path().add({
		"/" : "views/index.html",
		"/about" : "views/about.html",
		"/donate" : "views/donate.html"
	});
	$Router.path().add({
		"/feedback" : "views/feedback.html"
	});
	$Router.controller("/", function(){
		paint();
		// adaptation();
	});
	$Router.controller("/feedback", function(){
		$(window).trigger( 'load' );
	});
	$Router.init();

	/*var app = angular.module( 'multiLang', ['ngRoute']);
	app.config( function ($routeProvider, $locationProvider) {
		$routeProvider
			.when("/",{
					// controller : "TranslateController",
					templateUrl : "views/index.html"
			})
			.when("/about",{
					// controller : "TranslateController",
					templateUrl : "views/about.html"
			})
			.when("/donate",{
					// controller : "TranslateController",
					templateUrl : "views/donate.html"
			})
			.when("/feedback",{
					//controller : "TranslateController",
					templateUrl : "views/feedback.html"
			})
			.otherwise({redirectTo : "/"});
		$locationProvider.html5Mode({
			enabled: true,
			requireBase: false,
			rewriteLinks : false//true
		})//.hashPrefix('#');
	});
	app.controller('TranslateController', function ml( $scope*//*, $routeParams*//*){
		//ml var $appElement = $('[ng-controller="TranslateController"]'),
				$scope = angular.element( $appElement ).scope();
		$scope.ml = Lang.text;*/
		/*$scope.$on('$viewContentLoaded', function() {
			console.log("viewContentLoaded")
			paint();
			adaptation();
			$(window).trigger( 'load' );
		});
		$scope.$on('$routeChangeSuccess', function () {
			console.log("routeChangeSuccess");
			menu_href();
		})
	});*/
};
function routerEnd(){
	//ml var deferred = new $.Deferred( function() {//Promise
	//ml 	var $appElement = $('[ng-controller="TranslateController"]'),
	//ml 			$scope = angular.element( $appElement ).scope();
	//ml 	$scope.ml = Lang.text;
	//ml 	$scope.$on('$viewContentLoaded', function() {
	//ml 		deferred.resolve();
	//ml 	});
	//ml });
	//ml return deferred.promise();
};
// 

// -------------- Event handlers

//-------------- ACTions
/*$("#top_menu").click(function (e) {
	var $el = $(e.target),
		$menu = $("#top_menu");
	if($el.hasClass("technic") || $el.hasClass("dropdown-toggle"))
		return;
	$menu.find("li.active").removeClass("active");
	if($el.hasClass("navbar-brand")){
		$menu.find("a[href='../#/']").parent().addClass("active");
	}else{
		$el.parent().addClass("active");
	};
	APP.stepCatalog = 0;
});*/

// -------------- EVENTs (ON)
$('body')
//ON click, #selectSearchSubmit
	.on('click', '#selectSearchSubmit', function(){
		selectValidate();
	})
//ON click, #clearStorage
	.on('click', '#clearStorage', function () {
		console.log("clear Storage");
		storage.clear();
		alert("Storage is cleared");
	})
//ON click, .devMode
	.on('click', '.devMode', function (e) {
		if( $(this).hasClass("active") ){
			storage.Debugger = false;
		}else{
			storage.Debugger = true;
		}
		window.location.reload();
	})
//ON change, .selDisNum
	.on("change", '.selDisNum', function(){
		var numbers = [],
				letter = $('#letter').val(),
				number1 = $('#number1a').val() + '' + $('#number1b').val(),
				dis = ICD.diagnoses;
		for(var i in dis){
			if(dis[i].l == letter && dis[i].n1 == number1)
				numbers.push( ICD.diagnoses[i].n2 );
		}
		var $el = $('#number2');
		$el.find('option').remove();
		var op = document.createElement('option');
		op.setAttribute('value', '-') ;
		op.innerHTML = '-';
		$el.append(op);
		for(var i in numbers){
			op = document.createElement('option');
			op.setAttribute('value', numbers[i]) ;
			op.innerHTML = numbers[i];
			$el.append(op);
		}
		//console.log(numbers);
	})
//ON change, .icd_select
	.on("change", '.icd_select', function(){//console.log('changed');
		var select_code = $('#letter').val() /*+ '.'*/ + $('#number1a').val() + $('#number1b').val() + '.' + $('#number2').val();
		if($(this).attr("id") == "letter"){
			if($(this).val() != "-"){
				$('.icd_select.numbers').removeAttr("disabled");
				$("#selectSearchSubmit").removeAttr("disabled");
			}
			else{
				$('.icd_select.numbers').attr("disabled", "disabled");
				$("#selectSearchSubmit").attr("disabled", "disabled");
			}
		}
		$('#select_code').text(select_code);
	})
//ON click, #catalog-wrapper .backCatalog
	.on('click', '#catalog-wrapper .backCatalog', function() {
		var type = $(this).attr("type");
		slideCatalog(type, true);
	})
//ON click, #catalog-wrapper li.element
	.on('click tap', '#catalog-wrapper li.element', function(event){
		event.stopPropagation();
		catalogHandler.apply( $(this) );
	})
//ON click, #tab_menu button
	.on('click', '#tab_menu button', function (e) {
		e.preventDefault()
		if($(this).hasClass('active')) 
			return;
		$('#tab_menu .active').toggleClass('active')
		$(this).toggleClass('active');
		/*$('#content>.active').toggleClass('active').toggleClass('hidden-xs').toggleClass('hidden-sm');
		$($(this).attr('data-id')).toggleClass('active').toggleClass('hidden-xs').toggleClass('hidden-sm');*/
		$('#content>.active').toggleClass('active').toggleClass('hidden');
		$($(this).attr('data-id')).toggleClass('active').toggleClass('hidden');
		adaptation();
		Width2();
	})
//ON focus, #autocomplete
	.on('focus', "#autocomplete", function(){
	// $(this).autocomplete("search");
	})
//ON enter, #autocomplete
	.on("keypress", "#autocomplete", function(e){
		if ( e.keyCode === 13 ) {
			$(this).blur();
			$("#autocomplete").autocomplete("search");
		}
	})
//ON click, #start_search
	.on("click", "#start_search", function(){
		$("#autocomplete").autocomplete("search");
	})
//ON click, #clear_search
	.on("click", "#clear_search", function(){
		$("#autocomplete").val("").autocomplete("search", "");
	})
//ON click, #changeSource button
	.on('click', "#changeSource button", function(){
		$("#changeSource .active").removeClass("active");
		$(this).addClass("active");
		var source = $(this).attr("source");
		// if(!ICD.all){ ICD.all = ICD.nosologies.concat(ICD.diagnoses)};
		$( "#autocomplete" ).autocomplete('option', 'source', ICD[source]);
		// searchList();
		// $( "#autocomplete" ).autocomplete('option', 'source', ICD.search);
		// save("ICD",ICD);
	})
//ON click, .changeLang
	.on("click", ".changeLang", function(){
	//ml 	console.log("@\t Change Lang");
	//ml 	preloaderXHR.start();
	//ml 	var lang = $(this).data("lang");
	//ml 	console.log(lang);
	//ml 	//load("public/lang/" + lang, "Lang", "post")
	//ml 	loadLang(lang)
	//ml 	.then(function(){
	//ml 		translate();
	//ml 		save("Lang", Lang);
	//ml 		preloaderXHR.end();
	//ml 	});
	})
//ON click, #readNews
	.on("click", "#readNews", function(){
		storage.readNews = true;
		$("#myModal2").modal("hide");
	})
//ON click, .iLink
	.on("click", ".iLink", function(){
		var text = $(this).text().match(/[A-Z][0-9]{2}\.[0-9]{1,2}|[A-Z][0-9]{2}/);
		if(!text) return;
		$("#tab_menu .btn").eq(0).click();
		text = text.join("").split(".");
		var letter = text[0].match(/[A-Z]/)[0];
		var n = text[0].match(/[0-9]{2}/)[0];

		// Class
		$("#catalog1 .element").each(function(){
			var el = $(this);
			if( letter < el.attr("l2") || letter <= el.attr("l2") && n <= el.attr("n2") ){
				startCatalog();
				if(letter == "U"){
					$("#catalog1 .element").last().click();
				}else{
					el.click();
				}
				
				// Block
				$("#catalog2 .element").each(function(){
					var el = $(this);
					if( letter < el.attr("l2") || letter <= el.attr("l2") && n <= el.attr("n2") ){
						el.click();
						
						// Nosology
						$("#catalog3 .element").each(function(){
							var el = $(this);
							if( letter == el.attr("l") && n == el.attr("n1") ){
								// select element or open it if \.[0-9]{1,2}
								if( text[1] ){
									el.click();
									
									// Diagnosis
									$("#catalog4 .element").each(function(){
										var el = $(this);
										if( text[1] == el.attr("n2") ){
											activeElement(el);
											$(":animated").promise().done(function() {
												scrollCatalog(el);
											});
											return false;
										}
									});

									return false;
								}else{
									/*activeElement(el).promise().done(
										function(){scrollCatalog(el);}
									);*/
									activeElement(el);
									$(":animated").promise().done(function() {
										scrollCatalog(el);
									});
								}
							}
						});

						return false;
					}
				});

				return false;
			}
		});
	})
//ON click, .resize_content
	.on("click", ".resize_content", function(){
		$('#tabs').toggleFunc([
			function(){
				catalogView(2);
				// $(this).toggleClass('col-md-6 col-md-offset-3');
			},
			function(){
				catalogView(3);
				$(".resize_content").toggleClass('glyphicon-resize-full glyphicon-resize-small');
			},
			function(){
				catalogView(1);
				$(".resize_content").toggleClass('glyphicon-resize-full glyphicon-resize-small');
				// $(this).toggleClass('col-md-6 col-md-offset-3');
			}],
			function(){
				// console.log('always')
				// slideCatalog();
				// $('#tabs').data('toggleStatus') === 2
			}
		);
		// $(".resize_content").toggleClass('glyphicon-resize-full glyphicon-resize-small');
});

// -------------- BEGIN
;(function(){
	log("------ Docuemnt Not Ready");
	APP_INIT();
})();

// -------------- Document Ready
$(document).ready(function(){
	// document.addEventListener("DOMContentLoaded", function(event) { 
	log("------ Document Ready");
	menu_href();
	$('[data-toggle="tooltip"]').tooltip();
	$(".devMode").addClass( function(){ return parse(storage.Debugger) ? "active" : ""; } );

	$( window ).on('realresize', function(){
		console.log('realresize')
		adaptation(true);
		// slideCatalog(/*APP.stepCatalog*/);
		Width2();
	});
	$( window ).on('orientationchange', function(e, data){
		console.log('orientationchange',e.from, '--->', e.to)
		e.to === "portrait" ? catalogView(0) : catalogView();
	});
	$( window ).on('orientationportrait', function(){

		console.log('orientationportrait', '||');
		// orientationchange
		// onlandscape
		// onportrait
		/*$('#tabs').css({
			width: "",
			marginLeft: ""
		}, adaptation);*/
		// adaptation();
	});

	//ml var $appElement = $('[ng-app="multiLang"]'),
	//ml 			$scope = angular.element( $appElement ).scope();
	//ml 	mlDefine($scope);
	//ml 	// 
	//ml 	$scope.$on('$viewContentLoaded', function() {
	//ml 		paint();
	//ml 	});
});

// -------------- Window Loaded
window.onload = function(){
	log("------ Window Loaded");
	window.loaded = true;
	// adaptation();
	// onload if "portrait" must be full width
	// as default bootstrap grid
	// storage = undefined; console.log(storage); //-- check storage and saved Setting inside
	/*!!storage && storage.catalogView && */
	($.getOrientation() === "landscape") && catalogView();
	if(checkStorage() && storage.readNews !== "true"){
		$("#myModal2").modal("show");
	}
	//formCatalog.call($('#catalog1'), ICD.classes, 'class', 0)
	
	//setTimeout(formCatalog.call($('#catalog1'), ICD.classes, 'class', 0), 0)
	//Width1();
	//Width2();
	//liveSearch();
}; 
