<?php

namespace App\Category;

use App\Category;
use App\Product;
use App\Renderer;
use App\Request;
use App\Response;
use App\Router\Route;

class CategoryController
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
		Renderer::getSmarty()->assign('categories', Category::getList());

		Renderer::getSmarty()->display('categories/index.tpl');
	}

	public function add()
	{
		if (Request::isPost()) {

			$category = Category::getFromPost();

			$is_added = Category::add($category);

			if ($is_added) {
				Response::redirect('/categories/list');
			} else {
				die('error');
			}
		}

		Renderer::getSmarty()->display('categories/add.tpl');
	}

	public function delete()
	{
		$id = Request::getIntFromPost('id', 0);

		$is_deleted = Category::deleteByID($id);

		if ($is_deleted) {
			Response::redirect('/categories/list');
		} else {
			die('error');
		}
	}

	public function edit()
	{
		$id = Request::getIntFromGet('id', null);

		if (is_null($id)) {
			$id = $this->route->getParam('id') ?? null;
		}

		$result = Category::getByID($id);

		if (Request::isPost()) {

			$editedCategory = Category::getFromPost();


			$is_updated = Category::updateByID($editedCategory['id'], $editedCategory);

			if ($is_updated) {
				Response::redirect('/categories/list');
			} else {
				die('not edited items');
			}
		}

		Renderer::getSmarty()->assign('editedCategory', $result);
		Renderer::getSmarty()->display('categories/edit.tpl');
	}

	public function view()
	{
		$id = Request::getIntFromGet('id', null);

		if (is_null($id)) {
			$id = $this->route->getParam('id') ?? null;
		}

		$products = Product::getListByCategoryID($id);
		$currentCategory = Category::getByID($id);

		Renderer::getSmarty()->assign('products', $products);
		Renderer::getSmarty()->assign('current_category', $currentCategory);
		Renderer::getSmarty()->display('categories/view.tpl');
	}
}