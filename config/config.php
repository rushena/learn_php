<?php 

require_once __DIR__ . '/../libs/Smarty/Smarty.class.php';
require_once __DIR__ . '/../App/Db.php';
require_once __DIR__ . '/../App/Product.php';
require_once __DIR__ . '/../App/Category.php';

$smarty = new Smarty();
$smarty->compile_dir = __DIR__ . '/../var/compile';
$smarty->cache_dir = __DIR__ . '/../var/cache';
$smarty->template_dir = __DIR__ . '/../templates';

function connect ($host, $user, $password, $database) {
	$connect = mysqli_connect($host, $user, $password, $database);

	if( mysqli_connect_errno() ) {

		var_dump(mysqli_connect_error());

		exit;
	}

	mysqli_set_charset($connect, 'utf8');

	return $connect;
}

$connect = connect('localhost', 'root', 'password', 'shop');

function query ($connect, $query) {
	$result = mysqli_query($connect, $query);

	if (mysqli_errno($connect)) {
		var_dump(mysqli_error($connect));
		exit;
	}

	return $result;
}