<?php
class DB{
	var $Handle; // Дескриптор підключення до MySQL серверу
	var $QueryCount = 0; //Кількість запитів за весь сеанс підключення
	
	/* Підключення до MySQL серверу */
	public function __construct(){
		global $cfg;
		$this->Handle = @new mysqli($cfg['mysql']['host'], $cfg['mysql']['user'], $cfg['mysql']['passwd'], $cfg['mysql']['database']);	
		//$this->Handle = new mysqli($cfg['mysql']['host'].":".$cfg['mysql']['port'], $cfg['mysql']['user'], $cfg['mysql']['passwd'], $cfg['mysql']['database']) or die(mysqli_connect_error());	
		if ($this->Handle->connect_error){
			trigger_error("Помилка з'єднання з БД: {$this->Handle->connect_error}", E_USER_ERROR);
		}
		$this->Handle->set_charset($cfg['mysql']['charset']);
	}
	
	/* Запит що повертає результат */
	public function select($Query){
		$this->QueryCount++;
		if($result = $this->Handle->query($Query)){
			return $result;
		}else{
			if($this->Handle->errno){ 
				trigger_error("Помилка в запиті: {$this->Handle->error}", E_USER_ERROR);
			}
		}
	}
	
	/* Запит що виконує процедуру без результату */
	public function query($Query, $ErrorReporting = false){
		$this->QueryCount++;
		if($this->Handle->multi_query($Query)){
			if($this->Handle->affected_rows == -1){
				return false;
			}
			return $this->Handle->affected_rows;
		}else{
			if($ErrorReporting == true && $this->Handle->errno){ 
				trigger_error("Помилка в запиті: {$this->Handle->error}", E_USER_ERROR);
			}
			return false;
		}
	}	
	
	/* Закриття підключення до MySQL серверу */
	public function close(){
		$this->Handle->close();
		unset($this);
	}
}
?>