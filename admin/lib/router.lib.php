<?php
class Router{
	/* Контроллер, функція і набір правил маршрутизації */
	var $Controller;
	var $Action;
	var $Rules = array();
	
	/* Додавання правил */
	public function add($Rule){
		array_push($this->Rules, $Rule);
	}
	
	/* Запуск роутера */
	public function get(){
		global $ssID, $URL, $PageTitle, $RouteID, $siteCfg;		
		$Params = array();
		$URL = ((isset($_GET['url'])) ? $_GET['url'] : 'manager');
		foreach($this->Rules as $Rule){
			$RuleURLpattern = '/^'.str_replace(array("/", "_"), array("\/", "\_"), $Rule['url']).'$/i';
			if(preg_match($RuleURLpattern, $URL)){
				$Parts = explode('/', $URL);
				$this->Controller = $Rule['controller'];
				$this->Action = $Rule['action'];
				$PageTitle = $Rule['title'];
				$RouteID = $Rule['routeID'];
				$Params = array_slice($Parts, 2);
				
				if($Rule['privileges'] != null){
					if($ssID != null){
						if(!is_array($Rule) || !in_array($ssID->privileges, $Rule['privileges'])){ $this->fail(); }
					}else{
						list($PageTitle, $RouteID, $this->Controller, $this->Action, $Params[0]) = array('', $siteCfg['site']['mainPageID'], 'site', 'page', 1);
					}
				}else{
					if($ssID != null && $ssID->privileges > 0){ $this->fail(); }
				}
				break;
			}else{ $this->fail(); }
		}
		
		if(!class_exists($this->Controller) || !method_exists($this->Controller, $this->Action)){ $this->fail(); }
		if(!forward_static_call_array(array($this->Controller, $this->Action), array_map('Kernel::Filter', $Params))){ return false; }
	}
	
	/* Помилка */
	private function fail(){
		global $PageTitle;
		$this->Controller = 'error';
		$this->Action = '_404';
	}
	
	/* Закриття роутера */
	public function destroy(){
		unset($this);
	}
}
?>