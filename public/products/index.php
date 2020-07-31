<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/../config/config.php';

$query = "SELECT * from `products`";
$request = query($connect, $query); 

$productsList = [];

while ($row = mysqli_fetch_assoc($request)) {

	$productsList[] = $row;
}

$smarty->assign('products', $productsList);

$smarty->display('products/index.tpl');