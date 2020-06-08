<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;
use application\models\Admin;
use application\models\Main;
use application\models\Bot;

class AdminController extends Controller
{
	public function loginAction()
	{
		if (isset($_SESSION['admin']))
			$this->view->redirect('panel');
		if (!empty($_POST))
		{
			if (!$this->model->loginValidate($_POST)) {
				$this->view->message('error', $this->model->error);
			}
			$_SESSION['admin'] = true;
			$this->view->teleport('success','panel', 'Добро пожаловать!');
		}
		$this->view->render('Вход | КАИ-Восток');
	}


	public function panelAction()
	{
		if (!isset($_SESSION['admin']))
			$this->view->redirect('login');

		if ($this->model->getNomdenom() == 0) $Nomdenom = "числитель";
		else $Nomdenom = "знаменатель";

		$vars = [
			
			'getNomdenom' => $Nomdenom,
		];
		$this->view->render('Панель управления | КАИ-Восток', $vars);
	}

	public function timetableAction()
	{
		// if you see this code, do not call me a govnokoder, there was little time and no desire
		if (!isset($_SESSION['admin']))
			$this->view->redirect('login');

		if((!isset($_COOKIE['course'])) || (!isset($_COOKIE['subject'])))
			$this->view->redirect('panel');

		if (($_SERVER['REQUEST_METHOD'] == 'POST') && (!empty($_POST)))
		{
			if((!isset($_COOKIE['course'])) || (!isset($_COOKIE['subject'])))
				$this->view->message('error', 'Не задан курс или специальность', 'Попробуйте начать со страницы panel');
			
			$status = $this->model->updateTimetable($_COOKIE['course'],$_COOKIE['subject'], $_POST);
			if($status == 1)
				$this->view->message('success', 'Изменения сохранены!', '');
			else
				$this->view->message('error', 'Произошла ошибка!', '');
		}

		$monday = $this->model->getTimetable($_COOKIE['course'], $_COOKIE['subject'], 'Понедельник');
		$tuesday = $this->model->getTimetable($_COOKIE['course'], $_COOKIE['subject'], 'Вторник');
		$wednesday = $this->model->getTimetable($_COOKIE['course'], $_COOKIE['subject'], 'Среда');
		$thursday = $this->model->getTimetable($_COOKIE['course'], $_COOKIE['subject'], 'Четверг');
		$friday = $this->model->getTimetable($_COOKIE['course'], $_COOKIE['subject'], 'Пятница');
		$saturday = $this->model->getTimetable($_COOKIE['course'], $_COOKIE['subject'], 'Суббота');

		$week = array($monday, $tuesday, $wednesday, $thursday, $friday, $saturday);

		$vars = [
			'week' => $week,
			// 'monday' => $this->model->getTimetable($_COOKIE['course'], $_COOKIE['subject'], 'Понедельник'),
			// 'tuesday' => $this->model->getTimetable($_COOKIE['course'], $_COOKIE['subject'], 'Вторник'),
			// 'wednesday' => $this->model->getTimetable($_COOKIE['course'], $_COOKIE['subject'], 'Среда'),
			// 'thursday' => $this->model->getTimetable($_COOKIE['course'], $_COOKIE['subject'], 'Четверг'),
			// 'friday' => $this->model->getTimetable($_COOKIE['course'], $_COOKIE['subject'], 'Пятница'),
			// 'saturday' => $this->model->getTimetable($_COOKIE['course'], $_COOKIE['subject'], 'Суббота'),
		];
		
		$this->view->render('Panel', $vars);
	}

	public function addAction()
	{
		// if you see this code, do not call me a govnokoder, there was little time and no desire
		if (!isset($_SESSION['admin']))
			$this->view->redirect('login');

		if((!isset($_COOKIE['course'])) || (!isset($_COOKIE['subject'])))
			$this->view->redirect('panel');

		if (($_SERVER['REQUEST_METHOD'] == 'POST') && (!empty($_POST)))
		{
			if((!isset($_COOKIE['course'])) || (!isset($_COOKIE['subject'])))
				$this->view->message('error', 'Не задан курс или специальность', 'Попробуйте начать со страницы panel');
			
			$status = $this->model->insertTimetable($_COOKIE['course'],$_COOKIE['subject'], $_POST);
			if(!empty($status))
				$this->view->teleport(
					'success', // Type
					'add/timetable', // URL
					'Расписание добавлено успешно', // Title
					'' // Text
				);
			else
				$this->view->teleport(
					'error', // Type
					'add/timetable', // URL
					'Произошла ошибка', // Title
					'' // Text
				);


		}
		$this->view->render('Panel');
	}

	public function deleteAction()
	{
		// if you see this code, do not call me a govnokoder, there was little time and no desire
		if (!isset($_SESSION['admin']))
			$this->view->redirect('login');

		if((!isset($_COOKIE['course'])) || (!isset($_COOKIE['subject'])))
			$this->view->redirect('panel');

		if (($_SERVER['REQUEST_METHOD'] == 'POST') && (!empty($_POST)))
		{
			$status = $this->model->deleteTimetable($_COOKIE['course'],$_COOKIE['subject'], $_POST['id']);
		}
	}

	
	public function exitAction()
	{
		if (!isset($_SESSION['admin']))
			$this->view->redirect('login');
		else
		{
			unset($_SESSION['admin']);
			$this->view->redirect('login');
		}
	}
}