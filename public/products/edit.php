<?php
	 
require_once $_SERVER['DOCUMENT_ROOT'] . '/../config/config.php';

$id = $_GET["id"] ?? 0;

$query = "SELECT * from `products` WHERE id=$id";

$request = query($connect, $query);

$result = mysqli_fetch_assoc($request);

if (!empty($_POST)) {

	var_dump($_POST);

	$id = (int) $_POST['id'] ?? 0;
	$name = $_POST['name'] ?? '';
	$article = $_POST['article'] ?? '';
	$price = (int) $_POST['price'] ?? 0;
	$amount = (int) $_POST['amount'] ?? 0;
	$description = $_POST['description'] ?? '';

	$query = "UPDATE products SET name = '$name', article = '$article', price = $price, amount = $amount, description = '$description' WHERE id = $id";

	$request = query($connect, $query);

	if (mysqli_affected_rows($connect)) {
		header('Location: /');
	} else {
		die('not edited items');
	}
}

$smarty->assign('editedProduct', $result);
$smarty->display('products/edit.tpl');