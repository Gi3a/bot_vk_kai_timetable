<?php

namespace application\models;

use application\core\Model;
use VK\Client\Enums\VKLanguage;
use VK\Client\VKApiClient;

class Bot extends Model {
	// Users
	public function getUserVK($user_id)
	{
		return json_decode(file_get_contents('https://api.vk.com/method/users.get?user_id='.$user_id.'&v=5.103&access_token='.VK_TOKEN));
	}
	// Messages
	public function sendMessage($user_id, $message, $keyboard)
	{
		$params = array(
			'peer_id' => $user_id,
			'message' => $message,
			'access_token' => VK_TOKEN,
			'v' => '5.103',
			'random_id' => '0',
			'keyboard' => json_encode($keyboard, JSON_UNESCAPED_UNICODE)
		);
		file_get_contents('https://api.vk.com/method/messages.send?'.http_build_query($params));
	}
	/* --------------------- User Function ----------------------------- */

	public function getUser($user_id)
	{
		$params = ['user_id' => $user_id];
		return $this->db->row('SELECT id, first_name, last_name, course, speciality, role FROM bot_users WHERE user_id = :user_id', $params);
	}

	public function getUserId($user_id)
	{
		$params = ['user_id' => $user_id];
		return $this->db->column('SELECT id FROM bot_users WHERE user_id = :user_id', $params);
	}

	public function getUserCourse($user_id)
	{
		$params = ['user_id' => $user_id];
		return $this->db->column('SELECT course FROM bot_users WHERE user_id = :user_id', $params);
	}

	public function getUserSpeciality($user_id)
	{
		$params = ['user_id' => $user_id];
		return $this->db->column('SELECT speciality FROM bot_users WHERE user_id = :user_id', $params);
	}

	public function getUserRole($user_id)
	{
		$params = ['user_id' => $user_id];
		return $this->db->column('SELECT role FROM bot_users WHERE user_id = :user_id', $params);
	}

	public function getUserInfo($user_id)
	{
		$params = ['user_id' => $user_id];
		return $this->db->row('SELECT role, course, speciality FROM bot_users WHERE user_id = :user_id', $params);
	}

	public function setLog($user_id, $first_name, $last_name, $course, $speciality, $role, $message)
	{
		$params = [
			'id' => '0',
			'user_id' => $user_id,
			'first_name' => $first_name,
			'last_name' => $last_name,
			'role' => $role,
			'course' => $course,
			'speciality' => $speciality,
			'query' => $message,
			'date_query' => date("Y-m-d H:i"),
		];
		$this->db->query('INSERT INTO bot_logs VALUES (:id, :user_id, :first_name, :last_name, :role, :course, :speciality, :query, :date_query)', $params);
	}

	public function createUser($user_id, $role, $course, $speciality)
	{
		$user_vk = $this->getUserVK($user_id);
		$params = [
			'id' => '0',
			'user_id' => $user_id,
			'first_name' => $user_vk->response[0]->first_name,
			'last_name' => $user_vk->response[0]->last_name,
			'role' => $role,
			'course' => $course,
			'speciality' => $speciality
		];
		$this->db->query('INSERT INTO bot_users VALUES (:id, :user_id, :first_name, :last_name, :role, :course, :speciality)', $params);
		return $this->db->lastInsertId();
	}

	public function resetUserCourse($user_id)
	{
		$params = ['user_id' => $user_id];
		$this->db->query('UPDATE bot_users SET course = NULL WHERE user_id = :user_id', $params);
	}

	public function resetUserSpeciality($user_id)
	{
		$params = ['user_id' => $user_id];
		$this->db->query('UPDATE bot_users SET speciality = NULL WHERE user_id = :user_id', $params);
	}

	public function deleteUser($user_id)
	{
		$params = ['user_id' => $user_id];
		$this->db->query('DELETE FROM bot_users WHERE user_id = :user_id',$params);
	}

	public function setUserNames($user_id)
	{
		$user_vk = $this->getUserVK($user_id);
		$params = [
			'user_id' => $user_id,
			'first_name' => $user_vk->response[0]->first_name,
			'last_name' => $user_vk->response[0]->last_name
		];
		$this->db->query('UPDATE bot_users SET first_name = :first_name, last_name = :last_name WHERE user_id = :user_id', $params);
	}

	public function updateUserRole($user_id, $role)
	{
		if (($role != "student") && ($role != "teacher") && ($role != "abiturient")) {$role = NULL;}
		$params = [
			'user_id' => $user_id,
			'role' => $role
		];
		$this->db->query('UPDATE bot_users SET role = :role WHERE user_id = :user_id', $params);
	}

	public function switchCourse($course){
		switch($course){
			case "Ⅰ курс":
				$course = 1;
				break;
			case "Ⅱ курс":
				$course = 2;
				break;
			case "Ⅲ курс":
				$course = 3;
				break;
			case "Ⅳ курс":
				$course = 4;
				break;
			case "Абитуриент":
				$course = "abiturient";
				break;
			default:
				$course = NULL;
				break;
		}
		return $course;
	}

	public function switchSpeciality($speciality){
		switch ($speciality) {
			case '⚙ Приборостроение':
				$speciality = 'Приборостроение';
				break;
			case '💻 Информатика и вычислительная техника':
				$speciality = 'Информатика и вычислительная техника';
				break;
			case '📊 Экономика':
				$speciality = 'Экономика';
				break;
			default:
				$speciality = NULL;
				break;
		}
		return $speciality;
	}

	public function switchDay($day){
		switch($day)
		{
			case 'Monday': $weekday = 'Понедельник'; break;
			case 'Tuesday': $weekday = 'Вторник'; break;
			case 'Wednesday': $weekday = 'Среда'; break;
			case 'Thursday': $weekday = 'Четверг'; break;
			case 'Friday': $weekday = 'Пятница'; break;
			case 'Saturday': $weekday = 'Суббота'; break;
			case 'Sunday': $weekday = 'Воскресенье'; break;
		}
		return $weekday;
	}

	public function updateUserCourse($user_id, $course)
	{
		$course = $this->switchCourse($course);
		$params = [
			'user_id' => $user_id,
			'course' => $course
		];
		$this->db->query('UPDATE bot_users SET course = :course WHERE user_id = :user_id', $params);
	}

	public function updateUserSpeciality($user_id, $speciality)
	{
		$speciality = $this->switchSpeciality($speciality);
		$params = [
			'user_id' => $user_id,
			'speciality' => $speciality
		];
		$this->db->query('UPDATE bot_users SET speciality = :speciality WHERE user_id = :user_id', $params);
	}
	/* --------------------- FAQ ----------------------------- */
	public function getFaq($id)
	{
		return $this->db->row('SELECT * FROM bot_faq');
	}
	public function addFaq($user_id, $message)
	{
		$user_vk = $this->getUserVK($user_id);
		$params = [
			'id' => '0',
			'user_id' => $user_id,
			'first_name' => $user_vk->response[0]->first_name,
			'last_name' => $user_vk->response[0]->last_name,
			'question' => mb_substr($message, 2),
			'answer' => NULL
		];
		$this->db->query('INSERT INTO bot_faq VALUES (:id, :user_id, :first_name, :last_name, :question, :answer)', $params);
		return $this->db->lastInsertId();
	}
	/* --------------------- TimeTables ----------------------------- */
	public function getTimetables($id, $first_name, $last_name, $role, $course, $speciality, $date, $nom_denom)
	{
		$user_id = $id;

		if ($date == '▲ Сегодня' || $date == '► Завтра')
		{
			if ($date == "▲ Сегодня")
				$day = date("l");
			else if ($date == "► Завтра")
				$day = date("l",strtotime("+1 day"));
			else
				return (0);

			$weekday = $this->switchDay($day);
		}
		else
		{
			if ($date == '► Понедельник' || $date == '► Вторник' || $date == '► Среда'
				|| $date == '► Четверг' || $date == '► Пятница' || $date == '► Суббота')
				$weekday = str_replace('► ', '', $date);
			else
				return (0);
		}
		if ($role == "student" || $role == "admin"){
			$params = [
				'course' => $course,
				'speciality' => $speciality,
				'weekday' => $weekday,
				'nom_denom' => intval($nom_denom),
			];
			return $this->db->row('SELECT subject, time, teacher, cabinet FROM bot_timetables WHERE (course = :course) AND (speciality = :speciality) AND (weekday = :weekday) AND ((nom_denom = :nom_denom) OR (nom_denom = 2))', $params);
		}
		else if ($role == "teacher")
		{
			$params = [
				'teacher' => "%".$first_name ." ". $last_name."%",
				'weekday' => $weekday,
				'nom_denom' => intval($nom_denom),
			];
			return $this->db->row('SELECT subject, time, teacher, cabinet FROM bot_timetables WHERE (teacher LIKE :teacher) AND (weekday = :weekday) AND ((nom_denom = :nom_denom) OR (nom_denom = 2))', $params);
		}
	}

	public function getNomDenom()
	{
		$nom_denom = $this->db->row('SELECT nom_denom, date FROM bot_settings WHERE id = 1');

		$date_db = $nom_denom[0]['date'];
		$date_current = date('Y-m-d');

		if ($date_db >= $date_current)
		{
			$nom = $nom_denom;
		}
		else
		{
			$date_db = strtotime($date_db);
			$updated_date = strtotime('+7 day', $date_db);
			$update_date = date('Y-m-d', $updated_date);

			if ($nom_denom[0]['nom_denom'] == '0') $update_nom_denom = '1';
			else $update_nom_denom = '0';

			$params = [
				'nom_denom' => $update_nom_denom,
				'date' => $update_date,
			];
			$this->db->query('UPDATE bot_settings SET date = :date, nom_denom = :nom_denom WHERE id = 1', $params);
			$nom = $this->db->row('SELECT nom_denom, date FROM bot_settings WHERE id = 1');
		}

		return $nom[0]['nom_denom'];
	}


	/* --------------------- Keyboards Keyboard Keyboard ----------------------------- */
	public function getBtn($label, $color, $payload)
	{
	    return [
	        'action' => [
	            'type' => 'text',
	            "payload" => json_encode($payload, JSON_UNESCAPED_UNICODE),
	            'label' => $label
	        ],
	        'color' => $color
	    ];
	}

	public function getKeyboardCourse($user_id)
		{
			$keyboard = [
					'one_time' => true,
					'buttons'=> [
						[
							$this->getBtn("Ⅰ курс", 'primary', 'set_course'),
							$this->getBtn("Ⅱ курс", 'positive', 'set_course'),
							$this->getBtn("Ⅲ курс", 'primary', 'set_course'),
							$this->getBtn("Ⅳ курс", 'positive', 'set_course'),
						],
						[
							$this->getBtn("🎒 Абитуриент", 'negative', 'set_abiturient'),
						]
					]
				];
			$this->sendMessage($user_id, 'Выберите:', $keyboard);
		}

	public function getKeyboardSpeciality($user_id)
	{
		$keyboard = [
			'one_time' => true,
			'buttons'=> 
				[
					[$this->getBtn("⚙ Приборостроение", 'primary', 'set_speciality')],
					[$this->getBtn("💻 Информатика и вычислительная техника", 'positive', 'set_speciality')],
					[$this->getBtn("📊 Экономика", 'primary', 'set_speciality')],
				]
			];
		$this->sendMessage($user_id, 'Выберите направление:', $keyboard);
	}

	public function getKeyboardTimeWeek($user_id)
	{
		$keyboard = [
				'one_time' => false,
				'buttons'=> [
					[
						$this->getBtn("► Понедельник", 'primary', 'timetable_week_day'),
						$this->getBtn("► Четверг", 'positive', 'timetable_week_day'),
					],
					[
						$this->getBtn("► Вторник", 'positive', 'timetable_week_day'),
						$this->getBtn("► Пятница", 'primary', 'timetable_week_day'),
					],
					[
						$this->getBtn("► Среда", 'primary', 'timetable_week_day'),
						$this->getBtn("► Суббота", 'positive', 'timetable_week_day'),
					],
					[$this->getBtn("▼ Вернуться", 'negative', 'back_to_student')],
				]
			];
		$this->sendMessage($user_id, 'Получить расписание:', $keyboard);
	}

	public function getKeyboardAbiturient($user_id)
	{
		$keyboard = [
				'one_time' => false,
				'buttons'=> [
						[$this->getBtn("🧾 Стоимость обучения", 'positive', 'abiturient_cost_edu')],
						[$this->getBtn("📑 План приема", 'primary', 'abiturient_plan_edu')],
						[$this->getBtn("🏫 Общежития", 'positive', 'abiturient_hostel_edu')],
						[$this->getBtn("📋 Списки поступающих", 'primary', 'abiturient_list_edu')],
					[	
						$this->getBtn("❓ Вопросы", 'positive', 'abiturient_faq_edu'),
						$this->getBtn("+ Добавить вопрос", 'positive', 'abiturient_question_edu'),
					],
						// ❔❕❓❗⁉‼❌⭕
						[$this->getBtn("► Выбрать курс", 'negative', 'change_course'),],
				]
			];
		$this->sendMessage($user_id, 'Получить информацию:', $keyboard);
	}

	public function getKeyboardQuestion($user_id)
	{
		$keyboard = [
				'one_time' => false,
				'buttons'=>
					[
						// ❔❕❓❗⁉‼❌⭕
						[$this->getBtn("▼ Вернуться", 'negative', 'back_to_abiturient')],
					]
			];
		$this->sendMessage($user_id, '
				Введите вопрос используя /+
				Пример: /+Стоимость обучения
			', $keyboard);
	}

	public function getKeyboardStudent($user_id)
	{
		$keyboard = [
				'one_time' => false,
				'buttons'=> [
					[
						$this->getBtn("▲ Сегодня", 'primary', 'timetable_week_day'),
						$this->getBtn("► Завтра", 'positive', 'timetable_week_day'),
						$this->getBtn("►► Неделю", 'primary', 'timetable_week'),
					],
					[
						$this->getBtn("📚 Изменить курс", 'negative', 'change_course'),
						$this->getBtn("🧭 Изменить направление", 'negative', 'change_speciality')
					],
				]
			];
		$this->sendMessage($user_id, 'Получить расписание:', $keyboard);
	}

	public function getKeyboardTeacher($user_id)
	{
		$keyboard = [
				'one_time' => false,
				'buttons'=> [
					[
						$this->getBtn("▲ Сегодня", 'primary', 'timetable_week_day_teacher'),
						$this->getBtn("► Завтра", 'positive', 'timetable_week_day_teacher'),
						$this->getBtn("►► Неделю", 'primary', 'timetable_week_teach'),
					],
				]
			];
		$this->sendMessage($user_id, 'Получить расписание:', $keyboard);
	}



}