{include file="header.tpl" h1="Загрузка файла импорта"}

<div class="row justify-content-center">
    <div class="col col-xl-8 col-lg-10">
        <form method="post" enctype="multipart/form-data" action="/import/upload">
            <div class="form-group">
                <label>Выберите файл:</label>
                <input type="file" name="import_file" class="form-control">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Добавить</button>
            </div>
        </form>
    </div>
</div>

{include file="bottom.tpl"}