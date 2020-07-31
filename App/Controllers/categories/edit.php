<?php

$id = $_GET["id"] ?? 0;

$result = get_category_by_id($connect, $id);

if (!empty($_POST)) {

	$editedCategory = get_category_from_post();

	$is_updated = update_category_by_id($connect, $editedCategory['id'], $editedCategory);

	if ($is_updated) {
		header('Location: /categories/list');
	} else {
		die('not edited items');
	}
}

$smarty->assign('editedCategory', $result);
$smarty->display('categories/edit.tpl');