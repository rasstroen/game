<?php
return array(
	'rootPath'      => '/home/sites/game.lj-top.ru/',
	'autoload'      => array(
		'directories'   => array(
			'core',
			'core/Classes',
			'core/Classes/Util',
		)
	),
	'db' => array(
		'web' => array(
			'dsn'       => 'mysql:dbname=game;host=127.0.0.1',
			'username'  => 'root',
			'password'  => '2912',
		),
		'master' => array(
			'dsn'       => 'mysql:dbname=game;host=127.0.0.1',
			'username'  => 'root',
			'password'  => '2912',
		),
	),
	'components'    => require_once 'components.php',
	'bll'           => require_once 'bll.php',
	'routing'       => require_once 'routing.php',
	'libs'  => array(
		'buildings' => require_once 'buildings.php'
	)
);
