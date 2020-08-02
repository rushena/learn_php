<?php

$id = $_POST['id'] ?? 0;

$is_deleted = Product::deleteByID($id);

if ($is_deleted) {
	header('Location: /products/list');
} else {
	die('error');
}