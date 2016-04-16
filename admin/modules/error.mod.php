<?php
class error{
	/* Помилка 404 */
	public static function _404(){
		global $ROOT, $PageTitle;
		include($ROOT.'/template/404.php');
	}
}
?>