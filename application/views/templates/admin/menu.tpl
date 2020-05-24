
<!-- <span class="btn__menu" for="btnMenu">☰</span> -->
<input type="checkbox" id="btnMenu">

<div class="block__menu" for="btnMenu">
	<div class="menu__top">
		<a href="/panel" class="unhover"><img src="/public/img/logo.png"></a>
		<a href="/panel" <?php if($this->route['action'] == 'panel') echo 'class="active"' ?>>
			💻 Главная
		</a>
		<a href="/timetable" <?php if($this->route['action'] == 'timetable') echo 'class="active"' ?>>
			📋 Расписание
		</a>
		<a href="/users" <?php if($this->route['action'] == 'users') echo 'class="active"' ?>>
			👦 Пользователи
		</a>
		<a href="/courses" <?php if($this->route['action'] == 'courses') echo 'class="active"' ?>>
			📑 Курсы
		</a>
		<a href="/specialities" <?php if($this->route['action'] == 'specialities') echo 'class="active"' ?>>
			📒 Специальности
		</a>
	</div>
	<!--  📜 📑 📒 📓 📔 📕 📖 -->
	<div class="menu__bottom">
		<a href="/exit">➡ Выход</a>
	</div>
</div>

			 