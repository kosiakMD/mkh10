<?php
/* Збільшення часу роботи */
set_time_limit(240);

/* Час початку виконання */
$StartTime = microtime(true);

/* Пошук кореневого каталогу */
$ROOT = dirname(__FILE__);

/* Старт сесії користувача*/
session_start();
session_regenerate_id();

/* Ініціалізація конфігурацій системи */
include_once($ROOT.'/lib/config.lib.php');
$cfg = Config::load('common');
$siteCfg = Config::load('site');

/* Включити відображення помилок */
include_once($ROOT.'/lib/error.lib.php');

/* Встановлення локалізація і кодування */
header('Content-Type: text/html; charset=utf-8');
setlocale(LC_ALL, 'uk_UA.UTF-8', 'Ukrainian_Ukraine.65001');
ini_set('default_charset','UTF-8');

/* Підключення бібліотек */
include_once($ROOT.'/lib/mysqli.lib.php');
include_once($ROOT.'/lib/common.lib.php');
include_once($ROOT.'/lib/kernel.lib.php');
include_once($ROOT.'/lib/dumper.lib.php');

/* Перевірка підтримки SSL */
Kernel::VerifySSL();

/* Підключення до MySQL-сервера */
$MySQLi = new DB();

/* Підключення активних модулів */
spl_autoload_register(function ($class) use ($ROOT){ 
	$ModuleName = $ROOT."/modules/{$class}.mod.php";
	if(file_exists($ModuleName)){
		include_once($ModuleName); 
	} else {
		trigger_error("Module \"{$class}\" not found!", E_USER_ERROR);
	}
});

/* Валідація сесії */
$ssID = user::VerifySession();

/* Включення буферизації виводу */
//ob_start();

/* Підключення роутера і правил для маршрутизації */
include_once($ROOT.'/lib/router.lib.php');
include_once($ROOT.'/lib/router.rules.lib.php');

/* Форматування і вивід контенту */
/*$tidy = new tidy;
$tidy->parseString(ob_get_clean(), array(), 'utf8');
$tidy->cleanRepair();
ob_end_clean();
echo $tidy;*/

/* Закриття з'єднання з MySQL-сервером*/
$MySQLi->close();

/* Завершення сесії користувача */
//session_destroy();
?>