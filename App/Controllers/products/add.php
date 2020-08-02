<?php 

if (!empty($_POST)) {
	
	$product = Product::getFromPost();

	$is_added = Product::add($product);

	if ($is_added) {
		header('Location: /products/list');
	} else {
		die('error');
	}
}

$categories = Category::getList();

$smarty->assign('categories', $categories);
$smarty->display('products/add.tpl');