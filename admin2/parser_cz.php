<?php
header('Powered: test'); 
header("Content-Type: text/html; charset=utf-8");//charset=windows-1250;Content-language: cs//UTF-8//windows-1250//ISO 8859-2, iso-8859-2
// echo '<meta http-equiv="Content-Language" content="cs">';
// echo '<meta http-equiv="Content-Type" content="text/html;">';
// echo '<meta charset="windows-1250">';

//require_once "vendor/autoload.php";

// $array = array( array("l" => "C", "n1" => "00", "label" => "label"), array("l" => "C", "n1" => "00", "label" => "label2"), array("l" => "C", "n1" => "00", "label" => "label") );
// print_r($array);
// echo "<br>";
// $result = array_unique($array);

// $result = array_map("unserialize", array_unique( array_map("serialize", $array) ));
// print_r($result);

// HTML5 (new)
//$qp = html5qp("index.html");
$serverLink = "http://www.uzis.cz/cz/mkn/";
$link = $serverLink."seznam.html";

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

// $doc = phpQuery::newDocumentFileXHTML($link, $charset = 'windows-1250'); 
// $doc = phpQuery::newDocumentHTML($link);
$doc = phpQuery::newDocumentFileHTML($link, $charset = 'windows-1250');
echo "<br>";
// print($doc['td.T']->text());
// print($doc);
// echo $doc['td.T[height="17"]'];
// echo $doc['td a.mkn'];
// $arr = $doc->find('td a.mkn');
// foreach ( $arr as $val){
// 	echo pq($val) ."<br>";
// }

print_r(json_encode($arr));

function normJsonStr($str){
	$str = preg_replace_callback('/\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
	return iconv('cp1251', 'utf-8', $str);
}

	//--FUNCTION for PARSING strings of CLASSES and BLOCKS with [,],A...Z,0...1 (KEL's comment)
	//--it works by 'substr' and number of chars position - position-depending
	function parse_classes($string){
		// $string = substr($string, 1);
		// $part = explode(']', $string);
		// $code = $part[0];
		//$code = explode(' ', $string);
		// echo $array['l1'] =  
		// print_r(preg_split( '/[A-Z]{1}\d{2}/', $string, PREG_SPLIT_DELIM_CAPTURE));
		preg_match('/[A-Z]{1}\d{2}\–/', $string, $matches, PREG_OFFSET_CAPTURE);
		// print_r($matches);

		echo $array['l1'] = substr($string, $matches[0][1], 1);
		echo $array['n1'] = substr($string, $matches[0][1] + 1, 2);
			echo " - ";
		echo $array['l2'] = substr($string, $matches[0][1] + 6, 1);
		echo $array['n2'] = substr($string, $matches[0][1] + 7, 2);
			echo " - ";
		echo $array['label'] = substr($string, $matches[0][1] + 9);
		echo '</br>';
		return $array;
	}
	//--getting CLASSES from wiki's page (KEL's comment)
	function getClasses($doc){
		$classes = array();
		foreach ($doc['tr'] as $a){
			$f = pq($a)->text();
			echo '</br>';
			$regex = '/([A-Z]{1,}\.[A-Z]{1}\d{2}\–){0,1}[A-Z]{1}\d{2}[a-z,A-Z]/';
			if (preg_match( $regex, $f )){
				echo $f = pq($a)->text();
				echo '<br>';
				$classes[] = parse_classes($f);
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
		
		$fp = fopen('json_CZ/classes.json', 'w');
		fwrite($fp, $classes);
		fclose($fp);
	}
	// getClasses($doc);

	function getBlockLinks($doc, $serverLink){
		$blockLinks = array();
		foreach ($doc['td a.mkn'] as $a){
			$page_link = $link.pq($a)->attr('href');
			$text_link = pq($a)->text();
			$regex = '/([A-Z]{1}\d{2}\–)[A-Z]{1}\d{2}/';
			// echo preg_match( $regex, $text_link );
			if( preg_match( $regex, $text_link ) === 1 ){
				echo $text_link.' ';
				echo '<a href="'.$serverLink.$page_link.'">'.$text_link.'</a>'.'</br>';
				$blockLinks[]/*['link']*/ = $serverLink.$page_link;
				// $blockLinks[]['text'] = $text_link;
			}
			//echo $f = pq($a)->text().('</br>');
			
		}
		// getBlocks($blockLinks);
		return $blockLinks;
	}
	// getBlockLinks($doc, $serverLink);

	function parse_blocks($string){
		// preg_match('/[A-Z]{1}\d{2}\–/', $string, $matches, PREG_OFFSET_CAPTURE);
		// print_r($matches);
		if( $string{0} === " " ){
			// $string = substr($string, 1);
		}else{
			$regex = '/([A-Z]{1}\d{2}\–)[A-Z]{1}\d{2}/';
			if( preg_match( $regex, $string ) === 1 ){
				echo $array['l1'] = substr($string, $matches[0][1], 1);
				echo $array['n1'] = substr($string, $matches[0][1] + 1, 2);
					echo " - ";
				echo $array['l2'] = substr($string, $matches[0][1] + 6, 1);
				echo $array['n2'] = substr($string, $matches[0][1] + 7, 2);
					echo " - ";
				echo $array['label'] = substr($string, $matches[0][1] + 9);
			}else{
				echo $array['l1'] = substr($string, $matches[0][1], 1);
				echo $array['n1'] = substr($string, $matches[0][1] + 1, 2);
					echo " - ";
				echo $array['l2'] = substr($string, $matches[0][1], 1);
				echo $array['n2'] = substr($string, $matches[0][1] + 1, 2);
					echo " - ";
				echo $array['label'] = substr($string, $matches[0][1] + 3);
			}
			echo '</br>';
			return $array;
		}
	}

	//--getting BLOCKS from wiki's page (KEL's comment)
	function getBlocks($doc, $serverLink, $links = ""){
		$links = getBlockLinks($doc, $serverLink);
		$blocks = array();
		print_r($links);
		foreach ($links as $link){
			echo $link."<br>";
			$doc = phpQuery::newDocumentFileHTML($link, $charset = 'windows-1250');
			foreach ($doc['tr'] as $a){
				$f = pq($a)->text();
				echo '</br>';
				$regex = '/([A-Z]{1,}\.[A-Z]{1}\d{2}\–){0,1}[A-Z]{1}\d{2}[a-z,A-Z]/';
				if (preg_match( $regex, $f )){
					echo $f = pq($a)->text();
					if( $f{0} !== " " ){
						echo '<br>';
						$blocks[] = parse_blocks($f);
						echo "yes</br>";
					}else{
						echo "NO</br>";
					}
				}
				else
					echo 'error';
			}
		}
		echo '</br>';
		echo count($blocks);
		$blocks = json_encode($blocks);
		//$blocks = mb_convert_encoding($blocks, 'UTF-8', 'UTF-16');
		//normJsonStr($blocks);

		$fp = fopen('json_CZ/blocks.json', 'w');
		fwrite($fp, $blocks);
		fclose($fp);
	}
	// $block_links = array("http://www.uzis.cz/cz/mkn/A00-B99.html");
	// getBlocks($doc, $serverLink, $block_links);
	// getBlocks($doc, $serverLink);

	//--getting LINKS from wiki's page (KEL's comment)
	$links = array();
	function getLinks($doc, $serverLink){
		// print_r( getBlockLinks($doc, $serverLink) );
		$block_links = getBlockLinks($doc, $serverLink);
		foreach ($block_links as $link) {
			echo $link."<br>";
			$doc = phpQuery::newDocumentFileHTML($link, $charset = 'windows-1250');
			foreach ($doc['tr>td.T'] as $a){
				$text_link = pq($a)->text();
				$regex = '/^([A-Z]{1}\d{2}\–){0,1}[A-Z]{1}\d{2}$/';
				if( preg_match( $regex, $text_link ) === 1 ){
					$href = pq($a)->find('a')->attr('href');
					echo '<a href="'.$serverLink.$href.'">'.$text_link.'</a>'.'<br>';
					$links[]['link'] = $serverLink.$href;
					$links[]['text'] = $text_link;
				}
			}
			/*foreach ($doc['div#mw-content-text>dl>dd>i>a'] as $a){
				$page_link = $link.pq($a)->attr('href');
				$text_link = pq($a)->text();
				echo '<a href="https://uk.wikipedia.org/wiki/'.$text_link.'">'.$text_link.'</a>'.('</br>');
				$links[]['link'] = 'https://uk.wikipedia.org/wiki/'.$text_link;
				$links[]['text'] = $text_link;
				//echo $f = pq($a)->text().('</br>');
				
			}*/
		}
		getDiagnoses($links);
	}
	getLinks($doc, $serverLink);
	
	function arrayUnique($array){
		$result = array_map("unserialize", array_unique( array_map("serialize", $array) ));
		foreach ($result as $key => $value) {
			$arr[] = $value;
		}
		return $arr;
	}
	function parse_nosology($string){
		$array = array();
		// $sep = stripos($string, ' ') + 1;
		echo "<br>";
		echo $array['l'] = substr($string, 0, 1);
		echo " ";
		echo $array['n1'] = substr($string, 1, 2);
		echo ' - ';
		echo $array['label'] = substr($string, 3);
		return $array;
		unset($array);
	}
	function parse_disease($f, $l, $n1){
		$array = array();
		echo "<br>";
		echo $array['l'] = $l;
		echo " ";
		echo $array['n1'] = $n1;
		echo '.';
		echo $array['n2'] = substr($f, 4, 1);
		echo ' - ';
		echo $array['label'] = substr($f, 5);
		return $array;
		unset($array);
	}
	//getting NOSOLOGIES from wiki's page (KEL's comment)
	// $diagnoses = array();
	function getDiagnoses($links){
		print_r($links); echo "<br><br>";
		foreach ($links as $link){
			echo '<a href="'.$link['text'].'">'.$link['text'].'</a>'.('</br>');
			$html = phpQuery::newDocumentFileHTML($link['link'], $charset = 'windows-1250');
			// echo $html;
			foreach ($html['tr'] as $a){
				$f = pq($a)->text();
				// echo '</br>';
				$regex = '/[A-Z]{1}\d{2}[a-z,A-Z]/';
				if (preg_match( $regex, $f )){
					echo '<br>';
					echo $f = pq($a)->text();
					$nosologies[] = parse_nosology($f);
					echo "<br>yes</br>";
					$l = substr($f, 0, 1);
					$n1 = substr($f, 1, 2);
				}

				$regex = '/\.\ [0-9]{1}[a-z,A-Z]/';
				if (preg_match( $regex, $f )){
					// echo '<br>';
					echo $f = pq($a)->text();
					$diagnoses[] = parse_disease($f, $l, $n1);
					echo "<br>diagnoses</br>";
				}
				//if (substr($f, 0, 1) == '['){}
			}
		}
		echo $_SESSION['nosologies'];
		echo "</br>";
		echo $_SESSION['diagnoses'];
		
		// $nosologies = arrayUnique($nosologies);
		$nosologies = json_encode($nosologies);
			// print_r($nosologies);echo"<br>";
		$nosologies = str_replace( "/\"[0-9]\"\:\{/", "{", $nosologies);
		$fp = fopen('json_CZ/nosologies.json', 'w');
		fwrite($fp, $nosologies);
		fclose($fp);
		
			// print_r($diagnoses);echo"<br>";echo"<br>";
		// $diagnoses = arrayUnique($diagnoses);
			// print_r($diagnoses);echo"<br>";echo"<br>";
		$diagnoses = json_encode($diagnoses);
			// echo $diagnoses;echo"<br>";
		// $diagnoses = str_replace( "/\"[0-9]\"\:\{/", "{", $diagnoses); //"0":{ -> {
			// echo $diagnoses;echo"<br>";
		$fp = fopen('json_CZ/diagnoses.json', 'w');
		fwrite($fp, $diagnoses);
		fclose($fp);
	}
	/*$diagnose_links = array( 
		array("link" => "http://www.uzis.cz/cz/mkn/C00-C14.html", "text" => "C00-C14"),
		array("link" => "http://www.uzis.cz/cz/mkn/C15-C26.html", "text" => "C15-C26"),
		array("link" => "http://www.uzis.cz/cz/mkn/C00-C14.html", "text" => "C00-C14")
	);*/
	// getDiagnoses($diagnose_links);
	
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