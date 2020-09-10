{include file="header.tpl" h1="Добавить новый товар"}

<div class="row justify-content-center">
	<div class="col col-xl-8 col-lg-10">
		<form method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label >Название товара:</label>
				<input type="text" name="name" class="form-control">
			</div>
			<div class="form-group">
				<label>Выберите категорию:</label>
				<select class="form-control" name="category_id" value>
					<option value="0">Не выбрано</option>
					{foreach from=$categories item=i key=k}
						<option value="{$i.id}">{$i.name}</option>
					{/foreach}
				</select>
			</div>
			<div class="form-group">
				<label>Описание товара:</label>
				<textarea class="form-control" name="description"></textarea>
			</div>
			<div class="form-group">
				<label>Артикул товара:</label>
				<input type="text" name="article" class="form-control">
			</div>
			<div class="form-group">
				<label>Изображения товара:</label>
				<input type="file" name="images[]" accept="image/*" value="" multiple class="form-control">
			</div>
			<div class="form-group">
				<label>Ссылка на изображение:</label>
				<input type="text" name="image_url" class="form-control">
			</div>
			<div class="form-group">
				<label>Количество товара на складе:</label>
				<input type="text" name="amount" class="form-control">
			</div>
			<div class="form-group">
				<label>Цена товара:</label>
				<input type="text" name="price" class="form-control">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Добавить</button>
			</div>
		</form>
	</div>
</div>

{include file="bottom.tpl"}