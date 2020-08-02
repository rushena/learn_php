{include file="header.tpl" h1="Редактировать категорию"}

<div class="row justify-content-center">
	<div class="col col-xl-8 col-lg-10">
		<form method="post">
			<input type="hidden" name="id" value="{$editedCategory.id}">
			<div class="form-group">
				<label>Название товара:</label>
				<input type="text" name="name" class="form-control" value="{$editedCategory.name}">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Отправить</button>
			</div>
		</form>
	</div>
</div>

{include file="bottom.tpl"}