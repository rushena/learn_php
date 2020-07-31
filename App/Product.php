<?php

function get_products_list($connect) {

	$query = "SELECT * from `products`";
	$request = query($connect, $query); 

	$productsList = [];

	while ($row = mysqli_fetch_assoc($request)) {
		$productsList[] = $row;
	}

	return $productsList;
}

function get_product_by_id($connect, $id) {
	$query = "SELECT * from `products` WHERE id=$id";
	$request = query($connect, $query);

	$result = mysqli_fetch_assoc($request);

	if (is_null($result)) {
		return [];
	}

	return $result;
}

function update_product_by_id($connect, $id, $product) {
	$name = $product['name'] ?? '';
	$description = $product['description'] ?? '';
	$article = $product['article'] ?? 0;
	$price = (int) $product['price'] ?? 0;
	$amount = (int) $product['amount'] ?? 0;

	$query = "UPDATE products SET name = '$name', article = '$article', price = $price, amount = $amount, description = '$description' WHERE id = $id";

	query($connect, $query);

	return mysqli_affected_rows($connect);
}

function add_product($connect, $product) {

	$name = $product['name'] ?? '';
	$description = $product['description'] ?? '';
	$article = $product['article'] ?? 0;
	$price = (int) $product['price'] ?? 0;
	$amount = (int) $product['amount'] ?? 0;

	$query = "INSERT INTO products (`name`, `article`, `price`, `amount`, `description`) VALUES ('$name', '$article', $price, $amount, '$description')";

	query($connect, $query);

	return mysqli_affected_rows($connect);
}

function delete_product_by_id($connect, $id) {
	$query = "DELETE FROM products WHERE id=$id";

	$request = query($connect, $query);

	return mysqli_affected_rows($connect);
}

function get_products_from_post() {
	return [
		'id' => $_POST['id'] ?? '',
		'name' => $_POST['name'] ?? '',
		'description' => $_POST['description'] ?? '',
		'article' => $_POST['article'] ?? 0,
		'price' => (int) $_POST['price'] ?? 0,
		'amount' => (int) $_POST['amount'] ?? 0,
	];
}