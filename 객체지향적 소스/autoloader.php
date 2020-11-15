<?php
function autoloader($className) {
	$fileName = str_replace('\\', '/', $className) . '.php';

	$file = $_SERVER['DOCUMENT_ROOT'] . '/wine/dao/' . $fileName;
	
	include $file;
}

spl_autoload_register('autoloader');