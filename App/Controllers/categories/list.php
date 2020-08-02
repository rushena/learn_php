<?php

$smarty->assign('categories', Category::getList());

$smarty->display('categories/index.tpl');