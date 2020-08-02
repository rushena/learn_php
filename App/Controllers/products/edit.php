<?php

$id = $_GET["id"] ?? 0;

$result = get_product_by_id($connect, $id);

if (!empty($_POST)) {

	$editedProduct = get_products_from_post();

	$is_updated = update_product_by_id($connect, $editedProduct['id'], $editedProduct);

	if ($is_updated) {
		header('Location: /products/list');
	} else {
		die('not edited items');
	}
}

$categories = get_categories_list($connect);

$smarty->assign('categories', $categories);
$smarty->assign('editedProduct', $result);
$smarty->display('products/edit.tpl');