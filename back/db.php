<?php

	// require('phpQuery/phpQuery.php');
	$json_file = json_decode( file_get_contents('../public/db/blocks.json') );
	
	//$data = json_decode($json_file);
	// print_r( $json_file );
	foreach ($json_file as $block => $val) {
		echo $val->label;
		echo '\r\n';
	}

?>