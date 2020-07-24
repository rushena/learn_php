<?php

require_once 'db.php';

$query = "SELECT * from `products`";

$request = query($connect, $query); 

$has_th = false;


echo "<a href=\"add.php\">Добавить товар</a><br /><br />";

echo '<table border="1" celloadding="3">';

while ($row = mysqli_fetch_assoc($request)) {

	if (!$has_th) {
		echo "<tr><th>#</th><th>Название товара</th><th>ID Категории</th><th></th></tr>";
		$has_th = true;
	}
	echo "<tr>";

		foreach($row as $fiels => $value) {
			echo "<td>";
			echo $value;
			echo "</td>";
		}

		echo "<td>";

		$id = $row["id"];
		
		echo "<a href=\"edit.php?id=$id\">Редактировать</a> | <form action=\"/delete.php\" method=\"post\"><input type=\"hidden\" name=\"id\" value=\"$id\" /><input type=\"submit\" value=\"Удалить\" /></form>";
		echo "</td>";

	echo "</tr>";
} 


echo '</table>';