<?php

require 'includes/init.php';

if (isset($_GET['download'])) {
	$type = 'csv';
	if (isset($_GET['type'])) $type = $_GET['type'];
	
	switch ($type){
		case 'csv':
			$csv = $editLite->getCSV();
			header("Content-type: text/csv");  
			header("Cache-Control: no-store, no-cache");  
			header('Content-Disposition: attachment; filename="' . $table . '.csv"');
			die($csv);
			break;
	}
}
$editLite->loadRows();