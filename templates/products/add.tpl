{include file="header.tpl" h1="Добавить новый товар"}

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

{include file="bottom.tpl"}