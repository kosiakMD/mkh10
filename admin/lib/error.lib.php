<?php
/* Відображення помилок */
error_reporting(E_ALL);
ini_set("display_errors", 1); 
ini_set('display_startup_errors', 1);
set_error_handler('ErrorReporting');

/* Запис помилок в лог */
function ErrorLog($error_msg){
	$ErrorLogFile = fopen($GLOBALS['ROOT']."/logs/error.log", 'a');
	fwrite($ErrorLogFile, $error_msg.PHP_EOL);
	fclose($ErrorLogFile);
}

/* Обробка помилок виконання */
function ErrorReporting($errno, $errstr, $errfile, $errline){
	$date = date('Y-m-d H:i:s');
	if(!(error_reporting() & $errno)){ return; }
	ErrorLog("{$date} Помилка #{$errno}: `{$errstr}` в файлі {$errfile}, стрічка {$errline}.");
	if($GLOBALS['cfg']['system']['show_errors'] == 'true'){
		die("<b>Помилка [#{$errno}]: </b> `{$errstr}` в файлі <b>{$errfile}</b>, стрічка {$errline}.<br />\n");
	}
	return true;
}
?>