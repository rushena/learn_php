<?php 

if (!empty($_POST)) {

	var_dump($_POST);
	$connect = mysqli_connect('localhost', 'root', 'password', 'shop');

	if( mysqli_connect_errno() ) {

		var_dump(mysqli_connect_error());

		exit;
	}

	mysqli_set_charset($connect, 'utf8');

	$name = $_POST['name'] ?? '';

	$query = "INSERT INTO products(name) VALUES ('$name')";

	$request = mysqli_query($connect, $query);

	if ( mysqli_errno($connect) ) {
		var_dump(mysqli_error($connect));

		exit;
	}

	header('Location: /');
}

?>

<form method="POST">
	<label>
		<span>Название товара</span>
		<input type="text" name="name">
	</label>
	<button>Отправить</button>
</form>