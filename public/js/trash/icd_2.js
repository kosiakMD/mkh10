/*!
keleborn.mail@gmail.com

(c) 2015 Anton Kosiak <keleborn.mail [at] gmail.com>
Dual licenced under the MIT license or GPLv3. See https://raw.github.com/Stuk/jszip/master/LICENSE.markdown.

JSZip uses the library ICD of World Health Organization under the MIT license :
https://who.com
*/
//status = window.jQuery ? 'OK' : 'NO';	console.log('-= jQuery is ' + status + ' =-')

//console.log("start");

/*! version - main sign for update && BD = true || false in BD()*/
var version = "0.2";
var byID = function(id){return document.getElementById(id)};

parse = function(json){return JSON.parse(json)};
encode = function(json){return JSON.stringify(json)};
log = function(arg){return console.log(arguments)}
//Object.prototype.text = function (text){return text !== undefined ? this.innerHTML = text : this.innerHTML};
//Object.prototype.val = function (val){e = this; return text !== undefined ? this.options[e.selectedIndex].value = val : this.options[e.selectedIndex].val};
/*HTMLDivElement.prototype.setAttributes = function (attrs){
	for(var key in attrs) {
		this.setAttribute(key, attrs[key]);
	}
}
function setAttributes(el, attrs){
	for(var key in attrs) {
		el.setAttribute(key, attrs[key]);
	}
}*/

var ICD = {
	number : 10,
	classes : [],
	blocks : [],
	diseases : []
};
/*
var _count = {
	count : ICD.classes.length,
	class : [],
	block : [[]],
	nosology : []
};*/

var classes = [], blocks = [], diseases = [], nosologies = [];
var width1, width2;
var stepCatalog = 0;

jQuery.fn.extend({
	//propAttr: $.fn.prop || $.fn.attr
});

function getJsonFile(name){
	/*
	function showError(elt, err) {
		//elt.innerHTML = "<p class='alert alert-danger'>" + err + "</p>";
		console.log('error: ', err);
	}
	function showContent(elt, type, content) {
		//elt.innerHTML = "<p class='alert alert-success'>loaded ! (as a " + type + ")<br/>" +
		//"Content = " + JSON.parse( content ) + "</p>";
		console.log(name + ' - success!');
		console.timeEnd('getJsonFile');
		return JSON.parse( content );
		//return content ;
	}
	JSZipUtils.getBinaryContent('json/' + name + '.zip', function(err, data) {
		var elt = document.getElementById('catalog');
		if(err) {
			showError(elt, err);
			return;
		}
		try {
			var zip = new JSZip(data);
			showContent(elt, "" + data, zip.file(name + ".json").asText());
		} catch(e) {
			showError(elt, e);
		}
	});*/
	
	
	var file = new XMLHttpRequest();
	file.open("POST", 'json/' + name + '.json', false);
	file.onreadystatechange = function ()
	{
		if(file.readyState === 4)
		{
			if(file.status === 200 || file.status == 0)
			{
				allText = file.responseText;
				//console.log(allText);
			}
		}
	}
	file.send(null);
	return JSON.parse( allText );
}
function slideCatalog(stepCatalog){
	//console.log('slide');
	//console.log(screen.width)
	//console.log(window.width)
	if (screen.width>690)
		$('#catalog').animate({"left" : -width1*stepCatalog});
	else
		$('#catalog').css("left",-width1*stepCatalog);
}
function formCatalog(list, element, ind, letters){
	console.log('formCatalog');
	catalog = this.find('ul');
	catalog.empty();
	switch(element) {
		case 'disease':
			for(n in list){
				li = $('<li>' + list[n].l + '.' + list[n].n1 + '.' + list[n].n2 + ' ' + list[n].label + '</li>');
				li.attr({
					'class': 'element list-group-item',
					'element' : element,
					'l' : list[n].l,
					'n1' : list[n].n1,
					'n2' : list[n].n2,
					'number' : n
				})
				catalog.append(li);
			}
			break;
		case 'nosology':
			for(n in list){
				count = ICD.count.nosology[list[n].l + list[n].n1];
				li = $('<li> <span class="badge pull-right">' + count + '</span>' + list[n].l + '.' + list[n].n1 + ' ' + list[n].label + '</li>');
				li.attr({
					'class': 'element list-group-item',
					'element' : element,
					'l' : list[n].l,
					'n1' : list[n].n1,
					'number' : n
				})
				catalog.append(li);
			}
			break;
		default:
			for(n in list){
				count = ICD.count[element][list[n].l1 + list[n].n1 + list[n].l2 + list[n].n2];
				//if ( element == 'class' )
					//count = _count[element][n] || 10;
				//else
					//count = _count[element][ind][n] || 10;
				li = $('<li> <span class="badge pull-right">' + count + '</span>[' + list[n].l1 + '.' + list[n].n1 + '-' + list[n].l2 + '.' + list[n].n2 + '] ' + list[n].label + '</li>');
				li.attr({
					'class': 'element list-group-item',
					'element' : element,
					'l1' : list[n].l1,
					'n1' : list[n].n1,
					'l2' : list[n].l2,
					'n2' : list[n].n2,
					'number' : n
				})
				catalog.append(li);
			}
	}
	//console.timeEnd('form catalog');
}
function alphabet(){
	var el = this;
	//console.log(el);
	for (var i=65; i<91; i++){
		letter = String.fromCharCode(i);
		op = document.createElement('option');
		op.setAttribute('value', letter);
		op.innerHTML = letter;
		el.append(op);
	}
}
function searchBySelect(cat){
	//console.time('test');
	var result;
	letter = $('#letter').val();
	//console.log(letter);
	number1 = $('#number1a').val() + '' + $('#number1b').val();
	//console.log(number1);
	if (cat == 'nosologies'){
		nos = ICD.nosologies;
		for ( i in ICD.nosologies){
			if (ICD.nosologies[i].l == letter && ICD.nosologies[i].n1 == number1)
				result = ICD.nosologies[i].l +'.'+ ICD.nosologies[i].n1 +'. '+ ICD.nosologies[i].label;
		}
	}
	else{
		number2 = $('#number2').val();
		//console.log(number2);
		dis = ICD.diseases;
		for ( i in dis){
			if (dis[i].l == letter && dis[i].n1 == number1 && dis[i].n2 == number2)
				result = dis[i].l +'.'+ dis[i].n1 +'.'+ dis[i].n2 +'. '+ dis[i].label;
		}
	}
	$('#select_result').text(result);
	//console.timeEnd('test');
}
function selectValidate(){
	//console.log('validation begin');
	if ($('#letter').val() == '-'){
		//console.log('error letter');
		$('#select_result').text('Choose Letter');
	}
	else if ($('#number1a').val() == '-' || $('#number1b').val() == '-'){
		//console.log('error n1');
		$('#select_result').text('Choose N1 first and second numbers');
	}
	else if ($('#number2').val() == '-'){
		//console.log('error nosologies');
		searchBySelect('nosologies');
	}
	/*else if ($('#number2').val() == '-'){
		console.log('n2');
		$('#select_result').text('Choose N2 first and second numbers');
	}*/
	else searchBySelect('diseases');
}
function Width1(){
	width1 = $("#catalog-wrapper").width();
	$(".list").width(width1-2);
	console.log('w1',width1);
}
function Width2(){
	width2 = $('#autocomplete').outerWidth();
	console.log('w2',width2);
}
function check(){
	var check = 'check';
    try {
        localStorage.setItem(check, check);
        localStorage.removeItem(check);
        return true;
    } catch(e) {
        return false;
    }
};
function loadBD(){
	console.time('classes');
	ICD.classes = getJsonFile('classes');
	console.timeEnd('classes');
	console.time('blocks');
	ICD.blocks = getJsonFile('blocks');
	console.timeEnd('blocks');
	console.time('nosologies');
	ICD.nosologies = getJsonFile('nosologies');
	console.timeEnd('nosologies');
	console.time('diseases');
	ICD.diseases = getJsonFile('diseases');
	console.timeEnd('diseases');
	console.time('count');
	ICD.count = getJsonFile('count');
	console.timeEnd('count');
}
function BD(){
	var BD = true;
	if(check() == true && BD == true){
		local = localStorage['ICD'];
		log("storage is aviable")
		if (!local){
			log("no BD - loading")
			loadBD();
			localStorage['ICD'] = encode(ICD);
			$("#localCheck").text("База даних завантажена і збережена на вашому пристрої");
		}else{
			ICD = parse(local);
			if(!ICD.version || ICD.version<version){
				log("old version - loading")
				loadBD();
				ICD.version = version;
				localStorage['ICD'] = encode(ICD);
				$("#localCheck").text("База даних оновлена і збережена на вашому пристрої");
			}
			else{
				console.log("BD up to date, version:",version)
				ICD = parse(local);
				log(ICD);
				$("#localCheck").text("База даних присутня на вашому пристрої є акутальною і не потребує завантаження");
			}
		}
	}
	else{
		loadBD();
		$("#localCheck").text("Ваш браузер чи пристрій не підтримує збереження даних");
	}	
}
//$(document).ready(function() {
$( window ).resize(function(){
	Width1()
	slideCatalog(stepCatalog)
	Width2()
});
/* ACTions */
$('select.numbers').each(function(){
	for(var i=0; i<10; i++){
		var op = document.createElement('option');
		op.setAttribute('value', i) ;
		op.innerHTML = i;
		this.appendChild(op)
	}
});
$('#selectSearchSubmit').click(function(){selectValidate()});
$('.selDisNum').change(function(){
	numbers = [];
	letter = $('#letter').val();
	number1 = $('#number1a').val() + '' + $('#number1b').val();
	dis = ICD.diseases;
	for ( i in dis){
		if (dis[i].l == letter && dis[i].n1 == number1)
			numbers.push( ICD.diseases[i].n2 );
	}
	el = $('#number2');
	el.find('option').remove();
	op = document.createElement('option');
	op.setAttribute('value', '-') ;
	op.innerHTML = '-';
	el.append(op);
	for ( i in numbers){
		op = document.createElement('option');
		op.setAttribute('value', numbers[i]) ;
		op.innerHTML = numbers[i];
		el.append(op);
	}
	//console.log(numbers);
});
$('.icd_select').change(function(){
	//console.log('changed');
	select_code = $('#letter').val() + '.' + $('#number1a').val() + $('#number1b').val() + '.' + $('#number2').val();
	$('#select_code').text(select_code);
});
$('body').on('click', '#catalog-wrapper .backCatalog', function() {
	stepCatalog--;
	slideCatalog(stepCatalog);
});
$('body').on('click', '#catalog-wrapper li.element', function() {
	element = $(this).attr('element');
	ind = $(this).attr('number');
	newElements = [];
	if ( element == 'class' || element == 'block' ){
		l1 = $(this).attr('l1');
		code1 = l1.charCodeAt(0);//console.log('c1',code1);
		n1 = $(this).attr('n1');
		l2 = $(this).attr('l2');
		code2 = l2.charCodeAt(0);//console.log('c2',code2);
		n2 = $(this).attr('n2');
		if ( element == 'class' ){
			for (n in ICD.blocks){
				char1 = ICD.blocks[n].l1.charCodeAt(0);//console.log('ch1',char1);
				char2 = ICD.blocks[n].l2.charCodeAt(0);//console.log('ch2',char2);
				if ( char1 >= code1 && char2 < code2 
					|| char1 >= code1 && char2 <= code2 
					&& ICD.blocks[n].n1 >= n1 && ICD.blocks[n].n1 <= n2 && ICD.blocks[n].n2 >= n1 && ICD.blocks[n].n2 <= n2  ){
						//console.log(ICD.blocks[n].l1,ICD.blocks[n].n1,ICD.blocks[n].l2,ICD.blocks[n].n2,ICD.blocks[n].label);
						newElements.push(ICD.blocks[n])
					
				}
			}
			//count = newElements.length;
			//console.log(count);
			formCatalog.call($('#catalog2'), newElements, 'block', ind);
		}
		else{
			for (n in ICD.nosologies){
				char0 = ICD.nosologies[n].l.charCodeAt(0);
				if ( char0 >= code1 && char0 <= code2 && ICD.nosologies[n].n1 >= n1 && ICD.nosologies[n].n1 <= n2)
					//console.log(ICD.nosologies[n].l,ICD.nosologies[n].n1,ICD.nosologies[n].label);
					newElements.push(ICD.nosologies[n])
			}
			//count = newElements.length;
			//console.log(count);
			formCatalog.call($('#catalog3'), newElements, 'nosology', ind);
		}
	}
	else if( element == 'nosology' ){
		l = $(this).attr('l');//console.log(l)
		n1 = $(this).attr('n1');//console.log(n1)
		for ( n in ICD.diseases){
			if (ICD.diseases[n].l == l && ICD.diseases[n].n1 == n1)
				//console.log(ICD.diseases[n].l,ICD.diseases[n].n1,ICD.diseases[n].n2,ICD.diseases[n].label);
				newElements.push(ICD.diseases[n])
		}
		//count = newElements.length;
		//console.log(count);
		formCatalog.call($('#catalog4'), newElements, 'disease', ind);
	}
	else return
	newElements.length = 0;
	height = $('.navbar-fixed-top').height();
	pos =  $('#catalog').offset();
	if ( ($(window).scrollTop() + height) > pos.top) 
		$(window).scrollTop( pos.top - height );
	stepCatalog++;
	slideCatalog(stepCatalog);
});
$('#tab_menu button').click(function (e) {
	e.preventDefault()
	if ($(this).hasClass('active')) return;
	$('#tab_menu .active').toggleClass('active')
	$(this).toggleClass('active');
	$('#content>.active').toggleClass('active').toggleClass('hidden-xs').toggleClass('hidden-sm');
	//$('#'+$(this).attr('aria-controls')).toggleClass('active');hidden-xs
	$($(this).attr('data-id')).toggleClass('active').toggleClass('hidden-xs').toggleClass('hidden-sm');
	Width1()
	Width2()
});
$("#changeSource button").click(function(){
	$("#changeSource .active").removeClass("active");
	$(this).addClass("active");
	source = $(this).attr("source");
	if (!ICD.all){ ICD.all = ICD.nosologies.concat(ICD.diseases)};
	$( "#autocomplete" ).autocomplete('option', 'source', ICD[source]);
});
//});

//handler
BD();
alphabet.call($('#letter'));
formCatalog.call($('#catalog1'), ICD.classes, 'class', 0);
Width1()
Width2()

window.onload = function(){
	
	/*function getDB(){
		console.time('ajax');
		console.time('success');
		console.time('complete');
		$.ajax({
			url: "db.php",
			context: document.body,
			success: function( json ) {
				console.timeEnd('success');
			},
			error: function( xhr, status, errorThrown ) {
			
			},
			complete: function( xhr, status ) {
				console.timeEnd('complete');
			},
			done: function(){
				console.timeEnd('ajax');
			}
			
		}).done(function(){console.timeEnd('ajax')});
	}
	getDB()
	*/
	//(function(){
		/* var $document = $(document);
	// добавляем код в очередь
        $document.queue(function() {
			
	
            
			setTimeout(function() {
                formCatalog.call($('#catalog1'), ICD.classes, 'class', 0);
                // по завершению вызываем следующую функцию в очереди
                $document.dequeue();
            }, 100);
        });	
	*/
	
	//console.log('lang');
	//console.time('dom')
	// re = /(?:^|\W)#(\w+)(?!\w)/g

	
	//var els = document.body.getElementsByTagName("*");
/*	el = document.body//.inerHTML;
var re = /(?:^|\W)#(\w+)(?!\w)/g, match, matches = [];
while (match = re.exec(el)) {
  matches.push(match[1]);
}
console.log(matches)*/
	
	//match = re.exec($(el).text())
	//console.log(match)
	
		/*
$("body").children().each(function () {
   // $(this).html( $(this).html().replace(/@/g,"$") );
  // console.log($(this).html());
  // match = re.exec($(this).html())
	console.log($(this).text())
	while (match = re.exec($(this).text())) {
  matches.push(match[1]);
}
});console.log(matches)
*/
	/*for (var i=0, max=els.length; i < max; i++) {
		el = els[i]
		tagName = el.tagName;
		//console.log(tagName)
		if (typeof tagName !== 'undefined' && tagName != 'SCRIPT'){
			//console.log(el.nodeValue )
				match = re.exec($(el).text())
		console.log(match)
				//$(el).text().match(re)
		}
	}*/
	//console.timeEnd('dom')
		
	//xmlhttp.open("GET","mkh10.hol.es/db.php",true);
	//xmlhttp.send();
	
	
	//})()
	
	
	//window.setTimeout(function(){ if(byID('wait')) byID('wait').style.display='none'; else  return true},500);

	var q = 0;
	$( "#autocomplete" ).autocomplete({
		//source: ICD.nosologies,
		autoFocus: true,
		source: ICD.diseases,
		minLength: 3,
		focus: function( event, ui ) {
			console.log('focus');
			if (event.toElement)
				return;
			pos = $('.ui-state-focus').offset();
			$(window).scrollTop( pos.top - $(window).height()/2 );
			//doc = document.documentElement;
			//top = (window.pageYOffset || doc.scrollTop)  - (doc.clientTop || 0);
			//console.log(top);
			//window.scroll(0, pos.top - top);
			//$(window).scrollTop( pos.top );
			
			//el = event.toElement;
			//pos = event.clientY;
			//console.log(pos.top);
			//$.scrollTo( event.clientY , 800, {axis:'y'});
			//var position = $(el).offset(); // position = { left: 42, top: 567 }
		//console.log(position)
 
			//$.scrollTo(el, 800);
			//$(window).scrollTo(el, 1000, {axis:'y'});
			//el = event.toElement;
			//$(el).toggleClass('active')
			//console.log(event)
			//this.addClass('active');
			//ui.item.toggleClass('active');
			//console.log($(this))
			//console.log(this)
			//console.log(ui.item)
			//$(el).toggleClass('active')
			//for(var key in ui) {var value = ui[key];console.log(key, value);}
			//$( "#autocomplete" ).val( ui.item.l + "." + ui.item.n1 + '.' + ui.item.n2 + ' ' + ui.item.name );
			//number = nosologies.indexOf(ui.item.value);
			//console.log(ICD.nosologies[nosologies.indexOf(ui.item.value)].name);
			//return false;
		},
		select: function( event, ui ) {
			//console.log(ui.item.l);
			//number = nosologies.indexOf(ui.item.value);
			item = ICD.nosologies[ui.item.value];
			if (ui.item.n2)
				$( "#result" ).text( ui.item.l+'.'+ui.item.n1+'.'+ui.item.n2+' '+ui.item.label );
			else
				$( "#result" ).text( ui.item.l+'.'+ui.item.n1+' '+ui.item.label );
			//$( "#autocomplete" ).val( item.l+'.'+item.n1+'.'+item.n2+' '+item.name );
			$( "#autocomplete-id" ).val( ui.item.l2 );
			$( "#autocomplete-description" ).html( ui.item.n1 );
			// $( "#autocomplete-icon" ).attr( "src", "images/" + ui.item.icon );
			return false;
		},
		search: function(){
			console.time('FastSearching');
		},
		response: function(){
			console.timeEnd('FastSearching');
			console.time('FastDrawing');
		},
		open: function(){
			console.timeEnd('FastDrawing');
		},
		create: function(){
			$(this).data('ui-autocomplete')._renderItem = function( ul, item ){
				q++;
				var type;
				switch (q){
					case 0:type='success';break;
					case 1:type='info';break;
					case 2:type='warning';break;
					case 3:type='danger';break;
				}
				type = 'list-group-item-' + type;
				if (q == 3) q=0;
				//ul.css('width',0)
				return $( "<li>" )
					//.append( item.l + "." + item.n1 + '.' + item.n2 + ' ' +	item.label )
					.append( item.label )
					.addClass('list-group-item')
					.addClass(type)
					.appendTo( ul )
					//.parent()
					//.addClass('list-group-item col-xs-4')
					//.css('width',0);
			},
			$(this).data('ui-autocomplete')._resizeMenu = function( ul, item ){
				//this.menu.element.outerWidth(width2);
				this.menu.element.width(width2-2);
			}
		}
		
	})

/* COUNTER for MENU
var _count = {
	class : {},
	block : {},
	nosology : {}
};
function counter(){
	var n = 0;
	return {
		count : function(){ return n++; },
		reset : function(){ n = 0 }
	};
};
function getCount(){
	classCount = counter();
	blockCount = counter();
	nosCount = counter();
	
	//count Blocks for Classes
	for (var inc = 0; inc < ICD.classes.length; inc++){

		var l1 = ICD.classes[inc]['l1'];
		var code1 = l1.charCodeAt(0);//console.log('c1',code1);
		var n1 = ICD.classes[inc]['n1'];
		var l2 = ICD.classes[inc]['l2'];
		var code2 = l2.charCodeAt(0);//console.log('c2',code2);
		var n2 = ICD.classes[inc]['n2'];

		for (z = 0; z < ICD.blocks.length; z++){
			
			var char1 = ICD.blocks[z].l1.charCodeAt(0);//console.log('ch1',char1);
			var char2 = ICD.blocks[z].l2.charCodeAt(0);//console.log('ch2',char2);
			if ( char1 >= code1 && char2 < code2 
				|| char1 >= code1 && char2 <= code2 
				&& ICD.blocks[z].n1 >= n1 && ICD.blocks[z].n1 <= n2 
				&& ICD.blocks[z].n2 >= n1 && ICD.blocks[z].n2 <= n2  ){
					
					classCount.count()
			}
		}
		
		var link = ICD.classes[inc];
		var code = link.l1 + link.n1 + link.l2 + link.n2;
		_count.class[code] = classCount.count();
		classCount.reset()
		console.log("class",code,'has:',_count.class[code])
		
	}

	//count Nosologies for Blocks
	for (var z = 0; z < ICD.blocks.length; z++){

		var bl1 = ICD.blocks[z]['l1'];
		var bcode1 = bl1.charCodeAt(0);//console.log('c1',code1);
		var bn1 = ICD.blocks[z]['n1'];
		var bl2 = ICD.blocks[z]['l2'];
		var bcode2 = bl2.charCodeAt(0);//console.log('c2',code2);
		var bn2 = ICD.blocks[z]['n2'];

		for (var j in ICD.nosologies){
			bchar0 = ICD.nosologies[j].l.charCodeAt(0);
			if ( bchar0 >= bcode1 && bchar0 <= bcode2 
				&& ICD.nosologies[j].n1 >= bn1 
				&& ICD.nosologies[j].n1 <= bn2 ){

				blockCount.count();
			}
		}

		var link = ICD.blocks[z];
		var code = link.l1 + link.n1 + link.l2 + link.n2;
		_count.block[code] = blockCount.count();
		blockCount.reset()
		console.log(z,"block",code,'has:',_count.block[code])
		
	}
	
	//count Diseases for Nosologies
	for (var k = 0; k < ICD.nosologies.length; k++){
		
		var l = ICD.nosologies[k]['l'];//console.log(l)
		var n1 = ICD.nosologies[k]['n1'];//console.log(n1)

		for ( n in ICD.diseases){
			if (ICD.diseases[n].l == l && ICD.diseases[n].n1 == n1){
				nosCount.count();
			}
		}

		var link = ICD.nosologies[k];
		var code = link.l + link.n1;
		_count.nosology[code] = nosCount.count();
		nosCount.reset()
		console.log(z,"nosology",code,'has:',_count.nosology[code])
		
	}
};
getCount()
*/

};

//------------- Angular JS -------------//
app.controller('multiLang', ['$scope', function($scope) { 
  $scope.Home = "Головна";
}]);

//console.log('END');