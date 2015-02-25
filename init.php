<?php defined('SYSPATH') or die('No direct script access.');

 define('MODULE_PATH', '/modules/admin/');



Route::set('admin', 'admin(/<controller>(/<action>(/page<page>)(/<id>)))')
	->defaults(array(   
		'directory'  => 'admin',
		'controller' => 'index',
		'action'     => 'index',

	)); 
