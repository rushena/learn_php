{include file="header.tpl" h1="Добавить новую категорию"}

<div class="row justify-content-center">
	<div class="col col-xl-8 col-lg-10">
		<form method="post">
			<div class="form-group">
				<label>Название категории:</label>
				<input type="text" name="name" class="form-control">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Добавить</button>
			</div>
		</form>
	</div>
</div>

{include file="bottom.tpl"}