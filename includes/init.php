<?php


require_once 'config.db.php';
require_once 'ezSQL/shared/ez_sql_core.php';
require_once 'ezSQL/mysql/ez_sql_mysql.php';
require_once 'classes/EditLite.php';

// Connect to Database
$db = new ezSQL_mysql($dbConfig['DB_USER'],
                      $dbConfig['DB_PASS'],
                      $dbConfig['DB'],
                      $dbConfig['SERVER']);

define('EL_DATABASE', $dbConfig['DB']);

// destroy db login info
unset($dbConfig);


$tables = EditLite::getTables();
$colName = 'Tables_in_' . EL_DATABASE;

if (isset($_GET['table'])) $table = $_GET['table'];
else $table = $tables[0]->$colName;

$editLite = new EditLite($table);
