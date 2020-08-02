<?php

$id = $_GET["id"] ?? 0;

$result = Product::getByID($id);

if (!empty($_POST)) {

	$editedProduct = Product::getFromPost();

	$is_updated = Product::updateByID($editedProduct['id'], $editedProduct);

	if ($is_updated) {
		header('Location: /products/list');
	} else {
		die('not edited items');
	}
}

$categories = Category::getList();

$smarty->assign('categories', $categories);
$smarty->assign('editedProduct', $result);
$smarty->display('products/edit.tpl');