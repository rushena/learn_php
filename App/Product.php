<?php

namespace App;

use App\Db\Db;

class Product
{

	public static function getList($limit = 100, $offset = 0)
	{
		$query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id LIMIT $offset, $limit";

		$products = Db::fetchAll($query);

		foreach ($products as &$product) {
			$product["images"] = ProductImage::getListByProductId($product["id"]);
		}

		return $products;
	}

	public static function getListCount()
	{
		$query = "SELECT COUNT(1) as c FROM products p LEFT JOIN categories c ON p.category_id = c.id";

		return Db::fetchOne($query);
	}

	public static function getListByCategoryID($id)
	{
		$query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE category_id = $id";

		$request = Db::query($query);

		$productsList = [];

		while ($row = mysqli_fetch_assoc($request)) {
			$productsList[] = $row;
		}

		return $productsList;
	}

	public static function getByID($id)
	{
		$query = "SELECT * from `products` WHERE id=$id";

		$product = Db::fetchRow($query);

		$product['images'] = ProductImage::getListByProductId($id);

		return $product;
	}

	public static function updateByID(int $id, $product)
	{

		if (isset($product['id'])) {
			unset($product['id']);
		}

		return Db::update('products', $product, "id = $id");
	}

	public static function add($product)
	{
		if (isset($product['id'])) {
			unset($product['id']);
		}
		return Db::insert('products', $product);
	}

	public static function deleteByID(int $id)
	{
		FS::deleteDir(APP_UPLOAD_PRODUCTS_DIR . '/' . $id);

		ProductImage::deleteByProductID($id);
		return Db::delete("products", "id=$id");
	}

	public static function getFromPost()
	{
		return [
			'id' => Request::getIntFromPost('id', 0),
			'name' => Request::getStringFromPost('name'),
			'description' => Request::getStringFromPost('description'),
			'article' => Request::getStringFromPost('article'),
			'category_id' => Request::getIntFromPost('category_id', 0),
			'price' => Request::getIntFromPost('price', 0),
			'amount' => Request::getIntFromPost('amount', 0),
		];
	}

	public static function getByField($field, string $value)
	{
		$mainField = Db::escape($field);
		$mainValue = Db::escape($value);
		$query = "SELECT * from `products` WHERE `$mainField` = '$mainValue'";
		return Db::fetchRow($query);
	}
}