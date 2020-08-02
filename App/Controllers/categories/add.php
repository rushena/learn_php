<?php 

if (!empty($_POST)) {

	$сategory = Category::getFromPost();

	$is_added = Category::add($сategory);

	if ($is_added) {
		header('Location: /categories/list');
	} else {
		die('error');
	}
}

$smarty->display('categories/add.tpl');