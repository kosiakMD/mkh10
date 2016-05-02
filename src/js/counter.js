/*!
 * COUNTER for MENU
 * kosiakMD@yandex.ua
 * Anton Kosiak <kosiakMD [at] yandex.ua>
 */ 
"use strict"
// 
var _count = {
	class : {},
	block : {},
	nosology : {}
};
console.log(_count.class);
function getCount(){
	var classCount = counter(),
			blockCount = counter(),
			nosCount = counter();
	
	//count Blocks for Classes
	for(var inc = 0; inc < ICD.classes.length; inc++){

		var l1 = ICD.classes[inc]['l1'];
		var code1 = l1.charCodeAt(0);//console.log('c1',code1);
		var n1 = ICD.classes[inc]['n1'];
		var l2 = ICD.classes[inc]['l2'];
		var code2 = l2.charCodeAt(0);//console.log('c2',code2);
		var n2 = ICD.classes[inc]['n2'];

		for(var z = 0; z < ICD.blocks.length; z++){
			
			var char1 = ICD.blocks[z].l1.charCodeAt(0);//console.log('ch1',char1);
			var char2 = ICD.blocks[z].l2.charCodeAt(0);//console.log('ch2',char2);
			if ( char1 >= code1 && char2 < code2 
				|| char1 >= code1 && char2 <= code2 
				&& ICD.blocks[z].n1 >= n1 && ICD.blocks[z].n1 <= n2 
				&& ICD.blocks[z].n2 >= n1 && ICD.blocks[z].n2 <= n2	){
					
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
	for(var z = 0; z < ICD.blocks.length; z++){

		var bl1 = ICD.blocks[z]['l1'];
		var bcode1 = bl1.charCodeAt(0);//console.log('c1',code1);
		var bn1 = ICD.blocks[z]['n1'];
		var bl2 = ICD.blocks[z]['l2'];
		var bcode2 = bl2.charCodeAt(0);//console.log('c2',code2);
		var bn2 = ICD.blocks[z]['n2'];

		for (var j in ICD.nosologies){
			var bchar0 = ICD.nosologies[j].l.charCodeAt(0);
			if(bchar0>bcode1&&bchar0<bcode2||bchar0==bcode1&&ICD.nosologies[j].n1>=bn1&&bchar0==bcode2&&ICD.nosologies[j].n1<=bn2||bchar0==bcode1&&ICD.nosologies[j].n1>=bn1&&bchar0!=bcode2||bchar0==bcode2&&ICD.nosologies[j].n1<=bn2&&bchar0!=bcode1){
				blockCount.count();
			}
		}

		var link = ICD.blocks[z];
		var code = link.l1 + link.n1 + link.l2 + link.n2;
		_count.block[code] = blockCount.count();
		blockCount.reset()
		if (_count.block[code] == 0)
			console.log(z,"block",code,'has:',_count.block[code]);
		//console.log(z,"block",code,'has:',_count.block[code])
		
	}
	
	//count Diagnoses for Nosologies
	for(var k = 0; k < ICD.nosologies.length; k++){
		
		var l = ICD.nosologies[k]['l'];//console.log(l)
		var n1 = ICD.nosologies[k]['n1'];//console.log(n1)

		for(var n in ICD.diagnoses){
			if (ICD.diagnoses[n].l == l && ICD.diagnoses[n].n1 == n1){
				nosCount.count();
			}
		}
		var link = ICD.nosologies[k];
		var code = link.l + link.n1;
		_count.nosology[code] = nosCount.count();
		nosCount.reset()
		if(_count.nosology[code] == 0)
			console.log(k,"nosology",code,'has:',_count.nosology[code]);
		//console.log(k,"nosology",code,'has:',_count.nosology[code])
	}
	
	ICD.count = _count
};
// setTimeout(getCount.call(0), 0)