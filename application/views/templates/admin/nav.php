<nav>
	<div class="nav__link <? if($this->route['action'] == 'panel') echo "active" ?>">
		<a href="/panel">💻 Главная</a>
	</div>
	<div class="nav__link nav__logo">
		<a href="/panel"><img class="header__logo" src="/public/img/logo.jpg" alt="logotype"></a>
	</div>
	<div class="nav__link">
		<a href="/exit">► Выход</a>
	</div>
</nav>

<!-- 
💻 Главная
📋 Расписание
👦 Пользователи
📑 Курсы
📒 Специальности
📜 📑 📒 📓 📔 📕 📖 
<a href="/exit">➡ Выход</a>
-->