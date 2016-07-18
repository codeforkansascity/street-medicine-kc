<?php
require 'variables.php';
//IMPORT POST/GET VARIABLES
if ($_REQUEST) {
	foreach ($_REQUEST as $key => $value) {
		$$key = $value;
	}
}
if ($_FILES) {
	foreach ($_FILES as $key => $value) {
		$$key = $_FILES[$key]['tmp_name'];
	}
}
$config = parse_ini_file('dbconfig.ini');
// var_dump($config);
spl_autoload_register(function ($class_name) {
	include 'phpclasses/' . $class_name . '.class.php';
});
?>
