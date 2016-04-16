<?php
class user{
	/* Процедура входу в систему */
	public static function signin(){
		global $ROOT, $MySQLi, $ssID, $cfg;
		Sleep(3);
		if(!isset($_POST['hash'])){ 
			include_once($ROOT.'/template/404.php'); 
			return; 
		}
		$UserData = $MySQLi->select("SELECT id, MD5(CONCAT(`login`, `password`)) AS `hash` FROM `{$cfg['mysql']['prefix']}users` WHERE MD5(CONCAT(`login`, `password`)) = '{$_POST['hash']}' AND `active` = TRUE AND `privileges` > 0 LIMIT 1");
		if($UserData->num_rows == 1){
			$User = $UserData->fetch_object();
			Kernel::logs('Вхід до системи', $User->id);
			echo json_encode(array('status' => 'success', 'hash' => $User->hash, 'redirect' => 'manager'));
		}else{
			echo json_encode(array('status' => 'error', 'description' => 'Неправильно введено логін або пароль!'));
		}
	}
	
	/* Процедура виходи з системи */
	public static function signout(){
		Kernel::logs('Вихід з системи');
		setcookie('hash', '', time() - 3600, $GLOBALS['cfg']['host']['catalog'].'manager');
		header('Location: ../../');
	}
	
	/* Процедура валідації користувача */
	public static function VerifySession(){
		global $MySQLi, $cfg;
		$MySQLi->query("INSERT INTO `{$cfg['mysql']['prefix']}stats` VALUES(NULL, DEFAULT, NOW()) ON DUPLICATE KEY UPDATE `count` = `count` + 1");
		if(isset($_COOKIE['hash'])){
			$UserData = $MySQLi->select("SELECT `id`, `login`, MD5(CONCAT(`login`, `password`)) AS `hash`, `privileges` FROM `{$cfg['mysql']['prefix']}users` WHERE MD5(CONCAT(`login`, `password`)) = '{$_COOKIE['hash']}' LIMIT 1");
			if($UserData->num_rows == 1){
				return $UserData->fetch_object();
			}else{
				return null;
			}
		}else{
			return null;
		}
	}
	
	/* Примусова авторизація */
	public static function auth(){
		global $ROOT, $PageTitle, $RouteID;
		include_once($ROOT.'/template/_template.php');
	}
	
	/* Керування доступом користувача */
	private static function activity($ID, $Activity){
		global $MySQLi, $cfg;
		return (($MySQLi->query("UPDATE `{$cfg['mysql']['prefix']}users` SET `active` = {$Activity} WHERE `id` = {$ID} AND `privileges` <> 4") < 1) ? false : true);
	}
	
	/* Блокування користувача */
	public static function ban(){
		$FuncData = func_get_args();
		if(isset($FuncData[1]) && is_numeric($FuncData[1])){
			if(self::activity($FuncData[1], 0)){ Kernel::logs('Блокування користувача'); }
			header('Location: ../../../manager/users');
		};
	}
	
	/* Розлокування користувача */
	public static function unban(){
		$FuncData = func_get_args();
		if(isset($FuncData[1]) && is_numeric($FuncData[1])){
			if(self::activity($FuncData[1], 1)){ Kernel::logs('Розблокування користувача'); }
			header('Location: ../../../manager/users');
		};
	}
	
	/* Редагування прав доступу */
	public static function privileges(){
		global $MySQLi, $cfg;
		$FuncData = func_get_args();
		if(isset($FuncData[1], $FuncData[2]) && is_numeric($FuncData[1]) && is_numeric($FuncData[1])){
			if($MySQLi->query("UPDATE `{$cfg['mysql']['prefix']}users` SET `privileges` = {$FuncData[2]} WHERE `id` = {$FuncData[1]} AND `privileges` > 0 AND `privileges` <> 4") > 0){
				Kernel::logs('Зміна привілегій користувача #'.$FuncData[1].' на <b>"'.(($FuncData[2] == 1) ? 'Користувач' : (($FuncData[2] == 2) ? 'Модератор' : 'Адміністратор')).'"</b>');
			}
			header('Location: ../../../../manager/users');
		};
	}
	
	/* Зміна логіну */
	private static function setLogin($Login){
		global $MySQLi, $cfg, $ssID;
		return $MySQLi->query("UPDATE `{$cfg['mysql']['prefix']}users` SET `login` = '{$Login}', `updated` = NOW() WHERE `id` = ".$ssID->id);
	}
	
	/* Видалення користувача */
	public static function delete(){
		global $MySQLi, $cfg;
		$FuncData = func_get_args();
		$UserData = $MySQLi->select("SELECT `login` FROM `{$cfg['mysql']['prefix']}users` WHERE `id` = {$FuncData[1]} AND `privileges` > 0");
		if($UserData->num_rows > 0){
			$MySQLi->query("UPDATE `{$cfg['mysql']['prefix']}users` SET `privileges` = 0 WHERE `id` = {$FuncData[1]} AND `privileges` <> 4");
			Kernel::logs('Видалення користувача #'.$FuncData[0].' "'.$UserData->fetch_object()->login.'"');
		}
		header('Location: ../../../manager/users');
	}

	/* Збереження інформації користувача */
	public static function useredit(){
		global $MySQLi, $cfg, $ssID;
		Sleep(2);
		if(isset($_POST['NewLogin'], $_POST['NewPassword'], $_POST['OldPassword'], $_POST['NewPasswordConfirm'])){
			if($_POST['NewLogin'] != $ssID->login){
				if(Kernel::ValidLength($_POST['NewLogin'], 3, 50)){
					if(self::setLogin($_POST['NewLogin']) > 0){
						$Hash = md5($_POST['NewLogin'].$MySQLi->select("SELECT `password` FROM `{$cfg['mysql']['prefix']}users` WHERE `id` = ".$ssID->id)->fetch_object()->password);
					}
					if($MySQLi->Handle->errno == 1062){
						echo json_encode(array('status' => 'error', 'description' => 'Обліковий запис з таким логіном вже існує!'));
						return;
					} else if($MySQLi->Handle->error > 0){
						echo json_encode(array('status' => 'error', 'description' => 'При збереженні облікового запису виникла помилка #'.$MySQLi->Handle->errno.': '.$MySQLi->Handle->error));
						return;
					}
				} else {
					echo json_encode(array('status' => 'error', 'description' => 'Довжина логіну має бути від 3 до 50 символів!'));
					return;
				}
			}
			
			if(Kernel::ValidLength($_POST['OldPassword'], 6, 18) || Kernel::ValidLength($_POST['NewPassword'], 6, 18) || Kernel::ValidLength($_POST['NewPasswordConfirm'], 6, 18)){
				if(!Kernel::ValidLength($_POST['OldPassword'], 6, 18) || md5($ssID->login . md5($_POST['OldPassword'])) != $ssID->hash) {
					echo json_encode(array('status' => 'error', 'description' => 'Введено неправильний старий пароль!'));
					self::setLogin($ssID->login);
					return false;
				} else if(!Kernel::ValidLength($_POST['NewPassword'], $_POST['NewPasswordConfirm'], 6, 18)){
					echo json_encode(array('status' => 'error', 'description' => 'Некорректний новий пароль!'));
					self::setLogin($ssID->login);
					return false;
				} else if($_POST['NewPassword'] != $_POST['NewPasswordConfirm']){
					echo json_encode(array('status' => 'error', 'description' => 'Введені паролі не співпадають!'));
					self::setLogin($ssID->login);
					return false;
				} else  {
					if($MySQLi->query("UPDATE `{$cfg['mysql']['prefix']}users` SET `password` = MD5('{$_POST['NewPassword']}'), `updated` = NOW() WHERE `id` = ".$ssID->id) > 0){
						$Hash = md5($_POST['NewLogin'].md5($_POST['NewPassword']));
					} else if($MySQLi->Handle->error > 0){
						echo json_encode(array('status' => 'error', 'description' => 'При збереженні облікового запису виникла помилка #'.$MySQLi->Handle->errno.': '.$MySQLi->Handle->error));
						self::setLogin($ssID->login);
						return false;
					}
				}
			}
			Kernel::logs('Зміна особистих даних');
			echo json_encode(array('status' => 'success', 'description' => 'Дані облікового запису успішно збережено!', 'hash' => $Hash));
			return;
		} else {
			echo json_encode(array('status' => 'error', 'description' => 'Невірно вказані дані!'));
		}
	}
}
?>