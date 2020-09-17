<?php

namespace App;

class Request {

	public function getIntFromGet(string $key, $default = 0) {
		if (isset($_GET[$key])) {
			return (int) $_GET[$key];
		}
		return $default;
	}

	public function getStringFromPost(string $key, $default = '') {
		if (isset($_POST[$key])) {
			return (string) $_POST[$key];
		}
		return $default;
	}

	public function getIntFromPost(string $key, $default = 0) {
		if (isset($_POST[$key])) {
			return (int) $_POST[$key];
		}
		return $default;
	}

	public function isPost(): bool
	{
		return !empty($_POST);
	}

	public function getUrl()
	{
		$requestUri = $_SERVER["REQUEST_URI"];
		$requestUri = explode('?', $requestUri)[0];

		return $requestUri ?? '/';
	}
}