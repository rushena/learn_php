<?php

$id = $_POST['id'] ?? 0;

$is_deleted = delete_product_by_id($connect, $id);

if ($is_deleted) {
	header('Location: /products/list');
} else {
	die('error');
}