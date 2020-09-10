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
			<th>Кол-во</th>
			<th>Цена</th>
			<th></th>				
		</tr>
	</thead>
	<tbody>
		{foreach from=$products item=e key=k}
			<tr>
				<th width="50">{$e->getId()}</th>
				<td>
					{$e->getName()}
					<br><br>
					{foreach from=$e->getImages() item=image}
						<img height="50" src="{$image->getPath()}" class="img-thumbnail product-list-image">
					{/foreach}
				</td>
				<td>
					{assign var=productCategory value=$e->getCategory()}
					{assign var=productCategoryName value=$productCategory->getName()}
					{if $productCategoryName}<b>Категория: {$productCategoryName}</b><br>{/if}
					<b>Артикул: {$e->getArticle()}</b><br><br>
					{$e->getDescription()|nl2br}
				</td>
				<td>{$e->getAmount()}</td>
				<td>{$e->getPrice()}</td>
				<td width="230">
					<a href="/products/edit/{$e->getId()}" class="btn btn-info btn-sm">Редактировать</a>
					<form class="d-inline-block remove-product" action="/products/delete" method="post"><input type="hidden" name="id" value="{$e->getId()}" /><button type="submit" class="btn btn-danger btn-sm">Удалить</button></form>
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