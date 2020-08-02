{include file="header.tpl" h1="Список товаров"}

<a href="/products/add" class="btn btn-success">Добавить новый товар</a>
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
				<th width="50">{$e.id}</th>
				<td>{$e.name}</td>
				<td>{$e.description}</td>
				<td>{$e.article}</td>
				<td>{$e.category_name}</td>
				<td>{$e.amount}</td>
				<td>{$e.price}</td>
				<td width="230">
					<a href="/products/edit?id={$e.id}" class="btn btn-info btn-sm">Редактировать</a>
					<form class="d-inline-block remove-product" action="/products/delete" method="post"><input type="hidden" name="id" value="{$e.id}" /><button type="submit" class="btn btn-danger btn-sm">Удалить</button></form>
				</td>
			</tr>
		{/foreach}
	</tbody>
</table>
{if $pages_count > 1}
	<nav>
		<ul class="pagination">
			{section name=pagination loop=$pages_count}
				{assign var=cur_iter value=$smarty.section.pagination.iteration}
				{if ($cur_iter == $smarty.get.p) || (!$smarty.get.p && $cur_iter === 1)}
					<li class="page-item active" aria-current="page"><span class="page-link">{$cur_iter}</span></li>
				{else}
					<li class="page-item"><a class="page-link" href="{$smarty.server.PATH_INFO}?p={$cur_iter}">{$cur_iter}</a></li>
				{/if}
			{/section}
		</ul>
	</nav>
{/if}

{include file="bottom.tpl"}