<?php 

if (!empty($_POST)) {

	$сategory = get_category_from_post();

	$is_added = add_category($connect, $сategory);

	if ($is_added) {
		header('Location: /categories/list');
	} else {
		die('error');
	}
}

$smarty->display('categories/add.tpl');