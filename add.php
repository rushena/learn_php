<?php 

require_once 'db.php';

if (!empty($_POST)) {

	$name = $_POST['name'] ?? '';

	$query = "INSERT INTO products(name) VALUES ('$name')";

	$request = query($connect, $query);

	if (mysqli_affected_rows($connect)) {
		header('Location: /');
	} else {
		die('error');
	}
}

?>

<form method="POST">
	<label>
		<span>Название товара</span>
		<input type="text" name="name">
	</label>
	<button>Отправить</button>
</form>