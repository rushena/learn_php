<?php

$id = $_POST['id'] ?? 0;

$is_deleted = delete_category_by_id($connect, $id);

if ($is_deleted) {
	header('Location: /categories/list');
} else {
	die('error');
}