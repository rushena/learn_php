{include file="header.tpl" h1="Список категорий"}

<a href="/categories/add" class="btn btn-success">Добавить новую категорию</a>
<br />
<br />

<table class="table table-striped">
	<thead>
		<tr>
			<th>ID</th>
			<th>Название</th>
			<th></th>				
		</tr>
	</thead>
	<tbody>
		{foreach from=$categories item=e key=k}
			<tr>
				<th width="50">{$e.id}</th>
				<td>{$e.name}</td>
				<td width="230">
					<a href="/categories/edit?id={$e.id}" class="btn btn-info btn-sm">Редактировать</a>
					<form class="d-inline-block remove-product" action="/categories/delete" method="post"><input type="hidden" name="id" value="{$e.id}" /><button type="submit" class="btn btn-danger btn-sm">Удалить</button></form>
				</td>
			</tr>
		{/foreach}
	</tbody>
</table>

{include file="bottom.tpl"}