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
			'countStudents' => $this->model->getCountUsers('student'),
			'countAbiturients' => $this->model->getCountUsers('abiturient'),
			'countTeachers' => $this->model->getCountUsers('teacher'),
			'getNomdenom' => $Nomdenom,
		];
		$this->view->render('Панель управления | КАИ-Восток', $vars);
	}

	public function timetableAction()
	{
		if (!isset($_SESSION['admin']))
			$this->view->redirect('Расписание занятий | КАИ-Восток');

		
		$this->view->render('Panel');
	}

	public function usersAction()
	{
		if (!isset($_SESSION['admin']))
			$this->view->redirect('Расписание занятий | КАИ-Восток');

		
		$this->view->render('Panel');
	}

	public function coursesAction()
	{
		if (!isset($_SESSION['admin']))
			$this->view->redirect('Расписание занятий | КАИ-Восток');

		
		$this->view->render('Panel');
	}

	public function specialitiesAction()
	{
		if (!isset($_SESSION['admin']))
			$this->view->redirect('Расписание занятий | КАИ-Восток');

		
		$this->view->render('Panel');
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