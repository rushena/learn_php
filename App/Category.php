<?php

function get_categories_list($connect) {

	$query = "SELECT * from `categories`";
	$request = query($connect, $query); 

	$categoriesList = [];

	while ($row = mysqli_fetch_assoc($request)) {
		$categoriesList[] = $row;
	}

	return $categoriesList;
}

function get_category_by_id($connect, $id) {
	$query = "SELECT * from `categories` WHERE id=$id";
	$request = query($connect, $query);

	$result = mysqli_fetch_assoc($request);

	if (is_null($result)) {
		return [];
	}

	return $result;
}

function update_category_by_id($connect, $id, $category) {
	$name = $category['name'] ?? '';

	$query = "UPDATE `categories` SET name = '$name' WHERE id = $id";

	query($connect, $query);

	return mysqli_affected_rows($connect);
}

function add_category($connect, $category) {

	$name = $category['name'] ?? '';

	$query = "INSERT INTO `categories` (`name`) VALUES ('$name')";

	query($connect, $query);

	return mysqli_affected_rows($connect);
}

function delete_category_by_id($connect, $id) {
	$query = "DELETE FROM `categories` WHERE id=$id";

	$request = query($connect, $query);

	return mysqli_affected_rows($connect);
}

function get_category_from_post() {
	return [
		'id' => $_POST['id'] ?? '',
		'name' => $_POST['name'] ?? '',
	];
}