<?php 

require_once 'db.php';

if (!empty($_POST)) {

	$name = $_POST['name'] ?? '';
	$description = $_POST['description'] ?? '';
	$article = $_POST['article'] ?? 0;
	$price = (int) $_POST['price'] ?? 0;
	$amount = (int) $_POST['amount'] ?? 0;	

	$query = "INSERT INTO products (`name`, `article`, `price`, `amount`, `description`) VALUES ('$name', '$article', $price, $amount, '$description')";

	$request = query($connect, $query);

	if (mysqli_affected_rows($connect)) {
		header('Location: /');
	} else {
		die('error');
	}
}

$smarty->display('products/add.tpl');