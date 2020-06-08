<?php

return [
	// Requests
	'' => [
		'controller' => 'main',
		'action' => 'bot',
	],
	// Test
	'test' => [
		'controller' => 'main',
		'action' => 'test',
	],
	// Admin
	'login'  => [
		'controller' => 'admin',
		'action' => 'login',
	],
	'panel'  => [
		'controller' => 'admin',
		'action' => 'panel',
	],
	'add/timetable'  => [
		'controller' => 'admin',
		'action' => 'add',
	],
	'delete/timetable/{id:\d+}'  => [
		'controller' => 'admin',
		'action' => 'delete',
	],
	'timetable'  => [
		'controller' => 'admin',
		'action' => 'timetable',
	],
	'timetable/{weekday:\w+}'  => [
		'controller' => 'admin',
		'action' => 'timetable',
	],
	'users'  => [
		'controller' => 'admin',
		'action' => 'users',
	],
	'courses'  => [
		'controller' => 'admin',
		'action' => 'courses',
	],
	'specialities'  => [
		'controller' => 'admin',
		'action' => 'specialities',
	],
	'exit'  => [
		'controller' => 'admin',
		'action' => 'exit',
	],
];