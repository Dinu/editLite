<?php

require 'includes/init.php';

if (isset($_GET['table'])) {
    
	$key = '';
	if (isset($_GET['row'])) $key = editLite::safeText($_GET['row']);
    
    if (isset($_POST['save'])) {
        if ($editLite->saveEdits($key)) {
            $alert = '<div class="alert alert-success">Row saved!</div>';
        } else {
            $alert = '<div class="alert alert-danger">Oop! Something went wrong while saving your record!</div>';
        }
    }
    
	$row = $editLite->getRow($key);
    
} else die(header('location: index.php'));