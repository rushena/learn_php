<?php

$id = (int) $_GET["id"] ?? 0;

$products = Product::getListByCategoryID($id);
$currentCategory = Category::getByID($id);

$smarty->assign('products', $products);
$smarty->assign('current_category', $currentCategory);
$smarty->display('categories/view.tpl');