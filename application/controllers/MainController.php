<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;
use application\models\Main;
use application\models\Bot;

use VK\Client\Enums\VKLanguage;
use VK\Client\VKApiClient;

class MainController extends Controller {
	
	public function __construct($route) {
		parent::__construct($route);
		$this->view->layout = 'console';
	}

	public function botAction() {
		$bot = new Bot;
		$vk = new VKApiClient('5.103');
		$data = json_decode(file_get_contents('php://input'));


		if ($data->type == 'confirmation') { echo VK_CONFIRM;}
		//else if ($date->type == 'message_reply')
		else if ($data->type == 'message_new')
		{
			$user_id = $data->object->message->from_id;
			$message = $data->object->message->text;

			// Get Info from DB
			$bot_user = $bot->getUser($user_id);
			if ($bot_user != NULL)
			{
				$bot_id = $bot_user[0]['id'];
				$bot_first_name = $bot_user[0]['first_name'];
				$bot_last_name = $bot_user[0]['last_name'];
				$bot_course = $bot_user[0]['course'];
				$bot_speciality = $bot_user[0]['speciality'];
				$bot_role = $bot_user[0]['role'];
			}


			$bot_nom_denom = $bot->getNomDenom();



			if (!empty($data->object->message->payload))
			{
				$payload = $data->object->message->payload;
				$payload = json_decode($payload, true);

				if ($bot_first_name == NULL || $bot_last_name == NULL)
					$bot->setUserNames($user_id);

				switch ($payload)
				{
					// === Set Course ===
					case 'set_course':
						$bot->updateUserCourse($user_id, $message);
						if ($bot_speciality == NULL)
							$bot->getKeyboardSpeciality($user_id);
						else
							$bot->getKeyboardStudent($user_id);
						break;

					// === Set Speciality ===
					case 'set_speciality':
						$bot->updateUserSpeciality($user_id, $message);
						$bot->getKeyboardStudent($user_id);
						break;

					// === Change Course ===
					case 'change_course':
						$bot->resetUserCourse($user_id);
						$bot->getKeyboardCourse($user_id);
						break;

					// === Change Speciality ===
					case 'change_speciality':
						$bot->resetUserSpeciality($user_id);
						$bot->getKeyboardSpeciality($user_id);
						break;

					// === Back to Student Keybaord ===
					case 'back_to_student':
						$bot->getKeyboardStudent($user_id);
						break;

					// === Get keybaord timetable for week ===
					case 'timetable_week':
						$bot->getKeyboardTimeWeek($user_id);
						break;

					// === Get timetable for day ===
					case 'timetable_week_day':
						$timetable = $bot->getTimetables($bot_id, $bot_course, $bot_speciality, $message, $bot_nom_denom);
						if (empty($timetable)) {
							$bot->sendMessage($user_id, "Пар нет", false);
						}
						else
						{
							$bot->sendMessage($user_id, $message, false);
							foreach ($timetable as $key => $value) {
								if (!empty($value['teacher']))
								{
									$bot->sendMessage($user_id, 
										' _________________<br>'.
										"[ ".$value['time']." ]<br>".
										"▶ ".$value['subject']."<br>".
										"✦ ".$value['teacher']."<br>".
										"[ ".$value['cabinet']." ]<br>"
									, false);
								}
								else
								{
									$bot->sendMessage($user_id, 
										'_________________<br>'.
										"[ ".$value['time']." ]<br>".
										"▶ ".$value['subject']."<br>"
									, false);
								}
							}
						}
						break;
				}
			}
			else
			{
				// IF (no_user) {Create it}
				if (!$bot_user)
				{
					$bot->createUser($user_id, 'student', NULL, NULL);
					$bot->getKeyboardCourse($user_id);
				}
				else if ($bot_course == NULL)
					$bot->getKeyboardCourse($user_id);

				else if ($bot_speciality == NULL)
					$bot->getKeyboardSpeciality($user_id);

				else if ($bot_first_name == NULL || $bot_last_name == NULL)
					$bot->setUserNames($user_id);

				else if ($bot_id && $bot_course != NULL && $bot_speciality != NULL)
					$bot->getKeyboardStudent($user_id);
			}
		}
		echo "ok";
	}

	public function testAction()
	{
		$bot = new Bot;
		echo $bot->getNomDenom();
	}
	

}