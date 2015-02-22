<?php defined('SYSPATH') or die('No direct script access.');

echo 'admin!';

Route::set('auth', '<action>', array('action'=>'(login|logout|register)'))
	->defaults(array(
		'directory'  => 'admin',
		'controller' => 'auth',
		'action'     => 'login',
	));  
 

Route::set('admin', 'admin(/<controller>(/<action>(/page<page>)(/<id>)))')
	->defaults(array(   
		'directory'  => 'admin',
		'controller' => 'index',
		'action'     => 'index',

	)); 
