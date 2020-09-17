<?php

namespace App;

use App\Db\Db;

class CategoryService {

	public function getList() {

		$query = "SELECT * from `categories`";

		return Db::fetchAll($query);
	}

	public function getByCategoryName(string $categoryName) {
	    $query = "SELECT * from `categories` WHERE name='$categoryName'";
	    return Db::fetchRow($query);
    }

	public function getByID($id) {
		$query = "SELECT * from `categories` WHERE id=$id";
		return Db::fetchRow($query);
	}

	public function updateByID($id, $category) {
		if (isset($category['id'])) {
			unset($category['id']);
		}
		return Db::update('categories', $category, "id = $id");
	}

	public function add($category) {
		if (isset($category['id'])) {
			unset($category['id']);
		}
		return Db::insert('categories', $category);
	}

	public function deleteByID($id) {
		return Db::delete("categories", "id=$id");
	}

	public function getFromPost(Request $request) {
		return [
			'id' => $request->getIntFromPost('id', 0),
			'name' => $request->getStringFromPost('name'),
		];
	}

}