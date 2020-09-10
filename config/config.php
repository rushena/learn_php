<?php 

require_once __DIR__ . '/../vendor/autoload.php';

define('APP_DIR', realpath(__DIR__ . '/../'));
define('APP_PUBLIC_DIR', APP_DIR . '/public');
define('APP_UPLOAD_DIR', APP_PUBLIC_DIR . '/uploads');
define('APP_UPLOAD_PRODUCTS_DIR', APP_UPLOAD_DIR . '/products');

if (!file_exists(APP_UPLOAD_PRODUCTS_DIR)) {
	mkdir(APP_UPLOAD_PRODUCTS_DIR);
}