<?php

namespace App\Product;

use App\Request;
use App\Renderer;
use App\CategoryService;
use App\Category\CategoryModel;
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

	/**
	 * @param ProductRepository $productRepository
	 * @param Request $request
	 * @throws \Exception
	 *
	 * @route("/product_list")
	 */

	public function list(ProductRepository $productRepository, Request $request)
	{
		$current_page = $request->getIntFromGet('p', 1);
		$products_count = $productRepository->getListCount();
		$limit = 10;
		$offset = ($current_page - 1) * $limit;
		$pages_count = ceil($products_count / $limit);

		$products = $productRepository->getList($limit, $offset);

		Renderer::getSmarty()->assign('products', $products);
		Renderer::getSmarty()->assign('pages_count', $pages_count);
		Renderer::getSmarty()->display('products/index.tpl');
	}

	/**
	 * @param Request $request
	 * @param ProductService $productService
	 * @param ProductRepository $productRepository
	 * @param ProductImageService $productImageService
	 * @param Response $response
	 * @param CategoryService $categoryService
	 *
	 * @route("/edit_product/{id}")
	 */

	public function edit(Request $request, ProductService $productService, ProductRepository $productRepository, ProductImageService $productImageService, Response $response, CategoryService $categoryService)
	{
		$id = $request->getIntFromGet('id', null);

		if (is_null($id)) {
			$id = $this->route->getParam("id") ?? null;
		}

		$product = [];

		if ($id) {
			$result = $productService->getByID($id);
			$product = $productRepository->getById($id);
		}

		if ($request->isPost()) {

			$editedProduct = $productService->getFromPost($request);

			$product->setName($editedProduct["name"]);
			$product->setArticle($editedProduct["article"]);
			$product->setDescription($editedProduct["description"]);
			$product->setAmount($editedProduct["amount"]);
			$product->setPrice($editedProduct["price"]);

			$categoryId = $editedProduct["category_id"] ?? 0;

			if ($categoryId) {
				$categoryData = $categoryService->getByID($categoryId);
				$categoryName = $categoryData["name"];
				$category = new CategoryModel($categoryName);
				$category->setId($categoryId);

				$product->setCategory($category);
			}

			$product = $productRepository->save($product);

			$uploadImages = $_FILES['images'];
			$image_url = $request->getStringFromPost("image_url");

			$productImageService->uploadImages($editedProduct["id"], $uploadImages);
			$productImageService->uploadImageFromURL($editedProduct["id"], $image_url);

			$response->redirect('/products');
		}

		$categories = $categoryService->getList();

		Renderer::getSmarty()->assign('categories', $categories);
		Renderer::getSmarty()->assign('editedProduct', $product);
		Renderer::getSmarty()->display('products/edit.tpl');
	}

	public function add(Request $request, ProductService $productService, ProductRepository $productRepository, ProductImageService $productImageService, Response $response, CategoryService $categoryService)
	{
		if ($request->isPost()) {
			$productData = $productService->getFromPost($request);
			$product = $productRepository->getProductFromArray($productData);

			$product = $productRepository->save($product);
			$product_id = $product->getId();

			$uploadImages = $_FILES['images'];
			$image_url = $request->getStringFromPost("image_url");


			$productImageService->uploadImages($product_id, $uploadImages);
			$productImageService->uploadImageFromURL($product_id, $image_url);

			if ($product_id) {
				$response->redirect('/products');
			} else {
				die('error');
			}
		}

		$categories = $categoryService->getList();

		Renderer::getSmarty()->assign('categories', $categories);
		Renderer::getSmarty()->display('products/add.tpl');
	}

	public function delete(Request $request, ProductService $productService, Response $response)
	{
		$id = $request->getIntFromPost('id', 0);

		$is_deleted = $productService->deleteByID($id);

		if ($is_deleted) {
			$response->redirect('/products');
		} else {
			die('error');
		}
	}

	public function deleteImage(Request $request, ProductImageService $productImageService)
	{
		$id = $request->getIntFromPost('id', 0);

		$is_deleted = $productImageService->deleteByID($id);

		if ($is_deleted) {
			echo 1;
		} else {
			echo 0;
		}

		return true;
	}
}