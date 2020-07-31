{include file="header.tpl" h1="Редактировать товар"}

<div class="row justify-content-center">
	<div class="col col-xl-8 col-lg-10">
		<form method="post">
			<input type="hidden" name="id" value="{$editedProduct.id}">
			<div class="form-group">
				<label for="exampleInputEmail1">Название товара:</label>
				<input type="text" name="name" class="form-control" value="{$editedProduct.name}">
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Описание товара:</label>
				<textarea class="form-control" name="description">{$editedProduct.description}</textarea>
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Артикул товара:</label>
				<input type="text" name="article" class="form-control" value="{$editedProduct.article}">
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Количество товара на складе:</label>
				<input type="text" name="amount" class="form-control" value="{$editedProduct.amount}">
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Цена товара:</label>
				<input type="text" name="price" class="form-control" value="{$editedProduct.price}">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Отправить</button>
			</div>
		</form>
	</div>
</div>

{include file="bottom.tpl"}