<?php

$smarty->assign('categories', get_categories_list($connect));

$smarty->display('categories/index.tpl');