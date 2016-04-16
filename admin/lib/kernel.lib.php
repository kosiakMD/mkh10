<?php
class Kernel extends Common{
	/* Примусовий SSL */
	public static function VerifySSL(){
		global $cfg;
		if($cfg['host']['protocol'] == 'https' && !(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')){
			header('Location: https://'.$cfg['host']['address'].$_SERVER['REQUEST_URI']);
		}
	}
	
	/* Фільтр даних */
	public static function Filter($Input){
		return htmlspecialchars(addslashes(trim($Input)), ENT_NOQUOTES);
	}
	
	/* Підготовка користувацьких даних для використання */
	public static function ProcessingUserData(){
		$_POST = array_map('Kernel::Filter', $_POST);
		$_GET = array_map('Kernel::Filter', $_GET);
		$_COOKIE = array_map('Kernel::Filter', $_COOKIE);
	}	
	
	/* Отримання URL-шляху */
	public static function BaseURL(){
		global $cfg;
		return $cfg['host']['protocol'].'://'.$cfg['host']['address'].(($cfg['host']['port'] != 80) ? ':'.$cfg['host']['port'] : '').$cfg['host']['catalog'];
	}
	
	/* Час виконання */
	public static function RunTime(){
		global $StartTime;
		return round((microtime(true) - $StartTime), 5);
	}
	
	/* Використана пам'ять */
	public static function UsedMemory(){
		$size = memory_get_peak_usage();
		return self::MemoryFormating($size);
	}
	
	/* Запис дії до логу */
	public static function logs($action, $UserID = null){
		global $MySQLi, $ssID, $cfg;
		$MySQLi->query("INSERT INTO `{$cfg['mysql']['prefix']}logs` VALUES(NULL, ".((is_null($UserID)) ? $ssID->id : $UserID).", '{$action}', INET_ATON('".Kernel::UserIP()."'), NOW()); DELETE * FROM `{$cfg['mysql']['prefix']}logs` WHERE `date` >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR);");
	}
	
	/* Генерація капчі */
	public static function captcha(){
		$width = 100;
		$height = 60;
		$font_size = 16;
		$let_amount = 4;
		$fon_let_amount = 30;
		$font = "fonts/cour.ttf";
		 
		$letters = array("a","b","c","d","e","f","g");      
		$colors = array("90","110","130","150","170","190","210");  
		 
		$src = imagecreatetruecolor($width,$height);         
		$fon = imagecolorallocate($src,255,255,255);
		imagefill($src,0,0,$fon); 
		 
		for($i=0;$i < $fon_let_amount;$i++) {
			$color = imagecolorallocatealpha($src,rand(0,255),rand(0,255),rand(0,255),100); 
			$letter = $letters[rand(0,sizeof($letters)-1)];                             
			$size = rand($font_size-2,$font_size+2);                                            
			imagettftext($src,$size,rand(0,45),
					   rand($width*0.1,$width-$width*0.1),
					   rand($height*0.2,$height),$color,$font,$letter);
		}
		 
		for($i=0;$i < $let_amount;$i++){
			$color = imagecolorallocatealpha($src,$colors[rand(0,sizeof($colors)-1)],
										$colors[rand(0,sizeof($colors)-1)],
										$colors[rand(0,sizeof($colors)-1)],rand(20,40)); 
										$letter = $letters[rand(0,sizeof($letters)-1)];
										$size = rand($font_size*2-2,$font_size*2+2);
										$x = ($i+1)*$font_size + rand(1,5);
										$y = (($height*2)/3) + rand(0,5);                            
										$cod[] = $letter;
			imagettftext($src,$size,rand(0,15),$x,$y,$color,$font,$letter);
		}
		 
		$_SESSION['code'] = implode("",$cod);
		header ("Content-type: image/png");
		imagepng($src); 
	}
}
Kernel::ProcessingUserData();
?>