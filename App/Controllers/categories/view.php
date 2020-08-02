<?php

$id = (int) $_GET["id"] ?? 0;

$products = get_products_list_by_category_id($connect, $id);
$currentCategory = get_category_by_id($connect, $id);

$smarty->assign('products', $products);
$smarty->assign('current_category', $currentCategory);
$smarty->display('categories/view.tpl');