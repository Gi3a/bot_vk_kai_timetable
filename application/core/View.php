<?php

namespace application\core;

class View {

	public $path;
	public $route;
	public $layout = 'console';

	public function __construct($route) {
		$this->route = $route;
		$this->path = $route['controller'].'/'.$route['action'];
	}

	public static function errorCode($code) {
		http_response_code($code);
		$path = 'application/views/templates/errors/'.$code.'.php';
		if (file_exists($path)) {
			require $path;
		}
		exit;
	}

}	