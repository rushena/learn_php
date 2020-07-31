<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Список товаров</title>
</head>
<body>

<div class="site-wrapper container-sm">
	<h1>Список товаров</h1>

	<a href="add.php" class="btn btn-success">Добавить новый товар</a>
	<br />
	<br />

	<table class="table table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>Название</th>
				<th>Описание</th>
				<th>Артукул</th>
				<th>Категория</th>
				<th>Кол-во</th>
				<th>Цена</th>
				<th></th>				
			</tr>
		</thead>
		<tbody>
			{foreach from=$products item=e key=k}
				<tr>
					<th>{$e.id}</th>
					<td>{$e.name}</td>
					<td>{$e.description}</td>
					<td>{$e.article}</td>
					<td>ToDo</td>
					<td>{$e.amount}</td>
					<td>{$e.price}</td>
					<td>
						<a href="edit.php?id={$e.id}" class="btn btn-info btn-sm">Редактировать</a>
						<form class="d-inline-block remove-product" action="/delete.php" method="post"><input type="hidden" name="id" value="{$e.id}" /><button type="submit" class="btn btn-danger btn-sm">Удалить</button></form>
					</td>
				</tr>
			{/foreach}
		</tbody>
	</table>

</div>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	{literal}
	<style>

		body {
			background: #eee;
		}

		.site-wrapper {
			background: #fff;
			padding: 40px;
		}

		.remove-product {margin-left: 8px;}

		h1 {
			margin-bottom: 30px;
			text-align: center;
		}

	</style>
	{/literal}
 </body>
 </html>