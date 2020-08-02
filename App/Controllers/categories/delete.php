<?php

$id = $_POST['id'] ?? 0;

$is_deleted = Category::deleteByID($id);

if ($is_deleted) {
	header('Location: /categories/list');
} else {
	die('error');
}