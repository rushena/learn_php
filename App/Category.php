<?php

namespace App;

use App\Db\Db;

class Category {

	public static function getList() {

		$query = "SELECT * from `categories`";

		return Db::fetchAll($query);
	}

	public static function getByCategoryName(string $categoryName) {
	    $query = "SELECT * from `categories` WHERE name='$categoryName'";
	    return Db::fetchRow($query);
    }

	public static function getByID($id) {
		$query = "SELECT * from `categories` WHERE id=$id";
		return Db::fetchRow($query);
	}

	public static function updateByID($id, $category) {
		if (isset($category['id'])) {
			unset($category['id']);
		}
		return Db::update('categories', $category, "id = $id");
	}

	public static function add($category) {
		if (isset($category['id'])) {
			unset($category['id']);
		}
		return Db::insert('categories', $category);
	}

	public static function deleteByID($id) {
		return Db::delete("categories", "id=$id");
	}

	public static function getFromPost() {
		return [
			'id' => Request::getIntFromPost('id', 0),
			'name' => Request::getStringFromPost('name'),
		];
	}

}