<?php
Header("Content-Type: text/html;charset=UTF-8");

//require_once "vendor/autoload.php";

// HTML5 (new)
//$qp = html5qp("index.html");
$link = "http://uk.wikipedia.org/wiki/%D0%A1%D0%BF%D0%B8%D1%81%D0%BE%D0%BA_%D0%BA%D0%BE%D0%B4%D1%96%D0%B2_%D0%9C%D0%9A%D0%A5-10#.5BA00_B99.5D_.D0.94.D0.B5.D1.8F.D0.BA.D1.96_.D1.96.D0.BD.D1.84.D0.B5.D0.BA.D1.86.D1.96.D0.B9.D0.BD.D1.96_.D1.82.D0.B0_.D0.BF.D0.B0.D1.80.D0.B0.D0.B7.D0.B8.D1.82.D0.B0.D1.80.D0.BD.D1.96_.D1.85.D0.B2.D0.BE.D1.80.D0.BE.D0.B1.D0.B8";

//$list = html5qp($link, 'div#toc>ul')->append('<div></div>')->writeHTML();
//->text()

/*foreach($list as $result) {
    echo $result, '</br>';
}*/

//print $list;

// URL to fetch:
// $url = 'http://technosophos.com';

 //print qp($url, 'title')->text();
//print $qp("index.html", 'html')->text();


require('phpQuery/phpQuery.php');

// INITIALIZE IT  
// $doc = phpQuery::newDocumentHTML($markup);  
// $doc = phpQuery::newDocumentXML();  
// $doc = phpQuery::newDocumentFileXHTML('test.html');  
// $doc = phpQuery::newDocumentFilePHP('test.php');  
// $doc = phpQuery::newDocument('test.xml', 'application/rss+xml');  
// this one defaults to text/html in utf8  
$doc = phpQuery::newDocumentFileXHTML($link, $charset = 'utf-8'); 
//$doc = phpQuery::newDocumentHTML($link);
//print($doc['div#toc>ul>li>a']->text())


function normJsonStr($str){
    $str = preg_replace_callback('/\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
    return iconv('cp1251', 'utf-8', $str);
}

	//--FUNCTION for PARSING strings of CLASSES and BLOCKS with [,],A...Z,0...1 (KEL's comment)
	//--it works by 'substr' and number of chars position - position-depending
	function parse_classes($string){
		$string = substr($string, 1);
		$part = explode(']', $string);
		$code = $part[0];
		//$code = explode(' ', $string);
		echo $array['l1'] = substr($code, 0, 1);
		echo $array['n1'] = substr($code, 1, 2);
		echo $array['l2'] = substr($code, -3, -2);
		echo $array['n2'] = substr($code, -2);
		echo $array['label'] = substr($part[1], 1);
		echo '</br>';
		return $array;
	}
	//--getting CLASSES from wiki's page (KEL's comment)
	function getClasses($doc){
		$classes = array();
		foreach ($doc['div#toc>ul>li>a>span.toctext'] as $a){
			echo $f = pq($a)->text();
			echo '</br>';
			$regex = '/\[[A-Z]{1}\d{2}\ [A-Z]{1}\d{2}\]\ (.)/';
			if (preg_match( $regex, $f )){
				$classes[] =  parse_classes($f);
				echo "yes</br>";
			}
			else
				echo 'error';
			//if (substr($f, 0, 1) == '['){}
		}
		echo '</br>';
		echo $count = count($classes);
		echo '</br>';
		$classes = json_encode($classes);
		echo '</br>';
		
		$fp = fopen('json/classes.json', 'w');
		fwrite($fp, $classes);
		fclose($fp);
	}
	//getClasses($doc);


	//--getting BLOCKS from wiki's page (KEL's comment)
	function getBlocks($doc){
		$blocks = array();
		foreach ($doc['div#mw-content-text>ul>li'] as $a){
			echo $f = pq($a)->text();
			echo '</br>';
			$regex = '/\[[A-Z]{1}\d{2}\ [A-Z]{1}\d{2}\]\ (.)/';
			if (preg_match( $regex, $f )){
				$blocks[] =  parse_classes($f);
				echo "yes</br>";
			}
			else
				echo 'error';
			//if (substr($f, 0, 1) == '['){}
		}
		echo '</br>';
		echo count($blocks);
		$blocks = json_encode($blocks);
		//$blocks = mb_convert_encoding($blocks, 'UTF-8', 'UTF-16');
		//normJsonStr($blocks);
		$fp = fopen('json/blocks.json', 'w');
		fwrite($fp, $blocks);
		fclose($fp);
	}
	//getBlocks($doc);

	
	//--getting LINKS from wiki's page (KEL's comment)
	$links = array();
	function getLinks($doc){
		foreach ($doc['div#mw-content-text>dl>dd>i>a'] as $a){
			$page_link = $link.pq($a)->attr('href');
			$text_link = pq($a)->text();
			echo '<a href="https://uk.wikipedia.org/wiki/'.$text_link.'">'.$text_link.'</a>'.('</br>');
			$links[]['link'] = 'https://uk.wikipedia.org/wiki/'.$text_link;
			$links[]['text'] = $text_link;
			//echo $f = pq($a)->text().('</br>');
			
		}
		getDiagnoses($links);
	}	
	getLinks($doc);
	
	//$link2 = 'https://uk.wikipedia.org/wiki/ICD-10_%D0%A0%D0%BE%D0%B7%D0%B4%D1%96%D0%BB_A';
	//$doc2 = phpQuery::newDocumentFileXHTML($link2); 
	
	function parse_nosology($f){
		$array = array();
		$sep = stripos($f, ' ') + 1;
		echo $array['l'] = substr($f, 0, 1);
		echo '.';
		echo $array['n1'] = substr($f, 2, 2);
		echo '.';
		echo $array['label'] = substr($f, $sep);
		return $array;
		unset($array);
	}
	function parse_disease($f){
		$array = array();
		$sep = stripos($f, ' ') + 1;
		echo $array['l'] = substr($f, 0, 1);
		echo '.';
		echo $array['n1'] = substr($f, 2, 2);
		echo '.';
		echo $array['n2'] = substr($f, 5, 1);
		echo $array['label'] = substr($f, $sep);
		return $array;
		unset($array);
	}
	//getting NOSOLOGIES from wiki's page (KEL's comment)
	$diagnoses = array();
	function getDiagnoses($links){
		//$links = array();
		//$links[0] = 'https://uk.wikipedia.org/wiki/ICD-10_Розділ_A';
		foreach ($links as $link){
			echo '<a href="https://uk.wikipedia.org/wiki/'.$link['text'].'">'.$link['text'].'</a>'.('</br>');		
			$html = phpQuery::newDocumentFileXHTML($link['link']);
			foreach ($html['div#mw-content-text>ul>li>ul>li'] as $a){
				echo "</br>";
				echo $f = pq($a)->text();
				echo "</br>";
				$count = $_SESSION['diagnoses'];
				$count++;
				$regex = '/[A-Z]\.\d{2}\.\d{1}(.)/';
				if (preg_match( $regex, $f )){
					echo "yes</br>";
					$diagnoses[] = parse_disease($f);
					$_SESSION['diagnoses'] = $count;					
				}
				else echo "error</br>";
				//if (preg_match( $regex, $f )) echo $f ; else echo "no</br>";
				//if (substr($f, 0, 1) == '['){
				//	echo $nosology[] =  parse_string($f);
				//}
			}
			foreach ($html['div#mw-content-text>ul>li>b'] as $a){
				echo $f = pq($a)->text();
				echo "</br>";
				$count = $_SESSION['nosologies'];
				$count++;
				$regex = '/[A-Z]\.\d{2}\.(.)/';
				if (preg_match( $regex, $f )){
					echo "yes</br>";
					$nosologies[] = parse_nosology($f);
					$_SESSION['nosologies'] = $count;					
				}
				else echo "error</br>";
			}
		}
		echo $_SESSION['nosologies'];
		echo "</br>";
		echo $_SESSION['diagnoses'];
		
		$nosologies = json_encode($nosologies);
		//print_r($nosologies);
		$fp = fopen('json/nosologies.json', 'w');
		fwrite($fp, $nosologies);
		fclose($fp);
		
		$diagnoses = json_encode($diagnoses);
		//print_r($diagnoses);
		$fp = fopen('json/diagnoses.json', 'w');
		fwrite($fp, $diagnoses);
		fclose($fp);
	}
	
	/*$disease = array();
	foreach ($doc2['div#mw-content-text>ul>li>ul>li'] as $a){
		echo $f = pq($a)->text().'</br>';
		$regex2 = '/[A-Z]\.\d{2}\.\d{1,2}\ (.)/';		
		if (preg_match( $regex2, $f )) echo "yes</br>"; else echo "no</br>";
	}*/
	
/*
// FILL IT  
// array syntax works like ->find() here  
$doc['div']->append('<ul></ul>');  
// array set changes inner html  
$doc['div ul'] = '<li>1</li><li>2</li><li>3</li>';  
  
// MANIPULATE IT  
// almost everything can be a chain  
$li;  
$doc['ul > li']  
->addClass('my-new-class')  
->filter(':last')  
    ->addClass('last-li')  
// save it anywhere in the chain  
    ->toReference($li);  
	
	
	// SELECT IT  
// pq(); is using selected document as default  
phpQuery::selectDocument($doc);  
// documents are selected when created, iterated or by above method  
// query all unordered lists in last selected document  
pq('ul')->insertAfter('div');  
  
// INTERATE IT  
// all LIs from last selected DOM  
foreach(pq('li') as $li) {  
// iteration returns PLAIN dom nodes, NOT phpQuery objects  
$tagName = $li->tagName;  
$childNodes = $li->childNodes;  
// so you NEED to wrap it within phpQuery, using pq();  
pq($li)->addClass('my-second-new-class');  
}  
  
// PRINT OUTPUT  
// 1st way  
print phpQuery::getDocument($doc->getDocumentID());  
// 2nd way  
print phpQuery::getDocument(pq('div')->getDocumentID());  
// 3rd way  
print pq('div')->getDocument();  
// 4th way  
print $doc->htmlOuter();  
// 5th way  
print $doc;  
// another...  
print $doc['ul'];  
//</div>  */
?>