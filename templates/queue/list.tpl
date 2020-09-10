{include file="header.tpl" h1="Список задач"}
{*
<a href="/products/add" class="btn btn-success">Добавить новый товар</a>
<br />
<br />
*}

<table class="table table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Статус</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    {foreach from=$tasks item=e key=k}
        <tr>
            <th width="50">{$e.id}</th>
            <td>
                {$e.name}
            </td>
            <td>
                {$e.status}
            </td>
            <td width="230">
                <a href="/queue/run?id={$e.id}" class="btn btn-info btn-sm">Запустить</a>
                <a href="/queue/dele?id={$e.id}" class="btn btn-danger btn-sm">Удалить</a>
            </td>
        </tr>
    {/foreach}
    </tbody>
</table>

{include file="bottom.tpl"}