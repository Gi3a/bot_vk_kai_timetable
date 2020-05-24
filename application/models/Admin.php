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
}