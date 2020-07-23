<?php

	$id = $_GET["id"] ?? 0;
	$connect = mysqli_connect('localhost', 'root', 'password', 'shop');

	if( mysqli_connect_errno() ) {

		var_dump(mysqli_connect_error());

		exit;
	}

	mysqli_set_charset($connect, 'utf8');

	$query = "SELECT * from `products` WHERE id=$id";

	$request = mysqli_query($connect, $query);

	$result = mysqli_fetch_assoc($request);
	$name = $result['name'];

	if (!empty($_POST)) {

		$id = $_POST['id'] ?? 0;
		$name = $_POST['name'] ?? '';


		$query = "UPDATE products SET name = '$name' WHERE id = $id";

		$request = mysqli_query($connect, $query);

		if (mysqli_errno($connect)) {
			var_dump(mysql_error($connect));
			exit;
		}

		var_dump(mysqli_affected_rows($connect));

		if (mysqli_affected_rows($connect)) {
			header('Location: /');
		} else {
			die('not edited items');
		}
	}
?>


<form method="post">
	<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
	<input type="text" name="name" value="<?php echo $name ?>">
	<input type="submit" value="Изменить">
</form>