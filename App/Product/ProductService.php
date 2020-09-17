<?php

namespace App\Product;

use App\Db\Db;
use App\FS;
use App\Request;

class ProductService
{

	public function getList($limit = 100, $offset = 0)
	{
		$productImageService = new ProductImageService();
		$query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id LIMIT $offset, $limit";

		$products = Db::fetchAll($query);

		foreach ($products as &$product) {
			$product["images"] = $productImageService->getListByProductId($product["id"]);
		}

		return $products;
	}

	public function getListByCategoryID($id)
	{
		$query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE category_id = $id";

		$request = Db::query($query);

		$productsList = [];

		while ($row = mysqli_fetch_assoc($request)) {
			$productsList[] = $row;
		}

		return $productsList;
	}

	public function getByID($id)
	{
		$productImageService = new ProductImageService();
		$query = "SELECT * from `products` WHERE id=$id";

		$product = Db::fetchRow($query);

		$product['images'] = $productImageService->getListByProductId($id);

		return $product;
	}

	public function updateByID(int $id, $product)
	{

		if (isset($product['id'])) {
			unset($product['id']);
		}

		return Db::update('products', $product, "id = $id");
	}

	public function add($product)
	{
		if (isset($product['id'])) {
			unset($product['id']);
		}
		return Db::insert('products', $product);
	}

	public function deleteByID(int $id)
	{
		$productImageService = new ProductImageService();
		FS::deleteDir(APP_UPLOAD_PRODUCTS_DIR . '/' . $id);

		$productImageService->deleteByProductID($id);
		return Db::delete("products", "id=$id");
	}

	public function getFromPost(Request $request)
	{
		return [
			'id' => $request->getIntFromPost('id', 0),
			'name' => $request->getStringFromPost('name'),
			'description' => $request->getStringFromPost('description'),
			'article' => $request->getStringFromPost('article'),
			'category_id' => $request->getIntFromPost('category_id', 0),
			'price' => $request->getIntFromPost('price', 0),
			'amount' => $request->getIntFromPost('amount', 0),
		];
	}

	public function getByField($field, string $value)
	{
		$mainField = Db::escape($field);
		$mainValue = Db::escape($value);
		$query = "SELECT * from `products` WHERE `$mainField` = '$mainValue'";
		return Db::fetchRow($query);
	}
}