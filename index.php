<?php


$connect = mysqli_connect('localhost', 'root', 'password', 'shop');

if( mysqli_connect_errno() ) {

	var_dump(mysqli_connect_error());

	exit;
}

mysqli_set_charset($connect, 'utf8');

$query = "SELECT * from `products`";

$request = mysqli_query($connect, $query);

if ( mysqli_errno($connect) ) {
	var_dump(mysqli_error($connect));

	exit;
}

$has_th = false;

echo "<a href=\"add.php\">Добавить товар</a><br /><br />";

echo '<table border="1" celloadding="3">';

while ($row = mysqli_fetch_assoc($request)) {

	if (!$has_th) {
		echo "<tr><th>#</th><th>Название товара</th><th></th></tr>";
		$has_th = true;
	}
	echo "<tr>";

		foreach($row as $fiels => $value) {
			echo "<td>";
			echo $value;
			echo "</td>";
		}

		echo "<td>";
		echo "<a href=\"edit.php\">Редактировать</a> | <a href=\"\">Удалить</a>";
		echo "</td>";

	echo "</tr>";
} 


echo '</table>';
