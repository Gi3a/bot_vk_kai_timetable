<?php

<<<<<<< HEAD
ini_set('display_errors', 1);
=======
ini_set('display_errors', 0);
>>>>>>> 47dcd6f92d43d368c2ce76dffacfcb9d0f5f655d
error_reporting(E_ALL);

function debug($str) {
	echo '<pre>';
	var_dump($str);
	echo '</pre>';
	exit;
}