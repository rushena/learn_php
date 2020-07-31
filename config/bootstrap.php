<?php

require_once 'config.php';

$path_info = $_SERVER['PATH_INFO'];

if ($path_info[strlen($path_info) - 1] === '/') {
	$path_info .= 'list';
}


$controller_path = $_SERVER['DOCUMENT_ROOT'] . '/../App/Controllers' . $path_info . '.php';


if (file_exists($controller_path)) {
	require_once $controller_path;
} else {
	$smarty->display('404.tpl');
}

