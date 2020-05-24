<?php

namespace application\core;

class View {

	public $path;
	public $route;
<<<<<<< HEAD
	public $layout = 'default';
=======
	public $layout = 'console';
>>>>>>> 47dcd6f92d43d368c2ce76dffacfcb9d0f5f655d

	public function __construct($route) {
		$this->route = $route;
		$this->path = $route['controller'].'/'.$route['action'];
	}

<<<<<<< HEAD
	public function render($title, $vars = []) {
		extract($vars);
		$path = 'application/views/templates/'.$this->path.'.php';
		if (file_exists($path)) {
			ob_start();
			require $path;
			$content = ob_get_clean();
			require 'application/views/layouts/'.$this->layout.'.php';
		}
	}

	public function redirect($url) {
		header('location: /'.$url);
		exit;
	}

=======
>>>>>>> 47dcd6f92d43d368c2ce76dffacfcb9d0f5f655d
	public static function errorCode($code) {
		http_response_code($code);
		$path = 'application/views/templates/errors/'.$code.'.php';
		if (file_exists($path)) {
			require $path;
		}
		exit;
	}

<<<<<<< HEAD
	public function message($status, $message) {
		exit(json_encode(['status' => $status, 'message' => $message]));
	}

	public function location($url) {
		exit(json_encode(['url' => $url]));
	}

	public function teleport($status, $url, $message){
		exit(json_encode(['status' => $status, 'url' => $url, 'message' => $message]));
	}


=======
>>>>>>> 47dcd6f92d43d368c2ce76dffacfcb9d0f5f655d
}	