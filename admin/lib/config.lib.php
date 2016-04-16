<?php
class Config{
	/* Шлях до директорії з конфігураціями */
	public static $configDirPath;
	
	/* Читання файлу конфігурацій */
	public static function load($configFile, $Format = 'array'){
		$configFile = pathinfo($configFile, PATHINFO_FILENAME);
		if(!file_exists(self::$configDirPath.$configFile.'.json')) trigger_error('config file "'.$configFile.'.json" not found!', E_USER_ERROR);
		if(!($configData = file_get_contents(self::$configDirPath.$configFile.'.json'))) trigger_error('can\'t read config file!', E_USER_ERROR);
		if(!($configData = json_decode($configData, (($Format == "array") ? true : false)))) trigger_error('can\'t parse config file: '.json_last_error_msg(), E_USER_ERROR);
		return $configData;
	}
	
	/* Запис конфігурацій в файл */
	public static function save($configFile, $configData){
		$configFile = pathinfo($configFile, PATHINFO_FILENAME);
		if(!is_array($configData)) trigger_error('Config::save() expects parameter 2 to be array, '.gettype($configData).' given', E_USER_WARNING);
		if(!($configData = json_encode($configData)))	trigger_error('can\'t parse input data!', E_USER_ERROR);
		if(file_put_contents(self::$configDirPath.$configFile.'.json') === false) trigger_error('can\'t create config file!', E_USER_ERROR);
		return true;
	}
}
Config::$configDirPath = $ROOT.'/config/';
?>