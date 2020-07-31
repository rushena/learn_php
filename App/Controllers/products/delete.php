<?php

echo var_dump('dfs');

$id = $_POST['id'] ?? 0;

$query = "DELETE FROM products WHERE id=$id";

$request = query($connect, $query);

if (mysqli_affected_rows($connect)) {
	header('Location: /products/list');
} else {
	die('error');
}