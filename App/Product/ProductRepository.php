<?php

namespace App\Product;

use App\Category\CategoryModel;
use App\Db\Db;

class ProductRepository
{
	protected $limit = 50;

	public function getListCount()
	{
		$query = "SELECT COUNT(1) as c FROM products p LEFT JOIN categories c ON p.category_id = c.id";

		return Db::fetchOne($query);
	}

	/**
	 * @param array $data
	 * @return ProductModel
	 * @throws \Exception
	 */
	public function getProductFromArray(array $data): ProductModel
	{
		$id = $data["id"];

		$name = $data["name"] ?? null;
		$price = $data["price"] ?? null;
		$amount = $data["amount"] ?? null;

		if (is_null($name)) {
			throw new \Exception('Name обязателен для инициализации товара');
		}

		if (is_null($price)) {
			throw new \Exception('Price обязателен для инициализации товара');
		}

		if (is_null($amount)) {
			throw new \Exception('Amount обязателен для инициализации товара');
		}

		$article = $data["article"] ?? '';
		$categoryId = $data["category_id"] ?? 0;
		$description = $data["description"] ?? '';

		$product = new ProductModel($name, $price, $amount);
		$product
			->setId($id)
			->setDescription($description)
			->setArticle($article);

		if ($categoryId > 0) {
			$categoryName = $data["category_name"] ?? null;

			if (is_null($categoryName)) {
				$categoryData = \App\CategoryService::getByID($categoryId);
				$categoryName = $categoryData["name"];
			}
			$category = new CategoryModel($categoryName);
			$category->setId($categoryId);

			$product->setCategory($category);
		}

		return $product;
	}

	/**
	 * @param array $data
	 * @return ProductImageModel
	 */
	public function getProductImagesFromArray(array $data): ProductImageModel
	{
		$productImage = new ProductImageModel();

		$productImage
			->setId($data["id"])
			->setName($data["name"])
			->setPath($data["path"])
			->setSize($data["size"]);

		return $productImage;
	}

	/**
	 * @param int $limit
	 * @param int $offset
	 * @return ProductModel[]
	 * @throws \Exception
	 */

	public function getList(int $limit = 50, int $offset = 0): array
	{
		$query = "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id LIMIT $offset, $limit";

		$request = Db::query($query);

		$products = [];

		while ($productArray = Db::fetchAssoc($request)) {
			$product = $this->getProductFromArray($productArray);

			$imagesData = ProductImageService::getListByProductId($product->getId());
			foreach ($imagesData as $imageItem) {
				$productImage = $this->getProductImagesFromArray($imageItem);
				$product->addImage($productImage);
			}

			$products[] = $product;
		}

		return $products;
	}

	/**
	 * @param ProductModel $product
	 * @return ProductModel
	 */
	public function save(ProductModel $product): ProductModel
	{
		$id = $product->getId();
		$productArray = $this->productToArray($product);

		if ($id) {
			Db::update('products', $productArray, "id = $id");
			return $product;
		}

		$id = Db::insert('products', $productArray);
		$product->setId($id);

		return $product;
	}

	public function getById(int $id) :ProductModel
	{

		$query = "SELECT * from `products` WHERE id=$id";
		$productArray = Db::fetchRow($query);

		$product = $this->getProductFromArray($productArray);

		$imagesData = ProductImageService::getListByProductId($product->getId());
		foreach ($imagesData as $imageItem) {
			$productImage = $this->getProductImagesFromArray($imageItem);
			$product->addImage($productImage);
		}

		return $product;
	}

	public function productToArray(ProductModel $product): array
	{
		$productData = [
			"name" => $product->getName(),
			"article" => $product->getArticle(),
			"price" => $product->getPrice(),
			"amount" => $product->getAmount(),
			"description" => $product->getDescription(),
		];

		$category = $product->getCategory();
		if (!is_null($category)) {
			$productData["category_id"] = $category->getId();
		}

		return $productData;
	}
}