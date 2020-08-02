<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{$h1|default:'Добро пожаловать!'}</title>
</head>
<body>

<div class="site-wrapper container-sm">
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark site-top-navbar">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

		<div class="collapse navbar-collapse" id="navbarColor01">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item"><a class="nav-link" href="/products/list">Список товаров</a></li>
				<li class="nav-item"><a class="nav-link" href="/categories/list">Список Категорий</a></li>
				<li class="nav-item"><a class="nav-link" href="/products/">Импорт товаров</a></li>
			</ul>
		</div>
	</nav>
	
	<ul class="nav nav-pills categories-menu">
		{foreach from=$categories item=e key=k}
			<li class="nav-item">
				<a class="btn btn-primary nav-link categories-menu__item{if $e.id === $current_category.id} btn-success{/if}" href="/categories/view?id={$e.id}">{$e.name}</a>
			</li>
		{/foreach}
	</ul>

	<h1 class="site-title">{$h1|default:'Добро пожаловать!'}</h1>