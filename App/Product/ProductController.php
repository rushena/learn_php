<?php

namespace App\Product;

use App\Product\ProductRepository;
use App\Request;
use App\Renderer;
use App\Category;
use App\Category\CategoryModel;
use App\Product;
use App\ProductImage;
use App\Response;
use App\Router\Route;

class ProductController
{
	/**
	 * @var Route
	 */
	private $route;

	public function __construct(Route $route) {
		$this->route = $route;
	}

	public function list()
	{
		$current_page = Request::getIntFromGet('p', 1);
		$products_count = \App\Product::getListCount();
		$limit = 10;
		$offset = ($current_page - 1) * $limit;
		$pages_count = ceil($products_count / $limit);

		$productRepository = new ProductRepository();

		$products = $productRepository->getList($limit, $offset);

		Renderer::getSmarty()->assign('products', $products);
		Renderer::getSmarty()->assign('pages_count', $pages_count);
		Renderer::getSmarty()->display('products/index.tpl');
	}

	public function edit()
	{
		$id = Request::getIntFromGet('id', null);

		if (is_null($id)) {
			$id = $this->route->getParam("id") ?? null;
		}

		$productRepository = new ProductRepository();
		$product = [];

		if ($id) {
			$result = Product::getByID($id);
			$product = $productRepository->getById($id);
		}

		if (Request::isPost()) {

			$editedProduct = Product::getFromPost();

			$product->setName($editedProduct["name"]);
			$product->setArticle($editedProduct["article"]);
			$product->setDescription($editedProduct["description"]);
			$product->setAmount($editedProduct["amount"]);
			$product->setPrice($editedProduct["price"]);

			$categoryId = $editedProduct["category_id"] ?? 0;

			if ($categoryId) {
				$categoryData = Category::getByID($categoryId);
				$categoryName = $categoryData["name"];
				$category = new CategoryModel($categoryName);
				$category->setId($categoryId);

				$product->setCategory($category);
			}

			$product = $productRepository->save($product);

			$uploadImages = $_FILES['images'];
			$image_url = Request::getStringFromPost("image_url");

			ProductImage::uploadImages($editedProduct["id"], $uploadImages);
			ProductImage::uploadImageFromURL($editedProduct["id"], $image_url);

			Response::redirect('/products/list');
		}

		$categories = Category::getList();

		Renderer::getSmarty()->assign('categories', $categories);
		Renderer::getSmarty()->assign('editedProduct', $product);
		Renderer::getSmarty()->display('products/edit.tpl');
	}

	public function add()
	{
		if (Request::isPost()) {
			$productData = Product::getFromPost();
			$productRepository = new Product\ProductRepository();
			$product = $productRepository->getProductFromArray($productData);

			$product = $productRepository->save($product);
			$product_id = $product->getId();

			$uploadImages = $_FILES['images'];
			$image_url = Request::getStringFromPost("image_url");


			ProductImage::uploadImages($product_id, $uploadImages);
			ProductImage::uploadImageFromURL($product_id, $image_url);

			if ($product_id) {
				Response::redirect('/products/list');
			} else {
				die('error');
			}
		}

		$categories = Category::getList();

		Renderer::getSmarty()->assign('categories', $categories);
		Renderer::getSmarty()->display('products/add.tpl');
	}

	public function delete()
	{
		$id = Request::getIntFromPost('id', 0);

		$is_deleted = Product::deleteByID($id);

		if ($is_deleted) {
			Response::redirect('/products/list');
		} else {
			die('error');
		}
	}

	public function deleteImage()
	{
		$id = Request::getIntFromPost('id', 0);

		$is_deleted = ProductImage::deleteByID($id);

		if ($is_deleted) {
			echo 1;
		} else {
			echo 0;
		}

		return true;
	}
}