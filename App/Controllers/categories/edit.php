<?php

$id = $_GET["id"] ?? 0;

$result = Category::getByID($id);

if (!empty($_POST)) {

	$editedCategory = Category::getFromPost();

	$is_updated = Category::updateByID($editedCategory['id'], $editedCategory);

	if ($is_updated) {
		header('Location: /categories/list');
	} else {
		die('not edited items');
	}
}

$smarty->assign('editedCategory', $result);
$smarty->display('categories/edit.tpl');