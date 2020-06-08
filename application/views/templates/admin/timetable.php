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
<div class="page">

	<!-- Weekdays -->
	<?php foreach ($week as $weekday => $val): ?>
	<div class="weekday">
		<span>
			<?php switch($weekday){
				case 0: echo "Понедельник";break;
				case 1: echo "Вторник";break;
				case 2: echo "Среда";break;
				case 3: echo "Четверг";break;
				case 4: echo "Пятница";break;
				case 5: echo "Суббота";break;
				default: echo "Не найдено";break;
			} ?>
		</span>
		<?php if (empty($val)): ?>
			<?php echo 'Нет пар' ?>
		<?php else: ?>
		<?php foreach ($val as $val): ?>
			<div class="lesson">
				<select name="time">
					<option value="08:15 - 09:45|<? echo $val['id']?>|<? echo $val['weekday'] ?>" <? if($val['time'] == '08:15 - 09:45') echo 'selected'; ?>>08:15 - 09:45</option>
					<option value="09:55 - 11:25|<? echo $val['id']?>|<? echo $val['weekday'] ?>" <? if($val['time'] == '09:55 - 11:25') echo 'selected'; ?>>09:55 - 11:25</option>
					<option value="12:25 - 13:55|<? echo $val['id']?>|<? echo $val['weekday'] ?>" <? if($val['time'] == '12:25 - 13:55') echo 'selected'; ?>>12:25 - 13:55</option>
					<option value="14:05 - 15:35|<? echo $val['id']?>|<? echo $val['weekday'] ?>" <? if($val['time'] == '14:05 - 15:35') echo 'selected'; ?>>14:05 - 15:35</option>
					<option value="15:45 - 17:15|<? echo $val['id']?>|<? echo $val['weekday'] ?>" <? if($val['time'] == '15:45 - 17:15') echo 'selected'; ?>>15:45 - 17:15</option>
				</select>
				<select name="nom_denom">
					<option value="0|<? echo $val['id']?>|<? echo $val['weekday'] ?>" <? if($val['nom_denom'] == '0') echo 'selected'; ?>>Числитель</option>
					<option value="1|<? echo $val['id']?>|<? echo $val['weekday'] ?>" <? if($val['nom_denom'] == '1') echo 'selected'; ?>>Знаменатель</option>
					<option value="2|<? echo $val['id']?>|<? echo $val['weekday'] ?>" <? if($val['nom_denom'] == '2') echo 'selected'; ?>>Общая</option>
				</select>

				<input data-subject="<? echo $val['id']?>|<? echo $val['weekday'] ?>"  type="text" name="subject" placeholder="Предмет" value="<? echo $val['subject'] ?>">

				<input data-teacher="<? echo $val['id']?>|<? echo $val['weekday'] ?>" type="text" name="teacher" placeholder="Преподаватель" value="<? echo $val['teacher'] ?>">

				<input data-cabinet="<? echo $val['id']?>|<? echo $val['weekday'] ?>" type="text" name="cabinet" placeholder="Кабинет" value="<? echo $val['cabinet'] ?>">
				<a data-delete="<? echo $val['id'] ?>" title="Удалить">✖</a>
			</div>
		<?php endforeach; ?>
		<?php endif; ?>
	</div>
	<?php endforeach ?>

</div>

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

<script type="text/javascript">
	// ==============================================================================================
	// on change course
	$("select[name='course']").change(function() { var value = this.value; $.cookie('course', value); location.reload(); });

	// on change speciality
	$("select[name='subject']").change(function() { var value = this.value; $.cookie('subject', value); location.reload(); });
	// ==============================================================================================
	// ==============================================================================================
	// ==============================================================================================

	// On Delete
	$("a[data-delete]").click(function() {
		var id = $(this).data("delete");
		swal({
			title: "Вы уверены?",
			text: "",
			icon: "warning",
			buttons: {
				confirm: "Удалить ✔",
				cancel: "Отмена ✖",
			},
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.post("/delete/timetable/"+id, {
					id: id,
				}, function(data,status){
					json = jQuery.parseJSON(data);
					if (json.url) {
						window.location.href = '/' + json.url;
					} else {
						swal(json.status,json.message,json.status);
						block.remove().attr('data-id');
					}
				});
				$(this).parent().remove();
			}
		});
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