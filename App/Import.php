<?php

namespace App;

use App\Db\Db;

class Import
{
	public static function productsFromFileTask(array $params)
	{
		$file = APP_UPLOAD_DIR . '/import/' . $params["filename"];

		$fileData = fopen($file, 'r');

		$mainField = 'article';
		$withHeader = true;
		$settings = [
			0 => 'name',
			1 => 'category_name',
			2 => 'article',
			3 => 'price',
			4 => 'amount',
			5 => 'description',
			6 => 'image_urls',
		];

		if ($withHeader) {
			$row = fgetcsv($fileData);
		}

		while ($row = fgetcsv($fileData)) {
			$productData = [];

			foreach ($settings as $key => $value) {
				$productData[$value] = $row[$key] ?? null;
			}

			$productData['image_urls'] = explode("\n", $productData['image_urls']);

			$productData['image_urls'] = array_map(function($item) {
				return trim($item);
			}, $productData['image_urls']);

			$productData['image_urls'] = array_filter($productData['image_urls'], function($item) {
				return !empty($item);
			});

			$product = [
				'name' => Db::escape($productData['name']),
				'article' => Db::escape($productData['article']),
				'price' => Db::escape($productData['price']),
				'amount' => Db::escape($productData['amount']),
				'description' => Db::escape($productData['description']),
			];

			$category = CategoryService::getByCategoryName($productData['category_name']);

			if (empty($category)) {
				$product["category_id"] = CategoryService::add([
					"name" => $productData['category_name'],
				]);
			} else {
				$product["category_id"] = $category["id"];
			}

			$targetProduct = ProductService::getByField($mainField, $product[$mainField]);
			$productId = 0;

			if (empty($targetProduct)) {
				$productId = ProductService::add($product);
			} else {
				$productId = $targetProduct["id"];
				$targetProduct = array_merge($targetProduct, $product);
				ProductService::updateByID($productId, $targetProduct);
			}

			foreach ($productData["image_urls"] as $image) {
				ProductImageService::uploadImageFromURL($productId, $image);
			}
		}

		return true;
	}
}