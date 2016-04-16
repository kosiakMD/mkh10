<?php
class Common{	
	/* Валідація дати */
	public static function date_valid($date){
		return preg_match('/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01])$/', $date);
	}

	/* Отримання значення по ключу */
	public static function array_get_value($array, $key){
		if(!is_array($array)) trigger_error('array_get_value() expects parameter 1 to be array, '.gettype($array).' given', E_USER_WARNING);
		return (array_key_exists($key, $array)) ? $array[$key] : NULL;
	}
	
	/* Екранування спецсимволів */
	public static function Escape($String){
		global $MySQLi;
		return $MySQLi->Handle->real_escape_string($String);
	}
	
	/* Скорочення фрази */
	public static function CutPhrase($String, $MaxLength = 100){
		return (strlen($String) > $MaxLength) ? trim(substr($String, 0, $MaxLength)).'...' : $String;
	}
	
	/* Форматування об'єму даних */
	public static function MemoryFormating($size){
		if($size<=1024) return $size.' байт'; 
		else if($size<=pow(1024, 2)) return round($size/(1024),2).' KB'; 
		else if($size<=pow(1024, 3)) return round($size/(pow(1024, 2)),2).' MB'; 
		else if($size<=pow(1024, 4)) return round($size/(pow(1024, 3)),2).' GB'; 
		else if($size<=pow(1024, 5)) return round($size/(pow(1024, 4)),2).' TB';
		else return round($size/(pow(1024, 5)),2).' PB';
	}
	
	/* Перевірки довжини фрази */
	public static function ValidLength(){
		if(func_num_args() > 2){
			list($MinLength, $MaxLength) = array_slice(func_get_args(), -2);
			foreach(array_slice(func_get_args(), 0, -2) as $String){
				if(strlen($String) < $MinLength || strlen($String) > $MaxLength) return false;
			}
			return true;
		} else {
			trigger_error('ValidLength() expects at least 3 parameters, '.func_num_args().' given', E_USER_ERROR);
		}
	}
	
	/* Отримання IP-адреси користувача */
	public static function UserIP(){
		global $REMOTE_ADDR; 
		global $HTTP_X_FORWARDED_FOR, $HTTP_X_FORWARDED, $HTTP_FORWARDED_FOR, $HTTP_FORWARDED; 
		global $HTTP_VIA, $HTTP_X_COMING_FROM, $HTTP_COMING_FROM; 

		if (empty($REMOTE_ADDR)) { 
			if (!empty($_SERVER) && isset($_SERVER['REMOTE_ADDR'])) { 
				$REMOTE_ADDR = $_SERVER['REMOTE_ADDR']; 
			} 
			else if (!empty($_ENV) && isset($_ENV['REMOTE_ADDR'])) { 
				$REMOTE_ADDR = $_ENV['REMOTE_ADDR']; 
			} 
			else if (@getenv('REMOTE_ADDR')) { 
				$REMOTE_ADDR = getenv('REMOTE_ADDR'); 
			} 
		}
		if (empty($HTTP_X_FORWARDED_FOR)) { 
			if (!empty($_SERVER) && isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
				$HTTP_X_FORWARDED_FOR = $_SERVER['HTTP_X_FORWARDED_FOR']; 
			} 
			else if (!empty($_ENV) && isset($_ENV['HTTP_X_FORWARDED_FOR'])) { 
				$HTTP_X_FORWARDED_FOR = $_ENV['HTTP_X_FORWARDED_FOR']; 
			} 
			else if (@getenv('HTTP_X_FORWARDED_FOR')) { 
				$HTTP_X_FORWARDED_FOR = getenv('HTTP_X_FORWARDED_FOR'); 
			} 
		}
		if (empty($HTTP_X_FORWARDED)) { 
			if (!empty($_SERVER) && isset($_SERVER['HTTP_X_FORWARDED'])) { 
				$HTTP_X_FORWARDED = $_SERVER['HTTP_X_FORWARDED']; 
			} 
			else if (!empty($_ENV) && isset($_ENV['HTTP_X_FORWARDED'])) { 
				$HTTP_X_FORWARDED = $_ENV['HTTP_X_FORWARDED']; 
			} 
			else if (@getenv('HTTP_X_FORWARDED')) { 
				$HTTP_X_FORWARDED = getenv('HTTP_X_FORWARDED'); 
			} 
		}
		if (empty($HTTP_FORWARDED_FOR)) { 
			if (!empty($_SERVER) && isset($_SERVER['HTTP_FORWARDED_FOR'])) { 
				$HTTP_FORWARDED_FOR = $_SERVER['HTTP_FORWARDED_FOR']; 
			} 
			else if (!empty($_ENV) && isset($_ENV['HTTP_FORWARDED_FOR'])) { 
				$HTTP_FORWARDED_FOR = $_ENV['HTTP_FORWARDED_FOR']; 
			} 
			else if (@getenv('HTTP_FORWARDED_FOR')) { 
				$HTTP_FORWARDED_FOR = getenv('HTTP_FORWARDED_FOR'); 
			} 
		}
		if (empty($HTTP_FORWARDED)) { 
			if (!empty($_SERVER) && isset($_SERVER['HTTP_FORWARDED'])) { 
				$HTTP_FORWARDED = $_SERVER['HTTP_FORWARDED']; 
			} 
			else if (!empty($_ENV) && isset($_ENV['HTTP_FORWARDED'])) { 
				$HTTP_FORWARDED = $_ENV['HTTP_FORWARDED']; 
			} 
			else if (@getenv('HTTP_FORWARDED')) { 
				$HTTP_FORWARDED = getenv('HTTP_FORWARDED'); 
			} 
		}
		if (empty($HTTP_VIA)) { 
			if (!empty($_SERVER) && isset($_SERVER['HTTP_VIA'])) { 
				$HTTP_VIA = $_SERVER['HTTP_VIA']; 
			} 
			else if (!empty($_ENV) && isset($_ENV['HTTP_VIA'])) { 
				$HTTP_VIA = $_ENV['HTTP_VIA']; 
			} 
			else if (@getenv('HTTP_VIA')) { 
				$HTTP_VIA = getenv('HTTP_VIA'); 
			} 
		}
		if (empty($HTTP_X_COMING_FROM)) { 
			if (!empty($_SERVER) && isset($_SERVER['HTTP_X_COMING_FROM'])) { 
				$HTTP_X_COMING_FROM = $_SERVER['HTTP_X_COMING_FROM']; 
			} 
			else if (!empty($_ENV) && isset($_ENV['HTTP_X_COMING_FROM'])) { 
				$HTTP_X_COMING_FROM = $_ENV['HTTP_X_COMING_FROM']; 
			} 
			else if (@getenv('HTTP_X_COMING_FROM')) { 
				$HTTP_X_COMING_FROM = getenv('HTTP_X_COMING_FROM'); 
			} 
		}
		if (empty($HTTP_COMING_FROM)) { 
			if (!empty($_SERVER) && isset($_SERVER['HTTP_COMING_FROM'])) { 
				$HTTP_COMING_FROM = $_SERVER['HTTP_COMING_FROM']; 
			} 
			else if (!empty($_ENV) && isset($_ENV['HTTP_COMING_FROM'])) { 
				$HTTP_COMING_FROM = $_ENV['HTTP_COMING_FROM']; 
			} 
			else if (@getenv('HTTP_COMING_FROM')) { 
				$HTTP_COMING_FROM = getenv('HTTP_COMING_FROM'); 
			} 
		}

		if (!empty($REMOTE_ADDR)) { 
			$direct_ip = $REMOTE_ADDR; 
		} 
		
		$proxy_ip     = ''; 
		if (!empty($HTTP_X_FORWARDED_FOR)) { 
			$proxy_ip = $HTTP_X_FORWARDED_FOR; 
		} else if (!empty($HTTP_X_FORWARDED)) { 
			$proxy_ip = $HTTP_X_FORWARDED; 
		} else if (!empty($HTTP_FORWARDED_FOR)) { 
			$proxy_ip = $HTTP_FORWARDED_FOR; 
		} else if (!empty($HTTP_FORWARDED)) { 
			$proxy_ip = $HTTP_FORWARDED; 
		} else if (!empty($HTTP_VIA)) { 
			$proxy_ip = $HTTP_VIA; 
		} else if (!empty($HTTP_X_COMING_FROM)) { 
			$proxy_ip = $HTTP_X_COMING_FROM; 
		} else if (!empty($HTTP_COMING_FROM)) { 
			$proxy_ip = $HTTP_COMING_FROM; 
		} 
		
		if (empty($proxy_ip)) { 
			return $direct_ip; 
		} else { 
			$is_ip = preg_match('|^([0-9]{1,3}\.){3,3}[0-9]{1,3}|', $proxy_ip, $regs); 
			if ($is_ip && (count($regs) > 0)) { 
				return $regs[0]; 
			} else { 
				return FALSE; 
			} 
		}
	}
	
	/* Отримання інформації про права доступу до файлу */
	public static function FileChmod($filename){
		return substr(sprintf('%o', fileperms($filename)), -3);
	}
	
	/* Отримання інформації про файл */
	public static function FileInfo($filename){   
		$perms = fileperms($filename);
		if (($perms & 0xC000) == 0xC000) {
			$info = 's';
		} elseif (($perms & 0xA000) == 0xA000) {
			$info = 'l';
		} elseif (($perms & 0x8000) == 0x8000) {
			$info = '-';
		} elseif (($perms & 0x6000) == 0x6000) {
			$info = 'b';
		} elseif (($perms & 0x4000) == 0x4000) {
			$info = 'd';
		} elseif (($perms & 0x2000) == 0x2000) {
			$info = 'c';
		} elseif (($perms & 0x1000) == 0x1000) {
			$info = 'p';
		} else {
			$info = 'u';
		}

		$info .= (($perms & 0x0100) ? 'r' : '-');
		$info .= (($perms & 0x0080) ? 'w' : '-');
		$info .= (($perms & 0x0040) ?
					(($perms & 0x0800) ? 's' : 'x' ) :
					(($perms & 0x0800) ? 'S' : '-'));

		$info .= (($perms & 0x0020) ? 'r' : '-');
		$info .= (($perms & 0x0010) ? 'w' : '-');
		$info .= (($perms & 0x0008) ?
					(($perms & 0x0400) ? 's' : 'x' ) :
					(($perms & 0x0400) ? 'S' : '-'));

		$info .= (($perms & 0x0004) ? 'r' : '-');
		$info .= (($perms & 0x0002) ? 'w' : '-');
		$info .= (($perms & 0x0001) ?
					(($perms & 0x0200) ? 't' : 'x' ) :
					(($perms & 0x0200) ? 'T' : '-'));
		return $info;
	}
	
	/* Отримання розміру каталогу в байтах */
	public static function DirectorySize($f){ 
		if(is_file($f)) return filesize($f); 
		$size=0; 
		$dh=opendir($f); 
		while(($file=readdir($dh))!==false){ 
				if($file=='.' || $file=='..') continue; 
				if(is_file($f.'/'.$file)) $size+=filesize($f.'/'.$file); 
				else $size+=self::DirectorySize($f.'/'.$file,false); 
		} 
		closedir($dh); 
		return $size+filesize($f);
	} 
	
	/* Отримання розміру каталогу в форматованому вигляді */
	public static function FormattedDirectorySize($dir){
		return self::MemoryFormating(self::DirectorySize($dir));
	}
	
	/* Видалення каталогу */
	public static function RemoveDir($dir) {
		if (substr($dir, strlen($dir)-1, 1) != '/')
		$dir .= '/';

		if ($handle = opendir($dir)) {
			while ($obj = readdir($handle)) {
				if ($obj != '.' && $obj != '..') {
					if (is_dir($dir.$obj)) {
						if (!self::RemoveDir($dir.$obj))
						return false;
					}
					elseif (is_file($dir.$obj)) {
						if (!unlink($dir.$obj)) return false;
					}
				}
			}
			closedir($handle);
			if (!@rmdir($dir)) return false;
			return true;
		}
		return false;
	}	
	
	/* Транслітерування кирилічних текстів */
	public static function Translite($str){
		$trans_arr = array (
		  "а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d",
		  "е"=>"e", "ё"=>"yo","ж"=>"j","з"=>"z","и"=>"i",
		  "й"=>"i","к"=>"k","л"=>"l", "м"=>"m","н"=>"n",
		  "о"=>"o","п"=>"p","р"=>"r","с"=>"s","т"=>"t",
		  "у"=>"y","ф"=>"f","х"=>"h","ц"=>"c","ч"=>"ch",
		  "ш"=>"sh","щ"=>"sh","ы"=>"i","э"=>"e","ю"=>"u",
		  "я"=>"ya",
		  "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D",
		  "Е"=>"E","Ё"=>"Yo","Ж"=>"J","З"=>"Z","И"=>"I",
		  "Й"=>"I","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
		  "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
		  "У"=>"Y","Ф"=>"F","Х"=>"H","Ц"=>"C","Ч"=>"Ch",
		  "Ш"=>"Sh","Щ"=>"Sh","Ы"=>"I","Э"=>"E","Ю"=>"U",
		  "Я"=>"Ya",
		  "ь"=>"","Ь"=>"","ъ"=>"","Ъ"=>"",
		  "ї"=>"j","і"=>"i","ґ"=>"g","є"=>"ye",
		  "Ї"=>"J","І"=>"I","Ґ"=>"G","Є"=>"Ye",
		  " "=>"_"
		 );
		return strtr($str, $trans_arr);
	}
	
	/* Архівування каталогу */
	public static function Compress($rootPath, $FileName){
		$zip = new ZipArchive();
		$zip->open($FileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);

		$files = new CallbackFilterIterator(new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator($rootPath),
			RecursiveIteratorIterator::LEAVES_ONLY), function($file){
					return (strpos($file, 'tmp') === false);
			}
		);

		foreach ($files as $name => $file){
			if (!$file->isDir()){
				$filePath = $file->getRealPath();
				$relativePath = substr($filePath, strlen($rootPath) + 1);
				$zip->addFile($filePath, $relativePath);
			}
		}
		
		$zip->close();
	}
	
	/* Визначення ОС сервера */
	public static function GetServerOS(){
		return ((strpos(strtoupper(php_uname('s')), 'WIN') !== false) ? 'windows' : 'linux');
	}
	
	/* Визначення операційної системи користувача */
    public static function GetUserOS(){
		if(isset($_SERVER)){
			$agent = $_SERVER['HTTP_USER_AGENT'] ;
		} else {
			global $HTTP_SERVER_VARS ;
			if(isset($HTTP_SERVER_VARS)){
				$agent = $HTTP_SERVER_VARS['HTTP_USER_AGENT'] ;
			} else {
				global $HTTP_USER_AGENT;
				$agent = $HTTP_USER_AGENT;
			}
		}
		
		$ros[] = array('Windows XP', 'Windows XP', 1);
		$ros[] = array('Windows NT 5\.\d|Windows NT5\.\d', 'Windows XP', 1);
		$ros[] = array('Windows NT 6\.\d|Windows NT6\.\d', 'Windows 7', 1);
		$ros[] = array('Windows 2000', 'Windows 2000', 1);
		$ros[] = array('Windows NT 5\.0', 'Windows 2000', 1);
		$ros[] = array('Windows NT 4\.0|WinNT4\.0', 'Windows NT', 1);
		$ros[] = array('Windows NT 5\.2', 'Windows Server 2003', 1);
		$ros[] = array('Windows NT 6\.0', 'Windows Vista', 1);
		$ros[] = array('Windows NT 7\.0', 'Windows 7', 1);
		$ros[] = array('Windows CE', 'Windows CE', 1);
		$ros[] = array('(media center pc)\.([0-9]{1,2}\.[0-9]{1,2})', 'Windows Media Center', 1);
		$ros[] = array('(win)([0-9]{1,2}\.[0-9x]{1,2})', 'Windows', 1);
		$ros[] = array('(win)([0-9]{2})', 'Windows', 1);
		#$ros[] = array('(windows)([0-9x]{2})', 'Windows');
		//$ros[] = array('(winnt)([0-9]{1,2}\.[0-9]{1,2}){0,1}', 'Windows NT');
		//$ros[] = array('(windows nt)(([0-9]{1,2}\.[0-9]{1,2}){0,1})', 'Windows NT'); // fix by bg
		$ros[] = array('Windows ME', 'Windows ME', 1);
		$ros[] = array('Win 9x 4\.90', 'Windows ME', 1);
		$ros[] = array('Windows 98|Win98', 'Windows 98', 1);
		$ros[] = array('Windows 95', 'Windows 95', 1);
		$ros[] = array('(windows)([0-9]{1,2}\.[0-9]{1,2})', 'Windows', 1);
		$ros[] = array('win32', 'Windows', 1);
		$ros[] = array('(java)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2})', 'Java');
		$ros[] = array('(Solaris)([0-9]{1,2}\.[0-9x]{1,2}){0,1}', 'Solaris');
		$ros[] = array('dos x86', 'DOS', 2);
		$ros[] = array('unix', 'Unix', 2);
		$ros[] = array('Mac OS X', 'Mac OS X', 3);
		$ros[] = array('Mac_PowerPC', 'Macintosh PowerPC', 3);
		$ros[] = array('(mac|Macintosh)', 'Mac OS', 3);
		$ros[] = array('(sunos)([0-9]{1,2}\.[0-9]{1,2}){0,1}', 'SunOS');
		$ros[] = array('(beos)([0-9]{1,2}\.[0-9]{1,2}){0,1}', 'BeOS');
		$ros[] = array('(risc os)([0-9]{1,2}\.[0-9]{1,2})', 'RISC OS');
		$ros[] = array('os\/2', 'OS/2');
		$ros[] = array('freebsd', 'FreeBSD', 2);
		$ros[] = array('openbsd', 'OpenBSD', 2);
		$ros[] = array('netbsd', 'NetBSD', 2);
		$ros[] = array('irix', 'IRIX');
		$ros[] = array('plan9', 'Plan9');
		$ros[] = array('osf', 'OSF');
		$ros[] = array('aix', 'AIX');
		$ros[] = array('GNU Hurd', 'GNU Hurd');
		$ros[] = array('(fedora)', 'Linux - Fedora', 4);
		$ros[] = array('(kubuntu)', 'Linux - Kubuntu', 4);
		$ros[] = array('(ubuntu)', 'Linux - Ubuntu', 4);
		$ros[] = array('(debian)', 'Linux - Debian', 4);
		$ros[] = array('(CentOS)', 'Linux - CentOS');
		$ros[] = array('(Mandriva).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)', 'Linux - Mandriva', 4);
		$ros[] = array('(SUSE).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)', 'Linux - SUSE', 4);
		$ros[] = array('(Dropline)', 'Linux - Slackware (Dropline GNOME)', 4);
		$ros[] = array('(ASPLinux)', 'Linux - ASPLinux', 4);
		$ros[] = array('(Red Hat)', 'Linux - Red Hat', 4);
		//$ros[] = array('X11', 'Unix');
		$ros[] = array('(linux)', 'Linux', 4);
		$ros[] = array('(amigaos)([0-9]{1,2}\.[0-9]{1,2})', 'AmigaOS');
		$ros[] = array('amiga-aweb', 'AmigaOS');
		$ros[] = array('amiga', 'Amiga');
		$ros[] = array('AvantGo', 'PalmOS');
		//$ros[] = array('(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1}-([0-9]{1,2}) i([0-9]{1})86){1}', 'Linux');
		//$ros[] = array('(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1} i([0-9]{1}86)){1}', 'Linux');
		//$ros[] = array('(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1})', 'Linux');
		$ros[] = array('[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}\)', 'Linux', 4);
		$ros[] = array('(webtv)\/([0-9]{1,2}\.[0-9]{1,2})', 'WebTV');
		$ros[] = array('Dreamcast', 'Dreamcast OS');
		$ros[] = array('GetRight', 'Windows', 1);
		$ros[] = array('go!zilla', 'Windows', 1);
		$ros[] = array('gozilla', 'Windows', 1);
		$ros[] = array('gulliver', 'Windows', 1);
		$ros[] = array('ia archiver', 'Windows', 1);
		$ros[] = array('NetPositive', 'Windows', 1);
		$ros[] = array('mass downloader', 'Windows', 1);
		$ros[] = array('microsoft', 'Windows', 1);
		$ros[] = array('offline explorer', 'Windows', 1);
		$ros[] = array('teleport', 'Windows', 1);
		$ros[] = array('web downloader', 'Windows', 1);
		$ros[] = array('webcapture', 'Windows', 1);
		$ros[] = array('webcollage', 'Windows', 1);
		$ros[] = array('webcopier', 'Windows', 1);
		$ros[] = array('webstripper', 'Windows', 1);
		$ros[] = array('webzip', 'Windows', 1);
		$ros[] = array('wget', 'Windows', 1);
		$ros[] = array('Java', 'Unknown', 1);
		$ros[] = array('flashget', 'Windows', 1);
		//$ros[] = array('(PHP)/([0-9]{1,2}.[0-9]{1,2})', 'PHP');
		$ros[] = array('MS FrontPage', 'Windows', 1);
		$ros[] = array('(msproxy)\/([0-9]{1,2}.[0-9]{1,2})', 'Windows', 1);
		$ros[] = array('(msie)([0-9]{1,2}.[0-9]{1,2})', 'Windows', 1);
		$ros[] = array('libwww-perl', 'Unix', 2);
		$ros[] = array('UP\.Browser', 'Windows CE', 1);
		$ros[] = array('NetAnts', 'Windows', 1);
		$ros[] = array('android|Android', 'Android', 5);
		
		$OperationSystem = new StdClass();
		for($n = 0;$n < count($ros); $n++){
			if(preg_match('/'.$ros[$n][0].'/i', $agent, $name)){
				$OperationSystem->name = trim(@$ros[$n][1].' '.@$name[2]);
				if(isset($ros[$n][2])){
					switch($ros[$n][2]){
						case 1:
						$OperationSystem->logo = 'windows';
						break;
						
						case 2:
						$OperationSystem->logo = 'terminal';
						break;
						
						case 3:
						$OperationSystem->logo = 'apple';
						break;
						
						case 4:
						$OperationSystem->logo = 'linux';
						break;
						
						case 5:
						$OperationSystem->logo = 'android';
						break;
						
						default:
						$OperationSystem->logo = 'question';
						break;
					}
				} else {
					$OperationSystem->logo = 'question';
				}
				break;
			}
		}
		return $OperationSystem;
    }
}
?>