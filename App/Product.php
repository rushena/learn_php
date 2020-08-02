<?php

class Product {

	public static function getList($limit = 100, $offset = 0) {
		$query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id LIMIT $offset, $limit";
		$request = Db::query($query); 

		$productsList = [];

		while ($row = mysqli_fetch_assoc($request)) {
			$productsList[] = $row;
		}

		return $productsList;
	}

	public static function getListCount() {
		$query = "SELECT COUNT(1) as c FROM products p LEFT JOIN categories c ON p.category_id = c.id";
		$request = Db::query($query); 

		$row = mysqli_fetch_assoc($request);

		return (int) ($row['c'] ?? 0);	
	}

	public static function getListByCategoryID($id) {
		$query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE category_id = $id";

		$request = Db::query($query); 

		$productsList = [];

		while ($row = mysqli_fetch_assoc($request)) {
			$productsList[] = $row;
		}

		return $productsList;
	}

	public static function getByID($id) {
		$query = "SELECT * from `products` WHERE id=$id";
		$request = Db::query($query);

		$result = mysqli_fetch_assoc($request);

		if (is_null($result)) {
			return [];
		}

		return $result;
	}

	public static function updateByID($id, $product) {
		$name = $product['name'] ?? '';
		$description = $product['description'] ?? '';
		$article = $product['article'] ?? 0;
		$price = (int) $product['price'] ?? 0;
		$amount = (int) $product['amount'] ?? 0;
		$categoryID = (int) $product['category_id'] ?? 0;

		$query = "UPDATE products SET name = '$name', article = '$article', price = $price, amount = $amount, description = '$description', category_id = $categoryID WHERE id = $id";

		Db::query($query);

		return Db::affectedRows();
	}

	public static function add($product) {

		$name = $product['name'] ?? '';
		$description = $product['description'] ?? '';
		$article = $product['article'] ?? 0;
		$price = (int) $product['price'] ?? 0;
		$amount = (int) $product['amount'] ?? 0;
		$categoryID = (int) $product['category_id'] ?? 0;

		$query = "INSERT INTO products (`name`, `article`, `price`, `amount`, `description`, `category_id`) VALUES ('$name', '$article', $price, $amount, '$description', $categoryID)";

		Db::query($query);

		return Db::affectedRows();
	}

	public static function deleteByID($id) {
		$query = "DELETE FROM products WHERE id=$id";

		$request = Db::query($query);

		return Db::affectedRows();
	}

	public static function getFromPost() {
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
}