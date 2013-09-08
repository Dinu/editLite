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

if (isset($_GET['delete'])) {
	$key = EditLite::safeText($_GET['delete']);
	if ($editLite->delete($key))
		$alert = '<div class="alert alert-success">Row deleted!</div>';
	else 
		$alert = '<div class="alert alert-danger"><b>Oops!</b> Something went wrong while deleting this record...</div>';;
	
}
$editLite->loadRows();