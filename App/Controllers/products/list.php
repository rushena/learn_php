<?php

$smarty->assign('products', get_products_list($connect));

$smarty->display('products/index.tpl');