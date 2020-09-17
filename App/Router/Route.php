<?php


namespace App\Router;


use App\Router\Exception\MethodDoesNotExistException;
use App\Router\Exception\NotFoundException;

class Route
{
	/**
	 * @var string|null
	 */
	private $url;

	/**
	 * @var string|null
	 */
	private $controller = null;

	/**
	 * @var string|null
	 */
	private $method = null;

	/**
	 * @var array
	 */
	private $params = [];

	public function __construct($url)
	{
		$this->url = $url;
	}

	/**
	 * @return string|null
	 */
	public function getUrl(): ?string
	{
		return $this->url;
	}

	/**
	 * @param string|null $url
	 * @return Route
	 */
	public function setUrl(?string $url): Route
	{
		$this->url = $url;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getController(): ?string
	{
		return $this->controller;
	}

	/**
	 * @param string|null $controller
	 * @return Route
	 */
	public function setController(?string $controller): Route
	{
		$this->controller = $controller;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getMethod(): ?string
	{
		return $this->method;
	}

	/**
	 * @param string|null $method
	 * @return Route
	 */
	public function setMethod(?string $method): Route
	{
		$this->method = $method;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getParams(): array
	{
		return $this->params;
	}

	/**
	 * @param array $params
	 * @return Route
	 */
	public function setParams(array $params): Route
	{
		$this->params = $params;
		return $this;
	}

	/**
	 * @return mixed
	 * @throws NotFoundException
	 * @throws MethodDoesNotExistException
	 */
	public function execute()
	{
		$controllerName = $this->getController();
		if(is_null($controllerName)) {
			throw new NotFoundException();
		}

		$methodName = $this->getMethod();
		$controller = new $controllerName($this);

		if (method_exists($controller, $methodName)) {
			return $controller->{$methodName}();
		}

		throw new MethodDoesNotExistException();

	}

	/**
	 * @param $paramName
	 * @param $paramValue
	 * @return Route
	 */
	public function setParam(string $paramName, $paramValue): Route
	{
		$this->params[$paramName] = $paramValue;

		return $this;
	}

	public function getParam(string $key)
	{
		return $this->getParams()[$key] ?? null;
	}

	public function clearParams()
	{
		$this->params = [];
	}

	public function isValidPath(string $path)
	{
		return $this->getUrl() == $path || $this->checkSmartPath($path);
	}

	private function checkSmartPath(string $path)
	{
		$isSmartPath = strpos($path, '{');

		if (!$isSmartPath) {
			return false;
		}
		$this->clearParams();
		$urlChunks = explode('/', $this->getUrl());
		$pathChunks = explode('/', $path);
		$isEqual = false;

		if (count($urlChunks) != count($pathChunks)) {
			return false;
		}

		for ($i = 0; $i < count($pathChunks); $i++) {
			$urlChunk = $urlChunks[$i];
			$pathChunk = $pathChunks[$i];

			$isSmartChunk = strpos($pathChunk, '{') !== false && strpos($pathChunk, '}') !== false;

			if (!$isSmartChunk && $urlChunk != $pathChunk) {
				$isEqual = false;
				break;
			}

			if ($isSmartChunk) {
				$paramName = str_replace(['{', '}'], '', $pathChunk);
				$this->setParam($paramName, $urlChunk);
			}

			$isEqual = true;
		}

		return $isEqual;
	}
}