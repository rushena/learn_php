{include file="header.tpl" h1="Редактировать товар"}

<div class="row justify-content-center">
	<div class="col col-xl-8 col-lg-10">
		<form method="post" enctype="multipart/form-data">
			<input type="hidden" name="id" value="{$editedProduct->getId()}">
			<div class="form-group">
				<label for="exampleInputEmail1">Название товара:</label>
				<input type="text" name="name" class="form-control" value="{$editedProduct->getName()}">
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Описание товара:</label>
				<textarea class="form-control" name="description">{$editedProduct->getDescription()}</textarea>
			</div>
			<div class="form-group">
				<label>Выберите категорию:</label>
				<select class="form-control" name="category_id">
					<option value="0">Не выбрано</option>
					{assign var=productCategory value=$editedProduct->getCategory()}
					{foreach from=$categories item=i key=k}
						<option {if $i.id == $productCategory->getId()}selected {/if}value="{$i.id}">{$i.name}</option>
					{/foreach}
				</select>
			</div>
			<div class="form-group">
				<label>Ссылка на изображение:</label>
				<input type="text" name="image_url" class="form-control">
			</div>
			<div class="form-group">
				<label>Изображения товара:</label>
				<div class="form-control upload-images">
					<input type="file" name="images[]" accept="image/*" value="" multiple>
					<div class="edit-product-images d-flex">
						{foreach from=$editedProduct->getImages() item=image}
							<div class="border edit-image-item">
								<img height="50" src="{$image->getPath()}" alt="{$image->getName()|strip_tags}"><br>
								<button data-image-id="{$image->getId}" type="button" class="btn btn-danger delete-image btn-sm js-delete-image">Удалить</button>
							</div>
						{/foreach}
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Артикул товара:</label>
				<input type="text" name="article" class="form-control" value="{$editedProduct->getArticle()}">
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Количество товара на складе:</label>
				<input type="text" name="amount" class="form-control" value="{$editedProduct->getAmount()}">
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Цена товара:</label>
				<input type="text" name="price" class="form-control" value="{$editedProduct->getPrice()}">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Отправить</button>
			</div>
		</form>
	</div>
</div>

{include file="bottom.tpl"}