<?php

$current_page = $_GET['p'] ?? 1;
$products_count = get_products_list_count($connect);
$limit = 10;
$offset = ($current_page - 1) * $limit;
$pages_count = ceil($products_count / $limit);

$smarty->assign('products', get_products_list($connect, $limit, $offset));
$smarty->assign('pages_count', $pages_count);
$smarty->display('products/index.tpl');