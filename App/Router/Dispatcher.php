<?php

namespace App\Router;

use App\Renderer;
use App\Request;
use App\Router\Exception\MethodDoesNotExistException;
use App\Router\Exception\NotFoundException;

class Dispatcher
{
	protected $routes = [
		'/products' => [ \App\Product\ProductController::class, 'list' ],
		'/products/edit/{id}' => [ \App\Product\ProductController::class, 'edit' ],
		'/products/add' => [ \App\Product\ProductController::class, 'add' ],
		'/products/delete_image' => [ \App\Product\ProductController::class, 'deleteImage' ],
		'/products/delete' => [ \App\Product\ProductController::class, 'delete' ],

		'/categories' => [ \App\Category\CategoryController::class, 'list' ],
		'/categories/add' => [ \App\Category\CategoryController::class, 'add' ],
		'/categories/edit/{id}' => [ \App\Category\CategoryController::class, 'edit' ],
		'/categories/delete' => [ \App\Category\CategoryController::class, 'delete' ],
		'/categories/view/{id}' => [ \App\Category\CategoryController::class, 'view' ],

		'/queue' => [ \App\Queue\QueueController::class, 'list' ],
		'/queue/run' => [ \App\Queue\QueueController::class, 'run' ],

		'/import' => [ \App\Import\ImportController::class, 'list' ],
		'/import/upload' => [ \App\Import\ImportController::class, 'upload' ],
	];

	public function dispatch()
	{
		$url = Request::getUrl();
		$route = new Route($url);

		foreach ($this->routes as $path => $controller) {
			if ($this->isValidPath($path, $route)) {
				break;
			}
		}

		try {
			$route->execute();
		} catch (NotFoundException | MethodDoesNotExistException $e) {
			$this->error404();
		}
	}

	public function isValidPath(string $path, Route $route)
	{
		$controller = $this->routes[$path];
		$isValidPath = $route->isValidPath($path);

		if ($isValidPath){
			$route->setController($controller[0]);
			$route->setMethod($controller[1]);
		}

		return $isValidPath;

	}

	private function error404()
	{
		Renderer::getSmarty()->display('404.tpl');
		exit;
	}
}