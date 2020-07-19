<?php

	$connect = mysqli_connect('localhost', 'root', 'password', 'shop');

	if( mysqli_connect_errno() ) {

		var_dump(mysqli_connect_error());

		exit;
	}

	mysqli_set_charset($connect, 'utf8');

	$id = $_POST['id'];

	var_dump($id);

	$query = "DELETE FROM products WHERE id=$id";

	$request = mysqli_query($connect, $query);

	if ( mysqli_errno($connect) ) {
		var_dump(mysqli_error($connect));

		exit;
	}

	header('Location: /');