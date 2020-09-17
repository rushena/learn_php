<?php

namespace App\Router;

use App\DI\Container;
use App\FS;
use App\Product\ProductController;
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

	protected function getRoutes(): array
	{
		$routes = $this->routes;

		$files = FS::scanDir(APP_DIR . "/App");

		foreach ($files as $filePath) {
			if (strpos($filePath, 'Controller.php') === false) {
				continue;
			}
			$controllerRoutes = $this->getRoutersByControllerFile($filePath);
			$routes = array_merge($routes, $controllerRoutes);
		}

		return $routes;
	}

	public function dispatch()
	{
		$request = new Request();
		$url = $request->getUrl();
		$route = new Route($url);

		foreach ($this->getRoutes() as $path => $controller) {
			if ($this->isValidPath($path, $route)) {
				break;
			}
		}

		try {
			$controllerClass = $route->getController();
			if(is_null($controllerClass)) {
				throw new NotFoundException();
			}

			$methodName = $route->getMethod();
			$controller = new $controllerClass($route);

			if (method_exists($controller, $methodName)) {
				$reflectionClass = new \ReflectionClass($controllerClass);
				$reflectionMethod = $reflectionClass->getMethod($methodName);

				$reflectionParameters = $reflectionMethod->getParameters();
				$arguments = [];

				foreach ($reflectionParameters as $parameter) {
					/**
					 * @var \ReflectionParameter
					 */

					$parameterName = $parameter->getName();
					$parameterType = $parameter->getType();

					assert($parameterType instanceof \ReflectionNamedType);
					$className = $parameterType->getName();

					if (class_exists($className)) {
						$arguments[$parameterName] = new $className();
					}
				}

				return call_user_func_array([$controller, $methodName], $arguments);
			}

			throw new MethodDoesNotExistException();
//			$container->execute($route->getController(), $route->getMethod());
//			$route->execute();
		} catch (NotFoundException | MethodDoesNotExistException $e) {
			$this->error404();
		}
	}

	public function isValidPath(string $path, Route $route)
	{
		$routes = $this->getRoutes();

		$controller = $routes[$path];
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

	private function getRoutersByControllerFile(string $controllerFile) {
		$routes = [];
		$controllerClassName = str_replace([APP_DIR . '/', '.php'], '', $controllerFile);
		$controllerClassName = str_replace('/', '\\', $controllerClassName);

		$reflectionClass = new \ReflectionClass($controllerClassName);
		$reflectionMethods = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);

		foreach ($reflectionMethods as $reflectionMethod) {
			if ($reflectionMethod->isConstructor()) {
				continue;
			}

			$docComment = (string) $reflectionMethod->getDocComment();

			if ($docComment === '') {
				continue;
			}

			$docComment = trim(str_replace(["/**", "*/"], '', $docComment));
			$docCommentArray = explode("\n", $docComment);
			$docCommentArray = array_map(function($item){
				$item = trim($item);
				$position = strpos($item, "*");
				if ($position === 0) {
					$item = substr($item, 1);
				}
				return trim($item);
			}, $docCommentArray);

			foreach ($docCommentArray as $docString) {
				$isRoute = strpos($docString, '@route(') === 0;
				if (empty($docString) || !$isRoute) {
					continue;
				}
				$url = str_replace(["@route(\"", "\")"], '', $docString);
				$routes[$url] = [$controllerClassName, $reflectionMethod->getName()];
			}
		}

		return $routes;
	}
}