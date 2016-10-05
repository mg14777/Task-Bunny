<?php
function loadClass($class) {
	require './class/' . $class . '.class.php';
}

spl_autoload_register('loadClass');
$db = DBFactory::getPgsqlConnexion();
$error = array();
$success = array();