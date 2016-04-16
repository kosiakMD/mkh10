<?php 
class site{
	/* Генерація сторінки */
	public static function page(){
		global $ROOT, $MySQLi, $cfg, $siteCfg, $StudentSSID;
		if(func_num_args() == 1){
			$PageID = ((is_numeric(func_get_arg(0))) ? func_get_arg(0) : self::getPageID(func_get_arg(0)));
			$Page = self::getPage($PageID);
			self::updateVisits($PageID);
			$PagesList = self::pagesList($Page['category_id']);
			$PageNav = self::generateNav();
			$MetaData = self::generateMeta();
			include_once($ROOT.'/template/site.template.php'); 
		} else {
			return false;
		}
	}
	
	/* Генерація мета-інформації */
	public static function generateMeta(){
		global $siteCfg;
		$MetaInfo = "";
		if(array_key_exists('allow-cache', $siteCfg['site']) && $siteCfg['site']['allow-cache'] == 'true'){
			$MetaInfo .= '<meta http-equiv="pragma" content="no-cache">'.PHP_EOL;
		}
		foreach($siteCfg['site']['meta'] as $tag){
			$MetaInfo .=  '	<meta';
			foreach($tag as $param => $value){
				$MetaInfo .= ' '.$param.'="'.$value.'"';
			}
			$MetaInfo .= '>'.PHP_EOL;
		}
		return $MetaInfo;
	}
	
	/* Видача списку сторінок */
	private static function pagesList($CategoryID){
		global $MySQLi, $cfg, $siteCfg;
		return $MySQLi->select("SELECT `title`, CONCAT('site/content/', IFNULL(`alias`, `id`)) AS `href`, `icon` FROM `{$cfg['mysql']['prefix']}pages` WHERE `category_id` = {$CategoryID} AND `activity` = TRUE AND `id` <> ".$siteCfg['site']['mainPageID']."")->fetch_all(MYSQLI_ASSOC);
	}
	
	/* Генерація меню */
	public static function generateNav(){
		global $MySQLi, $cfg;
		$NavHTML = "";
		$NavData = $MySQLi->select("SELECT * FROM `{$cfg['mysql']['prefix']}navigations` WHERE `activity` = TRUE ORDER BY `position` ASC");
		if($NavData->num_rows > 0){
			while($NavItem = $NavData->fetch_object()){
				switch($NavItem->type){
					case 1:
					$NavHTML .= self::SimpleMenuItem($NavItem);
					break;
					
					case 2:
					$NavHTML .= self::DropdownMenuItem($NavItem);
					break;
				}
			}
		}
		return $NavHTML;
	}
	
	/* Простий пункт меню */
	private static function SimpleMenuItem($NavItem){
		return '<a href="'.$NavItem->href.'"'.(($NavItem->blank) ? ' target="_blank"' : '').'><i class="fa fa-'.$NavItem->icon.'"></i> '.$NavItem->title.'</a>';
	}
	
	/* Випадаюче меню */
	private static function DropdownMenuItem($NavItem){
		global $MySQLi, $cfg;
		$MenuItemHTML = '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-'.$NavItem->icon.'"></i> '.$NavItem->title.'</a><ul class="dropdown-menu">';
		$MenuItemData = $MySQLi->select("SELECT `id`, `title` FROM `{$cfg['mysql']['prefix']}pages` WHERE `category_id` = ".$NavItem->href." AND `activity` = TRUE");
		if($MenuItemData->num_rows){
			while($MenuItem = $MenuItemData->fetch_object()){
				$MenuItemHTML .= '<li><a href="site/content/'.$MenuItem->id.'">'.$MenuItem->title.'</a></li>';
			}
		}
		$MenuItemHTML .= '</ul></li>';
		return $MenuItemHTML;
	}
	
	/* Видача сторінки */
	private static function getPage($PageID){
		global $MySQLi, $cfg;
		$PageData = $MySQLi->select("SELECT x.`id`, x.`title`, x.`html`, z.`login` AS `author`, x.`category_id`, y.`name` AS `category`, x.`fullscreen`, x.`details`, x.`visits`, x.`created` FROM `{$cfg['mysql']['prefix']}pages` AS x LEFT JOIN `{$cfg['mysql']['prefix']}categories` AS y ON x.`category_id` = y.`id` LEFT JOIN `{$cfg['mysql']['prefix']}users` AS z ON x.`author_id` = z.`id` WHERE x.`id` = {$PageID} AND x.`activity` = TRUE");
		if($PageData->num_rows > 0){
			$PageData = $PageData->fetch_assoc();
			self::preparePage($PageData['html']);
			return $PageData;
		} else {
			return array('id' => '0', 'title' => 'Помилка 404', 'html' => 'Сторінку не знайдено!', 'category_id' => '0', 'category' => '', 'fullscreen' => null, 'details' => null);
		}
	}
	
	/* Обробка сторінки */
	private static function preparePage(&$PageHTML){
		$PageHTML = html_entity_decode($PageHTML);
		manager::insertDocuments($PageHTML);
	}
	
	/* Оновити кількість переглядів */
	private static function updateVisits($PageID){
		global $MySQLi, $cfg;
		$MySQLi->query("UPDATE `{$cfg['mysql']['prefix']}pages` SET `visits` = `visits` + 1 WHERE `id` = {$PageID}");
	}
	
	/* Отримати ID сторінки за аліасом */
	private static function getPageID($PageAlias){
		global $MySQLi, $cfg;
		$PageData = $MySQLi->select("SELECT `id` FROM `{$cfg['mysql']['prefix']}pages` WHERE `alias` = '{$PageAlias}' LIMIT 1");
		return (($PageData->num_rows > 0) ? $PageData->fetch_object()->id : -1);
	}
}
?>