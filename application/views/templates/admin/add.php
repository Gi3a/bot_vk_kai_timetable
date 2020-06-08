<nav>
	<div class="nav__link">
		<select name="course">
			<option <? if($_COOKIE['course'] == 1) echo 'selected' ?> value="1">Ⅰ курс</option>
			<option <? if($_COOKIE['course'] == 2) echo 'selected' ?> value="2">Ⅱ курс</option>
			<option <? if($_COOKIE['course'] == 3) echo 'selected' ?> value="3">Ⅲ курс</option>
			<option <? if($_COOKIE['course'] == 4) echo 'selected' ?> value="4">Ⅳ курс</option>
		</select>
	</div>
	<div class="nav__link">
		<select name="subject">
			<option <? if($_COOKIE['subject'] == 'Экономика') echo 'selected' ?> value="Экономика">📊 Экономика</option>
			<option <? if($_COOKIE['subject'] == 'Приборостроение') echo 'selected' ?> value="Приборостроение">⚙ Приборостроение</option>
			<option <? if($_COOKIE['subject'] == 'Информатика и вычислительная техника') echo 'selected' ?> value="Информатика и вычислительная техника">💻 Информатика и вычислительная техника</option>
		</select>
	</div>
</nav>
<!-- 📋 Расписание
👦 Пользователи
📑 Курсы
📒 Специальности
📜 📑 📒 📓 📔 📕 📖  -->
<form class="page" method="POST" action="/add/timetable">
	<!-- Here output -->
	<div class="nav-fixed">
		<button type="button" class="list__button" id="add_more">Добавить поле ➕</button>
		<button type="submit" class="list__submit">Создать ►</button>
	</div>
</form>



<script type="text/javascript">
	var id = 0;
	// ==============================================================================================
	// on change course
	$("select[name='course']").change(function() { var value = this.value; $.cookie('course', value); location.reload(); });

	// on change speciality
	$("select[name='subject']").change(function() { var value = this.value; $.cookie('subject', value); location.reload(); });
	// ==============================================================================================
	// ==============================================================================================
	// ==============================================================================================

	// Add more
	$("#add_more").click(function() {
		id++;
		var html = $('<div class="weekday">'+
		'<div class="lesson">'+
			'<select name="weekday|'+id+'">'+
				'<option value="Понедельник">Понедельник</option>'+
				'<option value="Вторник">Вторник</option>'+
				'<option value="Среда">Среда</option>'+
				'<option value="Четверг">Четверг</option>'+
				'<option value="Пятница">Пятница</option>'+
				'<option value="Суббота">Суббота</option>'+
			'</select>'+
			'<select name="time|'+id+'">'+
				'<option value="08:15 - 09:45" >08:15 - 09:45</option>'+
				'<option value="09:55 - 11:25" >09:55 - 11:25</option>'+
				'<option value="12:25 - 13:55" >12:25 - 13:55</option>'+
				'<option value="14:05 - 15:35" >14:05 - 15:35</option>'+
				'<option value="15:45 - 17:15" >15:45 - 17:15</option>'+
			'</select>'+
			'<select name="nom_denom|'+id+'">'+
				'<option value="0" >Числитель</option>'+
				'<option value="1" >Знаменатель</option>'+
				'<option value="2" >Общая</option>'+
			'</select>'+
			'<input data-subject="'+id+'"  type="text" name="subject|'+id+'" placeholder="Предмет">'+

			'<input data-teacher="'+id+'" type="text" name="teacher|'+id+'" placeholder="Преподаватель" >'+

			'<input data-cabinet="'+id+'" type="text" name="cabinet|'+id+'" placeholder="Кабинет">'+
		'</div>'+
	'</div>');
     	$(".page").append(html);
	});

	// Change Time
	$("select[name='time']").change(function() {
    	var str = this.value.split('|');
		var arr = {
			'time': str[0],
			'id': str[1],  
			'weekday': str[2], 
		};
		sendValue(arr);
	});

	// Change Nom_denom
	$("select[name='nom_denom']").change(function() {
    	var str = this.value.split('|');
    	var arr = {
			'nom_denom': str[0],
			'id': str[1],  
			'weekday': str[2], 
		};
		sendValue(arr);
	});
	// Change Subject
	$("input[data-subject]").change(function() {
    	var str = $(this).attr('data-subject').split('|');
		var arr = {
			'subject': this.value,
			'id': str[0],  
			'weekday': str[1], 
		};
		sendValue(arr);
	});
	// Change Teacher
	$("input[data-teacher]").change(function() {
    	var str = $(this).attr('data-teacher').split('|');
		var arr = {
			'teacher': this.value,
			'id': str[0],  
			'weekday': str[1], 
		};
		sendValue(arr);
	});
	// Change Cabinet
	$("input[data-cabinet]").change(function() {
    	var str = $(this).attr('data-cabinet').split('|');
		var arr = {
			'cabinet': this.value,
			'id': str[0],  
			'weekday': str[1], 
		};
		sendValue(arr);
	});


	function sendValue(arr)
	{
		switch(arr.weekday)
		{
			case 'Понедельник': weekday = 'monday'; break;
			case 'Вторник': weekday = 'tuesday'; break;
			case 'Среда': weekday = 'wednesday'; break;
			case 'Четверг': weekday = 'thursday'; break;
			case 'Пятница': weekday = 'friday'; break;
			case 'Суббота': weekday = 'saturday'; break;
		}
		$.post("/timetable/"+weekday, {
			post: arr,
		}, function(data,status){
			json = jQuery.parseJSON(data);
			if (json.url) {
				window.location.href = '/' + json.url;
			} else {
				swal(json.status,json.message,json.status);
			}
		});
	}


</script>