<?php

function get_products_list($connect, $limit = 100, $offset = 0) {

	$query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id LIMIT $offset, $limit";
	$request = query($connect, $query); 

	$productsList = [];

	while ($row = mysqli_fetch_assoc($request)) {
		$productsList[] = $row;
	}

	return $productsList;
}

function get_products_list_count ($connect) {
	$query = "SELECT COUNT(1) as c FROM products p LEFT JOIN categories c ON p.category_id = c.id";
	$request = query($connect, $query); 

	$row = mysqli_fetch_assoc($request);

	return (int) ($row['c'] ?? 0);	
}

function get_products_list_by_category_id($connect, $id) {
	$query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE category_id = $id";

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
	$categoryID = (int) $product['category_id'] ?? 0;

	$query = "UPDATE products SET name = '$name', article = '$article', price = $price, amount = $amount, description = '$description', category_id = $categoryID WHERE id = $id";

	query($connect, $query);

	return mysqli_affected_rows($connect);
}

function add_product($connect, $product) {

	$name = $product['name'] ?? '';
	$description = $product['description'] ?? '';
	$article = $product['article'] ?? 0;
	$price = (int) $product['price'] ?? 0;
	$amount = (int) $product['amount'] ?? 0;
	$categoryID = (int) $product['category_id'] ?? 0;

	$query = "INSERT INTO products (`name`, `article`, `price`, `amount`, `description`, `category_id`) VALUES ('$name', '$article', $price, $amount, '$description', $categoryID)";

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
		'category_id' => $_POST['category_id'] ?? 0,
		'price' => (int) $_POST['price'] ?? 0,
		'amount' => (int) $_POST['amount'] ?? 0,
	];
}