<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Добавить товар</title>
</head>
<body>

<div class="site-wrapper container-sm">
	<h1>Добавить новый товар</h1>

	<div class="row justify-content-center">
		<div class="col col-xl-8 col-lg-10">
			<form method="post">
				<div class="form-group">
					<label for="exampleInputEmail1">Название товара:</label>
					<input type="text" name="name" class="form-control">
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Описание товара:</label>
					<textarea class="form-control" name="description"></textarea>
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Артикул товара:</label>
					<input type="text" name="article" class="form-control">
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Количество товара на складе:</label>
					<input type="text" name="amount" class="form-control">
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Цена товара:</label>
					<input type="text" name="price" class="form-control">
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Добавить</button>
				</div>
			</form>
		</div>
	</div>

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
