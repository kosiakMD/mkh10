<?php
class icd10{
	/* Головна сторінка */
	public static function main(){
		global $ROOT, $PageTitle, $RouteID, $MySQLi, $ssID, $cfg;
		include_once($ROOT.'/template/icd10.editor.php');
	echo "!";
	}
	
	/* Список сторінок */
	public static function pages(){
		global $ROOT, $PageTitle, $RouteID, $cfg, $MySQLi, $ssID;
		$TableData = "";
		$PagesList = $MySQLi->select("SELECT x.`id`, x.`title`, x.`alias`, LENGTH(x.`html`) as `length`, x.`icon`, y.`login` as `author`, z.`name` as `category`, x.`position`, x.`activity`, x.`visits`, DATE(x.`created`) AS `created`, x.`updated` FROM `{$cfg['mysql']['prefix']}pages` AS x LEFT JOIN `{$cfg['mysql']['prefix']}users` AS y ON x.`author_id` = y.`id` LEFT JOIN `{$cfg['mysql']['prefix']}categories` AS z ON x.`category_id` = z.`id` ORDER BY x.`id` ASC");
		
		if($PagesList->num_rows > 0){
			while($Page = $PagesList->fetch_object()){
				$TableData .= '<tr><td><input type="checkbox" class="to-labelauty-icon" value="'.$Page->id.'"></td><td id="left"><span data-href="manager/content" data-id="'.$Page->id.'" data-status="'.$Page->activity.'" class="page-status label label-'.(($Page->activity == 1) ? 'success">Акт.' : 'danger">Пас.').'</span></td><td><i class="fa fa-'.$Page->icon.'"></i></td><td>'.$Page->id.'</td><td id="left">'.$Page->title.((!is_null($Page->alias)) ? ' <b>['.$Page->alias.']</b>' : '').'</td><td>'.Kernel::MemoryFormating($Page->length).'</td><td>'.$Page->author.'</td><td>'.$Page->visits.'</td><td id="left">'.$Page->category.'</td><td>'.$Page->position.'</td><td>'.$Page->created.'</td><td>'.$Page->updated.'</td><td nowrap><a href="manager/content/'.$Page->id.'" class="btn btn-default btn-xs" title="Для друку" target="_blank"><i class="fa fa-print"></i></a><a href="site/content/'.$Page->id.'" class="btn btn-default btn-xs" title="Попередній перегляд" target="_blank"><i class="fa fa-eye"></i></a><a href="manager/content/edit/'.$Page->id.'" class="btn btn-default btn-xs" title="Редагувати"><i class="fa fa-pencil"></i></a><a href="manager/content/copy/'.$Page->id.'" class="btn btn-default btn-xs" title="Створити копію"><i class="fa fa-copy"></i></a><button type="button" class="btn btn-default btn-xs confirmation" data-toggle="popover" data-popover-href="manager/content/delete/'.$Page->id.'" data-popover-content="Ви впевнені, що хочете видалити цю сторінку?" data-placement="top" title="Видалити"><i class="fa fa-remove"></i></button></td></tr>';
			}
		}else{
			$TableData .= '<tr><td colspan="11">Не знайдено жодної сторінки!</td></tr>';
		}
		include_once($ROOT.'/template/_template.php');
	}
	
	/* Зміна стану контенту */
	public static function contentstatus(){
		global $MySQLi, $cfg;
		Sleep(2);
		$MySQLi->query("UPDATE `{$cfg['mysql']['prefix']}pages` SET `activity` = ".((func_get_arg(0) == 'off') ? '0' : '1')." WHERE `id` = ".func_get_arg(1));
		echo json_encode(array('status' => $MySQLi->select("SELECT `activity` FROM `{$cfg['mysql']['prefix']}pages` WHERE `id` = ".func_get_arg(1)." LIMIT 1")->fetch_object()->activity));
		Kernel::logs('Зміна активності сторінки #'.func_get_arg(1));
	}
	
	/* Редактор сторінок */
	public static function pagecreate(){
		global $ROOT, $PageTitle, $RouteID, $cfg, $MySQLi, $ssID;
		
		if(func_num_args() > 1){
			$PageData = $MySQLi->select("SELECT x.`id`, x.`title`, x.`alias`, x.`html`, x.`icon`, x.`category_id`, x.`activity`, x.`position`, x.`fullscreen`, x.`details` FROM `{$cfg['mysql']['prefix']}pages` AS x WHERE `id` = ".func_get_arg(1))->fetch_object();
		}
		
		$CategoriesData= "";
		$CategoriesList = $MySQLi->select("SELECT x.`id`, x.`name` FROM `{$cfg['mysql']['prefix']}categories` AS x ORDER BY x.`id` ASC");
		
		if($CategoriesList->num_rows > 0){
			while($Category = $CategoriesList->fetch_object()){
				$CategoriesData .= '<option value="'.$Category->id.'"'.((isset($PageData) && $PageData->category_id == $Category->id) ? ' selected' : '').'>'.$Category->name.'</option>';
			}
		}
		include_once($ROOT.'/template/_template.php');
	}
	
	/* Збереження сторінки */
	public static function savepage(){
		global $MySQLi, $cfg, $ssID;
		Sleep(2);
		if(isset($_POST['id'], $_POST['title'], $_POST['category'], $_POST['alias'], $_POST['position'], $_POST['activity'], $_POST['fullscreen'], $_POST['details'], $_POST['icon'], $_POST['content']) && is_numeric($_POST['activity']) && is_numeric($_POST['category']) && is_numeric($_POST['position']) && strlen($_POST['content']) > 8 && strlen($_POST['title']) > 0){
			if($_POST['alias'] != 'NULL'){
				$_POST['alias'] = "'".preg_replace(array('/\s+/', '/[^a-z0-9\_]+/'), array('_', ''), strtolower(((empty($_POST['alias'])) ? Common::Translite($_POST['title']) : $_POST['alias'])))."'";
			}
			if($_POST['id'] == 'NULL'){
				$QueryResult = $MySQLi->query("INSERT INTO `{$cfg['mysql']['prefix']}pages` VALUES({$_POST['id']}, '{$_POST['title']}', {$_POST['alias']}, '{$_POST['content']}', '{$_POST['icon']}', {$ssID->id}, {$_POST['category']}, {$_POST['position']}, {$_POST['activity']}, {$_POST['fullscreen']}, {$_POST['details']}, 0, NOW(), NOW())");
			} else {
				$QueryResult = $MySQLi->query("UPDATE `{$cfg['mysql']['prefix']}pages` SET `title` = '{$_POST['title']}', `alias` = {$_POST['alias']}, `html` = '{$_POST['content']}', `icon` = '{$_POST['icon']}', `category_id` = {$_POST['category']}, `activity` = {$_POST['activity']}, `fullscreen` = {$_POST['fullscreen']}, `details` = {$_POST['details']}, `position` = {$_POST['position']}, `updated` = NOW() WHERE `id` = {$_POST['id']}");
			}
			if($QueryResult > 0){
				if($_POST['id'] == 'NULL'){
					Kernel::logs('Створення сторінки "'.$_POST['title'].'"');
				}else {
					Kernel::logs('Редагування сторінки #'.$_POST['id'].' "'.$_POST['title'].'"');
				}
				echo json_encode(array('status' => 'success', 'description' => 'Сторінку успішно збережено!'));
			} else {
				if($MySQLi->Handle->errno == 1062){
					echo json_encode(array('status' => 'error', 'description' => 'Сторінка з вказаною назвою вже існує в даній категорії!'));
				} else {
					echo json_encode(array('status' => 'error', 'description' => 'При збереженні сторінки виникла помилка: '.$MySQLi->Handle->error));
				}
			}
		}else{
			echo json_encode(array('status' => 'error', 'description' => 'Невірно вказані дані!'));
		}
	}
	
	/* Видалення сторінки */
	public static function contentdelete(){
		global $ROOT, $cfg, $MySQLi, $ssID;
		Sleep(2);
		if(func_num_args() == 2 && is_numeric(func_get_arg(1))){
			if($MySQLi->query("DELETE FROM `{$cfg['mysql']['prefix']}pages` WHERE `id` = ".func_get_arg(1)) > 0){
				echo json_encode(array('status' => 'success', 'description' => 'Сторінку успішно видалено!'));
				Kernel::logs('Видалення сторінки #'.func_get_arg(1));
			} else if($MySQLi->Handle->errno > 0){
				echo json_encode(array('status' => 'error', 'description' => 'При видаленні сторінки виникла помилка #'.$MySQLi->Handle->errno.': '.$MySQLi->Handle->error));
			} else {
				echo json_encode(array('status' => 'error', 'description' => 'Сторінку не видалено!'));
			}
		} else {
			echo json_encode(array('status' => 'error', 'description' => 'Невірно вказані дані!'));
		}
	}
	
	/* Створення копії сторінки */
	public static function pagecopy(){
		global $MySQLi, $cfg;
		$PageDataResult = $MySQLi->select("SELECT * FROM `{$cfg['mysql']['prefix']}pages` WHERE `id` = ".func_get_arg(1));
		if($PageDataResult->num_rows > 0){
			$PageData = $PageDataResult->fetch_assoc();
			$LastCopyName = $MySQLi->select("SELECT `title` FROM `{$cfg['mysql']['prefix']}pages` WHERE `title` LIKE '{$PageData['title']} (%)' ORDER BY `title` DESC LIMIT 1");
			$NewPageNum = (($LastCopyName->num_rows > 0) ? $LastCopyName->fetch_object()->title : 1); $LastCopyName->close();
			if(!is_numeric($NewPageNum)){
				preg_match('/\(([0-9]+)\)$/', $NewPageNum, $parts);
				$NewPageNum = ((count($parts) > 1) ? ($parts[1] + 1) : 1);
			}
			if($MySQLi->query("INSERT INTO `{$cfg['mysql']['prefix']}pages` VALUES(NULL, '{$PageData['title']} ({$NewPageNum})', '{$PageData['alias']}_{$NewPageNum}', '".$MySQLi->Handle->escape_string($PageData['html'])."', '{$PageData['icon']}', {$PageData['author_id']}, {$PageData['category_id']}, {$PageData['position']}, {$PageData['activity']}, {$PageData['fullscreen']}, {$PageData['details']}, 0, NOW(), NOW())") > 0){
				Kernel::logs('Створення копії сторінки #'.$PageData['id'].' "'.$PageData['title'].'"');
			} else {
				echo $MySQLi->Handle->error;
			}
			$PageDataResult->close();
			header('Location: ../../content');
		} else {
			include_once($ROOT.'/template/404.php'); 
		}
	}
	
	/* Список категорій */
	public static function categories(){
		global $ROOT, $PageTitle, $RouteID, $cfg, $MySQLi, $ssID;
		$TableData = "";
		$SortingFields = array('За датою додавання', 'За назвою сторінки', 'За вказаним номером позиції');
		$CategoriesList = $MySQLi->select("SELECT x.`id`, x.`name`, x.`sorting_field`, x.`sorting_type`, y.`login` as `author`, z.`pages`, x.`created`, x.`updated` FROM `{$cfg['mysql']['prefix']}categories` AS x LEFT JOIN `{$cfg['mysql']['prefix']}users` AS y ON x.`author_id` = y.`id` LEFT JOIN (SELECT `category_id` AS `id`, COUNT(*) AS `pages` FROM `{$cfg['mysql']['prefix']}pages` GROUP BY `category_id`) AS z ON z.`id` = x.`id`");
		
		if($CategoriesList->num_rows > 0){
			while($Category = $CategoriesList->fetch_object()){
				$TableData .= '<tr><td><input type="checkbox" class="to-labelauty-icon" value="'.$Category->id.'"></td><td><i class="fa fa-list-alt"></i></td><td>'.$Category->id.'</td><td id="left">'.$Category->name.'</td><td>'.$Category->author.'</td><td>'.((!empty($Category->pages)) ? $Category->pages : '0').'</td><td>'.$Category->created.'</td><td>'.$Category->updated.'</td><td><a href="manager/categories/edit/'.$Category->id.'" class="btn btn-default btn-xs" data-toggle="modal" data-target="#ModalDialog" title="Перейменувати"><i class="fa fa-pencil"></i></a><button type="button" class="btn btn-default btn-xs confirmation" data-toggle="popover" data-popover-href="manager/categories/delete/'.$Category->id.'" data-popover-content="Ви впевнені, що хочете видалити цей розділ і всі сторінки, що до нього входять?" data-placement="top" title="Видалення розділу"><i class="fa fa-remove"></i></button><button type="button" class="btn btn-default btn-xs confirmation" data-toggle="popover" data-popover-href="manager/categories/clear/'.$Category->id.'" data-popover-content="Ви впевнені, що хочете очистити цей розділ?" data-placement="top" title="Очищення розділу"><i class="fa fa-trash"></i></button><button type="button" class="btn btn-default btn-xs" title="'.$SortingFields[$Category->sorting_field-1].'"><i class="fa fa-arrow-'.(($Category->sorting_type == 1) ? 'up' : 'down').'"></i> </button></td></tr>';
			}
		}else{
			$TableData .= '<tr><td colspan="9">Не знайдено жодної категорії!</td></tr>';
		}
		include_once($ROOT.'/template/_template.php');
	}
	
	/* Форма редагування категорії */
	public static function createcategoryform(){
		global $ROOT, $PageTitle, $RouteID, $MySQLi, $cfg, $ssID;
		if(func_num_args() == 2 && is_numeric(func_get_arg(1))){
			$CategoryData = $MySQLi->select("SELECT `id`, `name`, `sorting_field`, `sorting_type` FROM `{$cfg['mysql']['prefix']}categories` WHERE `id` = ".func_get_arg(1));
			if($CategoryData->num_rows > 0){
				$CategoryData = $CategoryData->fetch_object();
			} else {
				unset($CategoryData);
			}
		}
		include_once($ROOT.'/template/manager.categories.edit.modal.php');
	}
	
	/* Створення категорії */
	public static function savecategory(){
		global $ROOT, $cfg, $MySQLi, $ssID;
		Sleep(2);
		if(isset($_POST['NewCategoryName'], $_POST['NewCategorySortField'], $_POST['NewCategorySortType']) && strlen($_POST['NewCategoryName']) > 0 && is_numeric($_POST['NewCategorySortField']) && is_numeric($_POST['NewCategorySortType'])){
			if(isset($_POST['CategoryID']) && is_numeric($_POST['CategoryID']) && $_POST['CategoryID'] > 0){
				$QueryResult = $MySQLi->query("UPDATE `{$cfg['mysql']['prefix']}categories` SET `name` = '{$_POST['NewCategoryName']}', `sorting_field` = {$_POST['NewCategorySortField']}, `sorting_type` = {$_POST['NewCategorySortType']}, `updated` = NOW() WHERE `id` = {$_POST['CategoryID']}");
			} else {
				$QueryResult = $MySQLi->query("INSERT INTO `{$cfg['mysql']['prefix']}categories` VALUES(NULL, '{$_POST['NewCategoryName']}', {$ssID->id}, {$_POST['NewCategorySortField']}, {$_POST['NewCategorySortType']}, NOW(), NOW())");
			}
			if($QueryResult > 0){
				echo json_encode(array('status' => 'success', 'description' => 'Дані успішно збережено!'));
				if(isset($_POST['CategoryID']) && is_numeric($_POST['CategoryID']) && $_POST['CategoryID'] > 0){
					Kernel::logs('Редагування розділу #'.$_POST['CategoryID']);
				} else {
					Kernel::logs('Створення розділу "'.$_POST['NewCategoryName'].'"');
				}
			} else if($MySQLi->Handle->errno == 1062){
				echo json_encode(array('status' => 'error', 'description' => 'Розділ з такою назвою вже існує!'));
			} else {
				echo json_encode(array('status' => 'error', 'description' => 'При збереженні даних виникла помилка #'.$MySQLi->Handle->errno.': '.$MySQLi->Handle->error));
			}
		} else {
			echo json_encode(array('status' => 'error', 'description' => 'Невірно вказані дані!'));
		}
	}
	
	/* Видалення категорії */
	public static function deletecategory(){
		global $ROOT, $cfg, $MySQLi, $ssID;
		Sleep(2);
		if(func_num_args() == 2 && is_numeric(func_get_arg(1))){
			if($MySQLi->query("DELETE FROM `{$cfg['mysql']['prefix']}categories` WHERE `id` = ".func_get_arg(1)) > 0){
				echo json_encode(array('status' => 'success', 'description' => 'Розділ успішно видалено!'));
				Kernel::logs('Видалення розділу #'.func_get_arg(1));
			} else if($MySQLi->Handle->errno > 0){
				echo json_encode(array('status' => 'error', 'description' => 'При видаленні розділу виникла помилка #'.$MySQLi->Handle->errno.': '.$MySQLi->Handle->error));
			} else {
				echo json_encode(array('status' => 'error', 'description' => 'Розділ не видалено!'));
			}
		} else {
			echo json_encode(array('status' => 'error', 'description' => 'Невірно вказані дані!'));
		}
	}
	
	/* Очищення категорії */
	public static function clearcategory(){
		global $ROOT, $cfg, $MySQLi, $ssID;
		Sleep(2);
		if(func_num_args() == 2 && is_numeric(func_get_arg(1))){
			if($MySQLi->query("DELETE FROM `{$cfg['mysql']['prefix']}pages` WHERE `category_id` = ".func_get_arg(1)) > 0){
				echo json_encode(array('status' => 'success', 'description' => 'Розділ успішно очищено!'));
				Kernel::logs('Очищення розділу #'.func_get_arg(1));
			} else if($MySQLi->Handle->errno > 0){
				echo json_encode(array('status' => 'error', 'description' => 'При очищенні розділу виникла помилка #'.$MySQLi->Handle->errno.': '.$MySQLi->Handle->error));
			} else {
				echo json_encode(array('status' => 'error', 'description' => 'Розділ не очищено!'));
			}
		} else {
			echo json_encode(array('status' => 'error', 'description' => 'Невірно вказані дані!'));
		}
	}
	
	/* Отримання списку навігації */
	public static function navigation(){
		global $ROOT, $PageTitle, $RouteID, $cfg, $MySQLi, $ssID;
		$TableData = "";
		$NavList = $MySQLi->select("SELECT x.*, IFNULL(y.`name`, x.`href`) AS `value` FROM `{$cfg['mysql']['prefix']}navigations` AS x LEFT JOIN `{$cfg['mysql']['prefix']}categories` AS y ON x.`href` = y.`id` ORDER BY `position` ASC");
		
		if($NavList->num_rows > 0){
			while($NavItem = $NavList->fetch_object()){
				$TableData .= '<tr><td id="left"><span data-href="manager/navigation" data-id="'.$NavItem->id.'" data-status="'.$NavItem->activity.'" class="page-status label label-'.(($NavItem->activity == 1) ? 'success">Акт.' : 'danger">Пас.').'</span></td><td><i class="fa fa-'.$NavItem->icon.'"></i></td><td>'.$NavItem->id.'</td><td id="left" nowrap>'.$NavItem->title.'</td><td>'.(($NavItem->type == 1) ? 'Посилання' : 'Категорія').'</td><td>'.$NavItem->position.'</td><td id="left" nowrap>'.(($NavItem->blank) ? '<i class="fa fa-reply"></i> ' : '').$NavItem->value.'</td><td>'.$NavItem->updated.'</td><td><a href="manager/navigation/edit/'.$NavItem->id.'" data-toggle="modal" data-target="#ModalDialog" class="btn btn-default btn-xs" title="Редагувати"><i class="fa fa-pencil"></i></a><button type="button" class="btn btn-default btn-xs confirmation" data-toggle="popover" data-popover-href="manager/navigation/delete/'.$NavItem->id.'" data-popover-content="Ви впевнені, що хочете видалити цей пункт навігації?" data-placement="top" title="Видалити"><i class="fa fa-remove"></i></button></td></tr>';
			}
		}else{
			$TableData .= '<tr><td colspan="10">Не знайдено жодного пункту навігації!</td></tr>';
		}
		include_once($ROOT.'/template/_template.php');
	}
	
	/* Форма редагування навігації */
	public static function navigationeditform(){
		global $ROOT, $PageTitle, $RouteID, $cfg, $MySQLi, $ssID;
		if(func_num_args() == 2 && is_numeric(func_get_arg(1))){
			$NavData = $MySQLi->select("SELECT * FROM `{$cfg['mysql']['prefix']}navigations` WHERE `id` = ".func_get_arg(1));
			if($NavData->num_rows == 0){
				include_once($ROOT.'/template/manager.files.notfound.php'); 
				return;
			}
			$NavData = $NavData->fetch_object();
		} else {
			$NewPosition = $MySQLi->select("SELECT (IFNULL(MAX(`position`),0) + 1) AS `new_position` FROM `{$cfg['mysql']['prefix']}navigations`");
			$NewPosition = (($NewPosition->num_rows > 0) ? $NewPosition->fetch_object()->new_position : '');
		}
		$CategoriesData = $MySQLi->select("SELECT `id`, `name` FROM `{$cfg['mysql']['prefix']}categories` ORDER BY `id` ASC");
		$CategoriesList = "";
		while($CategoryData = $CategoriesData->fetch_object()){
			$CategoriesList .= '<option value="'.$CategoryData->id.'"'.((isset($NavData) && $NavData->type == 2 && $NavData->href == $CategoryData->id) ? ' selected' : '').'>'.$CategoryData->name.'</option>';
		}
		include_once($ROOT.'/template/manager.navigation.edit.modal.php');
	}
	
	/* Зміна стану пункту навігації */
	public static function navigationstatus(){
		global $MySQLi, $cfg;
		Sleep(2);
		$MySQLi->query("UPDATE `{$cfg['mysql']['prefix']}navigations` SET `activity` = ".((func_get_arg(0) == 'off') ? '0' : '1').", `updated` = NOW() WHERE `id` = ".func_get_arg(1));
		echo json_encode(array('status' => $MySQLi->select("SELECT `activity` FROM `{$cfg['mysql']['prefix']}navigations` WHERE `id` = ".func_get_arg(1)." LIMIT 1")->fetch_object()->activity));
	}
	
	/* Редагування навігації */
	public static function navigationedit(){
		global $ROOT, $cfg, $MySQLi, $ssID;
		Sleep(2);
		if(isset($_POST['NavName'], $_POST['NavIcon'], $_POST['NavPosition'], $_POST['NavType'], $_POST['NavBlank'], $_POST['NavCategory'], $_POST['NavLink']) && is_numeric($_POST['NavPosition']) && is_numeric($_POST['NavType']) && is_numeric($_POST['NavCategory']) && is_numeric($_POST['NavBlank']) && Kernel::ValidLength($_POST['NavName'], 1, 255)){
			$MySQLi->Handle->multi_query("SET @pos = 0; UPDATE `{$cfg['mysql']['prefix']}navigations` SET `position` = (@pos := @pos + IF(`position` <> {$_POST['NavPosition']}, 1, 2)) ORDER BY `position` ASC");
			$MySQLi->Handle->next_result();
			if(isset($_POST['NavID']) && is_numeric($_POST['NavID']) && $_POST['NavID'] > 0){
				$QueryResult = $MySQLi->query("UPDATE `{$cfg['mysql']['prefix']}navigations` SET `title` = '{$_POST['NavName']}', `position` = {$_POST['NavPosition']}, `type` = {$_POST['NavType']}, `blank` = {$_POST['NavBlank']}, `icon` = '{$_POST['NavIcon']}', `href` = '".(($_POST['NavType'] == 2) ? $_POST['NavCategory'] : $_POST['NavLink'])."', `updated` = NOW() WHERE `id` = {$_POST['NavID']}");
			} else {
				$QueryResult = $MySQLi->query("INSERT INTO `{$cfg['mysql']['prefix']}navigations` VALUES(NULL, '{$_POST['NavName']}', TRUE, {$_POST['NavPosition']}, {$_POST['NavType']}, {$_POST['NavBlank']}, '".(($_POST['NavType'] == 2) ? $_POST['NavCategory'] : $_POST['NavLink'])."', '{$_POST['NavIcon']}', NOW())");
			}
			if($QueryResult > 0){
				echo json_encode(array('status' => 'success', 'description' => 'Дані успішно збережено!'));
				if(isset($_POST['NavID']) && is_numeric($_POST['NavID']) && $_POST['NavID'] > 0){
					Kernel::logs('Редагування пункту навігації #'.$_POST['NavID']);
				} else {
					Kernel::logs('Створення пункту навігації "'.$_POST['NavName'].'"');
				}
			} else if($MySQLi->Handle->errno > 0){
				echo json_encode(array('status' => 'error', 'description' => 'При збереженні даних виникла помилка #'.$MySQLi->Handle->errno.': '.$MySQLi->Handle->error));
			}
		} else {
			echo json_encode(array('status' => 'error', 'description' => 'Невірно вказані дані!'));
		}
	}
	
	/* Видалення пункту навігації */
	public static function navigationdelete(){
		global $ROOT, $cfg, $MySQLi, $ssID;
		Sleep(2);
		if(func_num_args() == 2 && is_numeric(func_get_arg(1))){
			if($MySQLi->query("DELETE FROM `{$cfg['mysql']['prefix']}navigations` WHERE `id` = ".func_get_arg(1)) > 0){
				echo json_encode(array('status' => 'success', 'description' => 'Пункт навігації успішно видалено!'));
				Kernel::logs('Видалення пункту навігації #'.func_get_arg(1));
			} else if($MySQLi->Handle->errno > 0){
				echo json_encode(array('status' => 'error', 'description' => 'При видаленні пункту навігації виникла помилка #'.$MySQLi->Handle->errno.': '.$MySQLi->Handle->error));
			} else {
				echo json_encode(array('status' => 'error', 'description' => 'Розділ не видалено!'));
			}
		} else {
			echo json_encode(array('status' => 'error', 'description' => 'Невірно вказані дані!'));
		}
	}
	
	/* Отримання логів */
	public static function logs(){
		global $ROOT, $PageTitle, $RouteID, $cfg, $MySQLi, $ssID;
		$TableData = "";
		$LogsList = $MySQLi->select("SELECT x.*, y.`login` AS `author` FROM `{$cfg['mysql']['prefix']}logs` AS x LEFT JOIN `{$cfg['mysql']['prefix']}users` AS y ON x.`user_id` = y.`id` ORDER BY `date` DESC LIMIT 0, 1000");
		
		if($LogsList->num_rows > 0){
			while($LogItem = $LogsList->fetch_object()){
				$TableData .= '<tr><td><i class="fa fa-bolt"></i></td><td>'.$LogItem->id.'</td><td id="left">'.$LogItem->action.'</td><td>'.$LogItem->author.'</td><td>'.$LogItem->date.'</td></tr>';
			}
		}else{
			$TableData .= '<tr><td colspan="5">Не знайдено жодного запису в логах!</td></tr>';
		}
		include_once($ROOT.'/template/_template.php');
	}
	
	/* Статистика відвідування */
	public static function stats(){
		global $ROOT, $PageTitle, $RouteID, $cfg, $MySQLi, $ssID;
		$StatsRange = $MySQLi->select("SELECT MIN(`date`) AS `start`, IF(DATE_ADD(MAX(`date`), INTERVAL -1 MONTH) < MIN(`date`), MIN(`date`), DATE_ADD(MAX(`date`), INTERVAL -1 MONTH)) AS `start_value`, MAX(`date`) AS `end` FROM `{$cfg['mysql']['prefix']}stats`")->fetch_object();
		include_once($ROOT.'/template/_template.php');
	}
	
	/* Очищення логів */
	public static function clearlogs(){
		global $MySQLi, $cfg;
		if($MySQLi->query("DELETE FROM `{$cfg['mysql']['prefix']}logs`") > 0){
			echo json_encode(array('status' => 'success', 'description' => 'Логи успішно очищено!'));
		} else {
			echo json_encode(array('status' => 'error', 'description' => 'Не вдалося очистити логи!'));
		}
	}
	
	/* Отримання списку файлів */
	public static function files(){
		global $ROOT, $PageTitle, $RouteID, $MySQLi, $cfg, $ssID;
		$TableData = $PathBreadCrums = "";
		$ManagerPath = implode('/', func_get_args());
		$ManagerPathRegs = func_get_args();
		
		if(!file_exists($ROOT.'/'.$ManagerPath)){ 
			include_once($ROOT.'/template/404.php'); 
			return; 
		}
		
		for($i = 0; $i < count(func_get_args()); $i++){
			if($i == count(func_get_args())-1){
				$PathBreadCrums .= '<li class="active">'.$ManagerPathRegs[$i].'</li>';
				continue;
			}
			$PathBreadCrums .= '<li><a href="manager/'.(($RouteID === 19) ? 'upload' : 'files').'/'.(implode('/', array_slice(func_get_args(), 0, $i+1))).'">'.$ManagerPathRegs[$i].'</a></li>';
		}
	
		if(!empty($ManagerPath)){ $TableData .= '<tr>'.(($RouteID === 19) ? '' : '<td></td>').'<td><i class="fa fa-folder-open"></i></td><td id="left"><a href="manager/'.(($RouteID === 19) ? 'upload' : 'files').((dirname($ManagerPath) != ".") ? '/'.dirname($ManagerPath) : '').'">..</a></td><td></td><td></td><td></td><td></td><td></td>'.(($RouteID === 19) ? '' : '<td></td>').'</tr>'; }
		foreach(glob($ROOT.((sizeof(func_get_args()) > 0) ? '/' : '').$ManagerPath."/*") as $file){
			 if(is_dir($file)){
				$TableData .= '<tr>';
				if($RouteID !== 19){
					$TableData .= '<td><input type="checkbox" class="to-labelauty-icon" value="'.$ManagerPath.((sizeof(func_get_args()) > 0) ? '/' : '').basename(iconv("windows-1251", "UTF-8", $file)).'~"></td>';
				}
				$TableData .= '<td><i class="fa fa-folder-open"></i></td><td id="left"><a href="manager/'.(($RouteID === 19) ? 'upload' : 'files').((sizeof(func_get_args()) > 0) ? '/' : '').$ManagerPath.'/'.basename(iconv("windows-1251", "UTF-8", $file)).'">'.basename(iconv("windows-1251", "UTF-8", $file)).'</a></td><td>Папка</td><td>'.Kernel::FormattedDirectorySize($file).'</td><td>'.Kernel::FileInfo($file).'</td><td>'.date('Y-m-d', filemtime($file)).'</td><td>'.date('H:i:s', filemtime($file)).'</td>';
				if($RouteID !== 19){
					$TableData .= '<td id="left"><!--<button type="button" class="btn btn-default btn-xs" title="Перейменувати"><i class="fa fa-pencil"></i></button>--><button type="button" class="btn btn-default btn-xs confirmation" data-toggle="popover" data-popover-href="manager/files/delete/'.$ManagerPath.((sizeof(func_get_args()) > 0) ? '/' : '').basename(iconv("windows-1251", "UTF-8", $file)).'~" data-popover-content="Ви впевнені, що хочете видалити цю директорію з усім вмістом?" data-placement="top" title="Видалення папки"><i class="fa fa-trash"></i></button><a href="manager/files/perms/'.$ManagerPath.((sizeof(func_get_args()) > 0) ? '/' : '').basename(iconv("windows-1251", "UTF-8", $file)).'~" class="btn btn-default btn-xs" data-toggle="modal" data-target="#ModalDialog" title="Права доступу"><i class="fa fa-cog"></i></a></td>';
				}
				$TableData .= '</tr>';
			 }
		 }
		 
		 if($RouteID === 19){
			 include_once($ROOT.'/template/_template.php');
			 return;
		 }
		
		$fileIcons = array(
			'php,js,css,html' => 'code-o',
			'zip,rar,7z,tar,gz,bz2' => 'zip-o',
			'mp3,wav,ogg' => 'audio-o',
			'avi,mp4,3gp,wmv,flv' => 'video-o',
			'jpg,jpeg,bmp,png,gif,svg,psd,ico' => 'image-o',
			'xls,xlsx,csv,ods' => 'excel-o',
			'doc,docx,odt' => 'word-o',
			'ppt,pptx,odp' => 'powerpoint-o',
			'pdf' => 'pdf-o',
			'txt' => 'text-o'
		);
		
		foreach(glob($ROOT.((sizeof(func_get_args()) > 0) ? '/' : '').$ManagerPath."/*") as $file){
			 if(is_file($file)){
				$TableData .= '<tr><td><input type="checkbox" class="to-labelauty-icon" value="'.$ManagerPath.((sizeof(func_get_args()) > 0) ? '/' : '').basename(iconv("windows-1251", "UTF-8", $file)).'~"></td><td><i class="fa fa-file'.((count($fileIcon = array_values(preg_grep('/'.strtolower(pathinfo($file, PATHINFO_EXTENSION)).'/', array_keys($fileIcons)))) > 0) ? '-'.$fileIcons[$fileIcon[0]] : '-o').'"></i></td><td id="left">'.basename(iconv("windows-1251", "UTF-8", $file)).'</td><td>Файл '.strtoupper(pathinfo($file, PATHINFO_EXTENSION)).'</td><td>'.Kernel::MemoryFormating(filesize($file)).'</td><td>'.Kernel::FileInfo($file).'</td><td>'.date('Y-m-d', filemtime($file)).'</td><td>'.date('H:i:s', filemtime($file)).'</td><td id="left"><!--<button type="button" class="btn btn-default btn-xs" title="Перейменувати"><i class="fa fa-pencil"></i></button>--><button type="button" class="btn btn-default btn-xs confirmation" data-toggle="popover" data-popover-href="manager/files/delete/'.$ManagerPath.((sizeof(func_get_args()) > 0) ? '/' : '').basename(iconv("windows-1251", "UTF-8", $file)).'~" data-popover-content="Ви впевнені, що хочете видалити цей файл?" data-placement="top" title="Видалення файлу"><i class="fa fa-trash"></i></button><a href="manager/files/perms/'.$ManagerPath.((sizeof(func_get_args()) > 0) ? '/' : '').basename(iconv("windows-1251", "UTF-8", $file)).'~" class="btn btn-default btn-xs" data-toggle="modal" data-target="#ModalDialog" title="Права доступу"><i class="fa fa-cog"></i></a><a href="manager/files/sum/'.$ManagerPath.((sizeof(func_get_args()) > 0) ? '/' : '').basename(iconv("windows-1251", "UTF-8", $file)).'~" data-toggle="modal" data-target="#ModalDialog" class="btn btn-default btn-xs" title="Контрольні суми"><i class="fa fa-qrcode"></i></a><a href="manager/files/get/'.$ManagerPath.((sizeof(func_get_args()) > 0) ? '/' : '').basename(iconv("windows-1251", "UTF-8", $file)).'~" class="btn btn-default btn-xs" target="_blank" title="Скачати файл"><i class="fa fa-upload"></i></a>'.((strtolower(pathinfo($file, PATHINFO_EXTENSION)) != "php") ? '<a href="'.$ManagerPath.((sizeof(func_get_args()) > 0) ? '/' : '').basename(iconv("windows-1251", "UTF-8", $file)).'" class="btn btn-default btn-xs" target="_blank" title="Посилання"><i class="fa fa-link"></i></a>' : '').'</td></tr>';
			 }
		}
		include_once($ROOT.'/template/_template.php');
	}
	
	/* Вираховування контрольних сум для файлу */
	public static function sum(){
		global $ROOT;
		$HashData = "";
		$FileName = substr(implode('/', array_slice(func_get_args(), 1)), 0, -1);
		
		if(!file_exists($ROOT.'/'.$FileName)){ include_once($ROOT.'/template/manager.files.notfound.php'); return; }
		
		foreach(array("md5", "sha1", "crc32") as $HashType){
			$HashData .= '<p><b>'.$HashType.':</b> '.hash_file($HashType, $FileName).'</p>';
		}
		include_once($ROOT.'/template/manager.files.sum.php');
	}
	
	/* Скачування файлу з сервера */
	public static function get(){
		global $ROOT;
		$FileName = $ROOT.'/'.substr(implode('/', array_slice(func_get_args(), 1)), 0, -1);
		
		if(!is_file($FileName) || !file_exists($FileName)){ include_once($ROOT.'/template/404.php'); return; }

		$FileData = file_get_contents($FileName);
		
		header('Content-Type: application/x-download');
		header("Content-Description: File Transfer");
		header('Content-Length: '.strlen($FileData));
		header('Content-Disposition: attachment; filename="'.basename($FileName).'"');
		header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
		header('Connection: Keep-Alive');
		header('Expires: 0');
		header('Pragma: no-cache');
		echo $FileData;
		
		Kernel::logs('Скачування файлу "'.Kernel::Escape($FileName).'"');
	}
	
	/* Форма редагування прав доступу */
	public static function perms(){
		global $ROOT;
		$FileName = $ROOT.'/'.substr(implode('/', array_slice(func_get_args(), 1)), 0, -1);
		if(!file_exists($FileName)){ 
			include_once($ROOT.'/template/manager.files.notfound.php'); 
			return; 
		}
		$FileStat = stat($FileName);
		include_once($ROOT.'/template/manager.files.chmod.modal.php');
	}
	
	/* Зміна прав доступу до файлу */
	public static function setperms(){
		global $ROOT, $PageTitle, $RouteID, $MySQLi, $ssID;
		Sleep(2);
		
		if(!isset($_POST['InputFileName'], $_POST['t_total']) || !is_numeric($_POST['t_total'])){
			echo json_encode(array('status' => 'error', 'description' => 'Невірно вказані дані!'));
		}
		
		$FileName = $_POST['InputFileName'];
		$FileMode = '0'.$_POST['t_total'];
		
		if(!file_exists($FileName)){
			echo json_encode(array('status' => 'error', 'description' => 'Об\'єкт <i>"'.$FileName.'"</i> не існує!'));
		} else if(@chmod($FileName, octdec($FileMode))){
			echo json_encode(array('status' => 'success', 'description' => 'Права доступу до об\'єкту <i>"'.$FileName.'"</i> успішно змінено на '.$FileMode .'!'));
			Kernel::logs('Зміна прав доступу до файлу "'.Kernel::Escape($FileName).'" на '.$FileMode);
		} else {
			echo json_encode(array('status' => 'error', 'description' => 'Не вдалося змінити права доступу до об\'єкту <i>"'.$FileName.'"</i>!'));
		}
	}
	
	/* Створення резервної копії БД */
	public static function backup(){
		global $ROOT, $cfg, $PageTitle, $RouteID, $MySQLi, $cfg, $ssID;
		$DumpData = backup_database($cfg['mysql']['host'], $cfg['mysql']['user'], $cfg['mysql']['passwd'], $cfg['mysql']['database']); 
		include_once($ROOT.'/template/_template.php');
		Kernel::logs('Створення резервної копії БД');
	}
	
	/* Скачування резервної копії даних */
	public static function getbackup(){
		global $ROOT, $cfg, $MySQLi, $PageTitle, $RouteID, $ssID;
		backup_database($cfg['mysql']['host'], $cfg['mysql']['user'], $cfg['mysql']['passwd'], $cfg['mysql']['database'], true); 
	}
	
	/* Список резервних копій файлової системи */
	public static function filebackup(){
		global $ROOT, $PageTitle, $RouteID, $MySQLi, $cfg, $ssID;
		$TableData = "";
		$FilesList = glob($ROOT."/tmp/*.zip");
		if(sizeof($FilesList) == 0){ $TableData .= '<tr><td colspan="5">Жодного файлу з резервною копією не знайдено!</td></tr>'; }
		foreach($FilesList as $File){
			$TableData .= '<tr><td><input type="checkbox" class="to-labelauty-icon" value="'.basename($File).'"></td><td><i class="fa fa-file-zip-o"></i></td><td id="left">'.basename($File).'</td><td align="center">'.date('Y-m-d H:i:s', filemtime($File)).'</td><td><button type="button" class="btn btn-default btn-xs confirmation" data-toggle="popover" data-popover-href="manager/files/delete/tmp/'.basename($File).'~" data-popover-content="Ви впевнені, що хочете видалити цей файл?" data-placement="top" title="Видалення файлу"><i class="fa fa-trash"></i></button><a href="manager/files/get/tmp/'.basename($File).'~" class="btn btn-default btn-xs" target="_blank" title="Скачати файл"><i class="fa fa-upload"></i></a></td><tr>';
		}
		include_once($ROOT.'/template/_template.php');
	}
	
	/* Створення резервної копії файлової системи */
	public static function createbackup(){
		global $ROOT, $PageTitle, $RouteID, $MySQLi, $ssID;
		Sleep(2);
		$BackupName = $ROOT.'/tmp/'.date('d-m-Y').'.zip';
		if(file_exists($BackupName)){ @unlink($BackupName); }
		Kernel::Compress($ROOT, $BackupName);
		Kernel::logs('Створення резервної копії файлової системи');
	}
	
	/* Видалення файлу */
	public static function deleteobject(){
		global $ROOT;
		Sleep(2);
		$FileName = $ROOT.'/'.substr(implode('/', array_slice(func_get_args(), 1)), 0, -1);
		
		if(!file_exists($FileName)){ 
			echo json_encode(array('status' => 'error', 'description' => 'Неможливо знайти об\'єкт <i>"'.$FileName.'"</i>!'));
			return;
		}
		if(is_file($FileName)){
			if(@unlink($FileName)){
				echo json_encode(array('status' => 'success', 'description' => 'Файл <i>"'.$FileName.'"</i> успішно видалено!'));
				Kernel::logs('Видалення файлу "'.Kernel::Escape($FileName).'"');
			} else {
				echo json_encode(array('status' => 'error', 'description' => 'Неможливо видалити файл <i>"'.$FileName.'"</i>!'));
			}
		} else if(is_dir($FileName)){
			if(Kernel::RemoveDir($FileName)){
				echo json_encode(array('status' => 'success', 'description' => 'Каталог <i>"'.$FileName.'"</i> успішно видалено!'));
				Kernel::logs('Видалення каталогу "'.Kernel::Escape($FileName).'"');
			} else {
				echo json_encode(array('status' => 'error', 'description' => 'Неможливо видалити каталог <i>"'.$FileName.'"</i>!'));
			}
		}
	}
	
	/* Форма створення нового файлу чи каталогу */
	public static function createform(){
		global $ROOT, $PageTitle, $RouteID, $MySQLi, $ssID;
		$ManagerPath = implode('/', array_slice(func_get_args(), 2));
		$ObjectType = func_get_arg(1);
		include_once($ROOT.'/template/manager.files.create.modal.php');
	}
	
	/* Створення нового файлу */
	public static function createobject(){
		global $ROOT;
		Sleep(2);
		if(isset($_POST['ManagerPath'], $_POST['ObjectType'], $_POST['NewObjectName']) && in_array($_POST['ObjectType'], array('file', 'dir')) && strlen($_POST['NewObjectName']) > 0){
			$FileName = $ROOT.'/'.$_POST['ManagerPath'].((!empty($_POST['ManagerPath'])) ? '/' : '').$_POST['NewObjectName'];

			if(!file_exists(dirname($FileName))){
				echo json_encode(array('status' => 'error', 'description' => 'Шлях до створюваного об\'єкту не існує!'));
			}else if(file_exists($FileName)){
				echo json_encode(array('status' => 'error', 'description' => (($_POST['ObjectType'] == 'file') ? 'Файл' : 'Каталог').' <i>'.$FileName.'</i> вже існує!'));
			} else if(($_POST['ObjectType'] == 'file' && @touch($FileName)) || ($_POST['ObjectType'] =='dir' && @mkdir($FileName))){
				echo json_encode(array('status' => 'success', 'description' => (($_POST['ObjectType'] == 'file') ? 'Файл' : 'Каталог').' <i>'.$FileName.'</i> успішно створено!'));
				Kernel::logs('Створення '.(($_POST['ObjectType'] == 'file') ? 'файлу' : 'каталогу').' "'.Kernel::Escape($FileName).'"');
			} else {
				echo json_encode(array('status' => 'error', 'description' => 'Не вдалося створити '.(($_POST['ObjectType'] == 'file') ? 'файл' : 'каталог').' <i>'.$FileName.'</i>!'));
			}
		} else {
			echo json_encode(array('status' => 'error', 'description' => 'Невірно вказані дані!'));
		}
	}
	
	/* Список користувачів */
	public static function users(){
		global $ROOT, $PageTitle, $RouteID, $MySQLi, $cfg, $ssID;
		$TableData = "";
		$UsersList = $MySQLi->select("SELECT x.`id`, x.`login`, x.`active`, x.`privileges`, y.`date`, INET_NTOA(y.`ip`) as `ip` FROM `{$cfg['mysql']['prefix']}users` AS x LEFT JOIN (SELECT `user_id`, `ip`, MAX(`date`) AS `date` FROM `{$cfg['mysql']['prefix']}logs` GROUP BY `user_id`) AS y ON x.`id` = y.`user_id` WHERE x.`privileges` > 0");
		if($UsersList->num_rows > 0){
			while($User = $UsersList->fetch_object()){
				$TableData .= '<tr><td><i class="fa fa-'.((in_array($User->privileges, array(1, 3, 4))) ? 'user' : 'pencil').((in_array($User->privileges, array(3, 4))) ? '-secret' : '').'"></i></td><td>'.$User->id.'</td><td id="left"><span'.(($User->active) ? '' : ' class="text-muted"').'>'.$User->login.'</span></td><td>'.((!empty($User->{'date'})) ? $User->{'date'} : '-').'</td><td>'.((!empty($User->ip)) ? $User->ip : '-').'</td><td align="left"><div class="btn-group"><button type="button" class="btn btn-default btn-xs'.(($User->privileges == 4) ? ' disabled' : '').' dropdown-toggle" data-toggle="dropdown" title="Привілеї"><span class="caret"></span> <i class="fa fa-star"></i></button><ul class="dropdown-menu pull-right" role="menu"><li'.(($User->privileges == 1) ? ' class="disabled"' : '').'><a href="manager/user/privileges/'.$User->id.'/1"><i class="fa fa-user"></i> Користувач</a></li><li'.(($User->privileges == 2) ? ' class="disabled"' : '').'><a href="manager/user/privileges/'.$User->id.'/2"><i class="fa fa-pencil"></i> Модератор</a></li><li'.(($User->privileges == 3) ? ' class="disabled"' : '').'><a href="manager/user/privileges/'.$User->id.'/3"><i class="fa fa-user-secret"></i> Адміністратор</a></li></ul></div><a href="manager/user/delete/'.$User->id.'" class="btn btn-default btn-xs'.(($User->privileges == 4) ? ' disabled' : '').'" title="Видалити користувача"><i class="fa fa-user-times"></i></a><a href="manager/user/'.(($User->active) ? '' : 'un').'ban/'.$User->id.'" class="btn btn-default btn-xs'.(($User->privileges == 4) ? ' disabled' : '').'" title="'.(($User->active == 1) ? 'За' : 'Роз').'блокувати"><i class="fa fa-thumbs-'.(($User->active == 1) ? 'down' : 'up').'"></i></a></td></tr>';
			}	
		}
		include_once($ROOT.'/template/_template.php');
	}
	
	/* Форма створення профілю */
	public static function createprofileform(){
		global $ROOT, $ssID;
		include_once($ROOT.'/template/manager.users.create.modal.php');
	}
	
	/* Створення користувача */
	public static function usercreate(){
		global $MySQLi, $cfg, $ssID;
		Sleep(2);
		if(isset($_POST['NewLogin'], $_POST['NewPrivileges'], $_POST['NewPassword'], $_POST['NewPasswordConfirm']) && $_POST['NewPassword'] == $_POST['NewPasswordConfirm']){
			if($MySQLi->query("INSERT INTO `{$cfg['mysql']['prefix']}users` VALUES(NULL, '{$_POST['NewLogin']}', MD5('{$_POST['NewPassword']}'), {$_POST['NewPrivileges']}, TRUE, NOW())") > 0){
				echo json_encode(array('status' => 'success', 'description' => 'Обліковий запис збережено!'));
				Kernel::logs('Створення користувача "'.$_POST['NewLogin'].'"');
			} else if($MySQLi->Handle->errno == 1062){
				echo json_encode(array('status' => 'error', 'description' => 'Обліковий запис з таким логіном вже існує!'));
			} else if($MySQLi->Handle->errno > 0){
				echo json_encode(array('status' => 'error', 'description' => 'При збереженні облікового запису виникла помилка #'.$MySQLi->Handle->errno.': '.$MySQLi->Handle->error));
			}
		} else {
			echo json_encode(array('status' => 'error', 'description' => 'Невірно вказані дані!'));
		}
	}

	/* Отримання завантажуваного файлу */
	public static function uploadhandler(){
		global $ROOT;
		$FileDir = $ROOT.'/'.implode('/', array_slice(func_get_args(), 1));
		if(file_exists($FileDir)){
			if(isset($_FILES['my_file'])){
				for($i = 0; $i < sizeof($_FILES['my_file']['name']); $i++){
					if (is_uploaded_file($_FILES['my_file']['tmp_name'][$i])){
						move_uploaded_file($_FILES['my_file']["tmp_name"][$i], $FileDir.$_FILES['my_file']["name"][$i]);
						Kernel::logs('Завантаження файлу "'.Kernel::Escape($FileDir.$_FILES['my_file']["name"][$i]).'"');
					}
				}
			}
			echo '{}';
		}else{
			echo '{"response":"Вхідний каталог не знайдено!"}';
		}
	}
	
	/*Видача даних про відвідування */
	public static function getvisits(){
		global $MySQLi, $cfg;
		Sleep(1);
		if(isset($_POST['startDate'], $_POST['endDate']) && Common::date_valid($_POST['startDate']) && Common::date_valid($_POST['endDate'])){
			echo json_encode($MySQLi->select("SELECT `count` AS `visits`, `date` FROM `{$cfg['mysql']['prefix']}stats` WHERE `date` >= '{$_POST['startDate']}' AND `date` <= '{$_POST['endDate']}' ORDER BY `date` DESC")->fetch_all(MYSQLI_ASSOC));
		} else {
			echo json_encode($MySQLi->select("SELECT `count` AS `visits`, `date` FROM `{$cfg['mysql']['prefix']}stats` ORDER BY `date` DESC LIMIT 0, 30")->fetch_all(MYSQLI_ASSOC));
		}
	}
	
	/* Отримання інформацію профілю */
	public static function getprofile(){
		global $ROOT, $ssID;
		include_once($ROOT.'/template/manager.profile.modal.php');
	}
	
	/* Перегляд сторінки */
	public static function generatepage(){
		global $ROOT, $MySQLi, $cfg, $PageTitle;
		if(is_numeric(func_get_arg(0))){
			$PageHTML = $MySQLi->select("SELECT `html`, `title` FROM `{$cfg['mysql']['prefix']}pages` WHERE `id` = ".func_get_arg(0)." AND `activity` = TRUE");
			if($PageHTML->num_rows > 0){
				$PageHTML = $PageHTML->fetch_object();
				$PageTitle = $PageHTML->title;
				$PageHTML = html_entity_decode($PageHTML->html);
				
				self::insertDocuments($PageHTML);
				
				//echo json_encode(array('status' => 'success', 'html' => $PageHTML, 'title' => $PageTitle));
				echo $PageHTML;
				$MySQLi->query("UPDATE `{$cfg['mysql']['prefix']}pages` SET `visits` = `visits` + 1 WHERE `id` = ".func_get_arg(0));
			} else {
				include_once($ROOT.'/template/404.php'); 
				return; 
			}
		} else {
			include_once($ROOT.'/template/404.php'); 
			return; 
		}
	}
	
	/* Вставка документу в сторінку */
	public static function insertDocuments(&$PageHTML){
		$PageHTML = preg_replace('/\[doc\=(.*?)\]/', '<a href="$1" class="btn btn-default" style="margin-bottom: 10px" target="_blank"><i class="fa fa-download"></i> Завантажити</a><a href="$1" class="embed hidden"></a>', $PageHTML);
	}
	
	/* Зворотній зв'язок */
	public static function feedback(){
		global $MySQLi, $cfg;
		Sleep(2);
		if(isset($_POST['UserName'], $_POST['UserEmail'], $_POST['UserMessage'], $_POST['UserCaptcha'])){
			if(!Kernel::ValidLength($_POST['UserName'], 1, 50)){
				echo json_encode(array('status' => 'error', 'description' => 'ПІБ має бути довжиною до 50 символів!'));
			} else if(!filter_var($_POST['UserEmail'], FILTER_VALIDATE_EMAIL)){
				echo json_encode(array('status' => 'error', 'description' => 'Невалідний email!'));
			} else if(!Kernel::ValidLength($_POST['UserMessage'], 10, 100)){
				echo json_encode(array('status' => 'error', 'description' => 'Повідомлення має бути довжиною від 10 до 100 знаків!'));
			} else if($_POST['UserCaptcha'] != $_SESSION['code']){
				echo json_encode(array('status' => 'error', 'description' => 'Неправильно введений код з картинки!'));
			} else {
				if($MySQLi->query("INSERT INTO `{$cfg['mysql']['prefix']}messages` VALUES(NULL, '".Kernel::Escape($_POST['UserName'])."', '".Kernel::Escape($_POST['UserEmail'])."', '".Kernel::Escape($_POST['UserMessage'])."', INET_ATON('".Kernel::UserIP()."'), TRUE, NOW())") > 0){
					echo json_encode(array('status' => 'success', 'description' => 'Ваше повідомлення надіслано адміністратору!'));
				} else if($MySQLi->Handle->errno > 0){
					echo json_encode(array('status' => 'error', 'description' => 'При надсиланні повідомлення виникла помилка!'));
				}
			}
		} else {
			echo json_encode(array('status' => 'error', 'description' => 'Невірно вказані дані!'));
		}
	}
	
	/* Отримання кількості повідомленнь */
	public static function newmessages(){
		global $MySQLi, $cfg;
		return $MySQLi->select("SELECT IF(COUNT(*) > 0,COUNT(*),'') AS `messages` FROM `{$cfg['mysql']['prefix']}messages` WHERE `active` = TRUE")->fetch_object()->messages;
	}
	
	/* Сторінка з повідомленнями */
	public static function messages(){
		global $ROOT, $PageTitle, $RouteID, $MySQLi, $ssID, $cfg;
		include_once($ROOT.'/template/_template.php');
	}
	
	/* Список повідомлень */
	public static function getmessages(){
		global $MySQLi, $cfg;
		Sleep(1);
		$MessagesText = $NewMessagesCount = "";
		$MessagesData = $MySQLi->select("SELECT *, INET_NTOA(`ip`) AS `ip` FROM `{$cfg['mysql']['prefix']}messages` ORDER BY `date` DESC");
		if($MessagesData->num_rows > 0){
			while($Message = $MessagesData->fetch_object()){
				$MessagesText .= '<div class="bs-callout '.(($Message->active) ? 'bs-callout-info ' : '').'message" data-id="'.$Message->id.'">Від: <b>'.$Message->username.'</b> ['.$Message->email.' : '.$Message->ip.']<button type="button" class="delete-message close" title="Видалити">&times;</button><br>Коли: <i>'.$Message->date.'</i><div class="divider"></div>'.$Message->message.'</div>';
				if($Message->active){ 
					if(empty($NewMessagesCount)){ $NewMessagesCount = 0; }
					$NewMessagesCount++; 
				}
			}
			$MySQLi->query("UPDATE `{$cfg['mysql']['prefix']}messages` SET `active` = FALSE");
			echo json_encode(array('count' => $NewMessagesCount, 'text' => $MessagesText));
		} else {
			echo json_encode(array('count' => '', 'text' => 'Немає нових повідомлень...'));
		}
	}
	
	/* Видалення повідомлення */
	public static function deletemessage(){
		global $MySQLi, $cfg;
		Sleep(1);
		if($MySQLi->query("DELETE FROM `{$cfg['mysql']['prefix']}messages` WHERE `id` = ".func_get_arg(2)) > 0){
			echo json_encode(array('status' => 'success'));
		} else {
			echo json_encode(array('status' => 'error'));
		}
	}
	
	/* Календар подій */
	public static function events(){
		global $ROOT, $PageTitle, $RouteID, $MySQLi, $ssID, $cfg;
		$EventsData = "'null'";
		$ColorPalette = array('#d9534f', '#f0ad4e', '#428bca', '#5bc0de', '#5cb85c', '#8f8f8f');
		$EventsList = $MySQLi->select("(SELECT `id`, `description` AS `title`, `date` AS `start`, `level` AS `color`, 1 AS `allowed` FROM `{$cfg['mysql']['prefix']}events`)");
		if($EventsList->num_rows > 0){
			$EventsList = $EventsList->fetch_all(MYSQLI_ASSOC);
			array_walk($EventsList, function(&$Item) use ($ColorPalette){ $Item['color'] = $ColorPalette[$Item['color']-1]; });
			$EventsData = json_encode($EventsList);
		}
		include_once($ROOT.'/template/_template.php');
	}
	
	/* Форма додавання події */
	public static function addeventsform(){
		global $ROOT, $MySQLi, $cfg;
		if(func_num_args() == 2 && is_numeric(func_get_arg(1))){
			$EventData = $MySQLi->select("SELECT `id`, `description`, `level`, `date` FROM `{$cfg['mysql']['prefix']}events` WHERE `id` = ".func_get_arg(1)." LIMIT 1");
			if($EventData->num_rows > 0){ $EventData = $EventData->fetch_object(); }
		}
		include_once($ROOT.'/template/manager.events.edit.modal.php');
	}
	
	/* Збереження події */
	public static function saveevent(){
		global $ROOT, $MySQLi, $ssID, $cfg;
		if(isset($_POST['NewEventName'], $_POST['NewEventDate'], $_POST['NewEventLevel']) && is_numeric($_POST['NewEventLevel']) && strlen($_POST['NewEventName']) < 256){
			if(isset($_POST['EventID']) && is_numeric($_POST['EventID']) && $_POST['EventID'] > 0){
				$QueryResult = $MySQLi->query("UPDATE `{$cfg['mysql']['prefix']}events` SET `description` = '{$_POST['NewEventName']}', `level` = {$_POST['NewEventLevel']}, `date` = '{$_POST['NewEventDate']}' WHERE `id` = {$_POST['EventID']}");
			} else {
				$QueryResult = $MySQLi->query("INSERT INTO `{$cfg['mysql']['prefix']}events` VALUES(NULL, '{$_POST['NewEventName']}', {$_POST['NewEventLevel']}, {$ssID->id}, '{$_POST['NewEventDate']}')");
			}
			if($QueryResult > 0){
				echo json_encode(array('status' => 'success', 'description' => 'Дані успішно збережено!'));
				if(isset($_POST['EventID']) && is_numeric($_POST['EventID']) && $_POST['EventID'] > 0){
					Kernel::logs('Редагування події #'.$_POST['EventID']);
				} else {
					Kernel::logs('Створення події "'.$_POST['NewEventName'].'" '.$_POST['NewEventDate']);
				}
			} else {
				echo json_encode(array('status' => 'error', 'description' => 'Не вдалося зберегти подію!'));
			}
		} else {
			echo json_encode(array('status' => 'error', 'description' => 'Невірно вказані дані!'));
		}
	}
	
	/* Видалення події */
	public static function deleteevent(){
		global $MySQLi, $ssID, $cfg;
		$MySQLi->query("DELETE FROM `{$cfg['mysql']['prefix']}events` WHERE `id` = ".func_get_arg(1));
		Kernel::logs('Видалення події #'.func_get_arg(1));
		header("Location: ../../events");
	}
}
?>