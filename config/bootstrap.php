<?php

use App\CategoryService;
use App\Renderer;

require_once 'config.php';

$categoryService = new CategoryService();
$categories = $categoryService->getList();
Renderer::getSmarty()->assign('categories', $categories);

$dispatcher = new App\Router\Dispatcher();

$dispatcher->dispatch();


//$is_index = substr($url, -1) == '/';
//if ($is_index) {
//	$url .= 'list';
//}
//
//$controller_path = $_SERVER['DOCUMENT_ROOT'] . '/../App/Controllers' . $path_info . '.php';