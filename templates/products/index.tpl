{include file="header.tpl" h1="Список товаров"}

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

{include file="bottom.tpl"}