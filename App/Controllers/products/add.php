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

$categories = get_categories_list($connect);

$smarty->assign('categories', $categories);
$smarty->display('products/add.tpl');