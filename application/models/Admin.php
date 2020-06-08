<?php

namespace application\models;

use application\core\Model;


class Admin extends Model {

	public $error;

	public function loginValidate($post) {
		$config = require 'application/config/admin.php';
		if ($config['login'] != $post['login'] or $config['password'] != $post['password']) {
			$this->error = 'Логин или пароль указан неверно';
			return false;
		}
		return true;
	}

	public function getCountUsers($role)
	{
		$params = ['role' => $role];
		return $this->db->column('SELECT COUNT(id) FROM bot_users WHERE role = :role', $params);
	}

	public function getNomdenom()
	{
		$params = ['id' => 1];
		return $this->db->column('SELECT nom_denom FROM bot_settings WHERE id = :id', $params);
	}

	public function getTimetable($course, $speciality, $weekday)
	{
		$params = [
			'course' => $course,
			'speciality' => $speciality,
			'weekday' => $weekday,
		];
		return $this->db->row('SELECT id,weekday,nom_denom,time,subject,teacher,cabinet FROM bot_timetables WHERE course = :course AND speciality = :speciality AND weekday = :weekday', $params);
	}

	public function updateTimetable($course, $speciality, $post)
	{
		$params = [
			'course' => $course,
			'speciality' => $speciality,
			'id' => $post['post']['id'],
			'weekday' => $post['post']['weekday'],
		];
		if (isset($post['post']['time']))
		{
			$arr = array('time' => $post['post']['time']);
			$f_params = array_merge($params, $arr);
			$this->db->query('UPDATE bot_timetables SET time = :time WHERE course = :course AND speciality = :speciality AND weekday = :weekday AND id = :id', $f_params);
		}
		else if (isset($post['post']['nom_denom']))
		{
			$arr = array('nom_denom' => $post['post']['nom_denom']);
			$f_params = array_merge($params, $arr);
			$this->db->query('UPDATE bot_timetables SET nom_denom = :nom_denom WHERE course = :course AND speciality = :speciality AND weekday = :weekday AND id = :id', $f_params);
		}
		else if (isset($post['post']['subject']))		
		{
			$arr = array('subject' => $post['post']['subject']);
			$f_params = array_merge($params, $arr);
			$this->db->query('UPDATE bot_timetables SET subject = :subject WHERE course = :course AND speciality = :speciality AND weekday = :weekday AND id = :id', $f_params);
		}
		else if (isset($post['post']['teacher']))
		{
			$arr = array('teacher' => $post['post']['teacher']);
			$f_params = array_merge($params, $arr);
			$this->db->query('UPDATE bot_timetables SET teacher = :teacher WHERE course = :course AND speciality = :speciality AND weekday = :weekday AND id = :id', $f_params);
		}
		else if (isset($post['post']['cabinet']))
		{
			$arr = array('cabinet' => $post['post']['cabinet']);
			$f_params = array_merge($params, $arr);
			$this->db->query('UPDATE bot_timetables SET cabinet = :cabinet WHERE course = :course AND speciality = :speciality AND weekday = :weekday AND id = :id', $f_params);
		}
		return 1;
	}


	public function insertTimetable($course, $speciality, $post)
	{
		// Reform array
		$i = 0; foreach ($post as $key) { $data[$i] = $key; $i++; }
		// Get course and speciality
		$params = [ 'course' => $course, 'speciality' => $speciality, ];
		$i = 0;
		$str = "INSERT INTO bot_timetables (id, course, speciality, weekday, nom_denom, time, subject, teacher, cabinet) VALUES ";
		while ($i < count($data)) // 0 < 18
		{
			//        id        course       speciality     weekday      nom_denom        time          subject        teacher
			$str .= "('0', '{$course}', '{$speciality}', '{$data[$i]}', '{$data[$i+2]}', '{$data[$i+1]}', '{$data[$i+3]}', '{$data[$i+4]}', '{$data[$i+5]}'),";
			$i=$i+6;
		}
		
		$str = substr($str,0,-1);
		$str.=";";

		$this->db->query(''.$str.'');
		return $this->db->lastInsertId();
		
	}

	public function deleteTimetable($course, $speciality, $id)
	{
		$params = [ 'course' => $course, 'speciality' => $speciality, 'id' => $id ];
		$this->db->query('DELETE FROM bot_timetables WHERE course = :course AND speciality = :speciality AND id = :id',$params);
	}

}