<?php

class Category {

	public static function getList() {

		$query = "SELECT * from `categories`";
		$request = Db::query($query); 

		$categoriesList = [];

		while ($row = mysqli_fetch_assoc($request)) {
			$categoriesList[] = $row;
		}

		return $categoriesList;
	}

	public static function getByID($id) {
		$query = "SELECT * from `categories` WHERE id=$id";
		$request = Db::query($query);

		$result = mysqli_fetch_assoc($request);

		if (is_null($result)) {
			return [];
		}

		return $result;
	}

	public static function updateByID($id, $category) {
		$name = $category['name'] ?? '';

		$query = "UPDATE `categories` SET name = '$name' WHERE id = $id";

		Db::query($connect, $query);

		return Db::affectedRows();
	}

	public static function add($category) {

		$name = $category['name'] ?? '';

		$query = "INSERT INTO `categories` (`name`) VALUES ('$name')";

		Db::query($connect, $query);

		return Db::affectedRows();
	}

	public static function deleteByID($id) {
		$query = "DELETE FROM `categories` WHERE id=$id";

		$request = Db::query($query);

		return Db::affectedRows();
	}

	public static function getFromPost() {
		return [
			'id' => $_POST['id'] ?? '',
			'name' => $_POST['name'] ?? '',
		];
	}

}