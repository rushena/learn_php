<?php 

if (!empty($_POST)) {

	$product = get_products_from_post();

	$is_added = add_product($connect, $product);

	if ($is_added) {
		header('Location: /products/list');
	} else {
		die('error');
	}
}

$smarty->display('products/add.tpl');