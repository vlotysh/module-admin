<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Index extends Controller_Admin_Base {

    public function before() {
	parent::before();

	if (!Auth::instance()->logged_in('admin')) {

	    HTTP::redirect('admin/auth');
	}

	if (isset($this->user))
	    $this->template->admin_info = $this->user;

	//Вывод в шаблон
	$this->template->title = 'Админисртрирование';
	$this->template->page_title = 'Панель управления';

	$this->template->scripts = array(
            'media/js/bootstrap.min.js',
	    'media/js/jquery.MultiFile.pack.js',
	    'media/js/upload.js',
	    'media/js/jquery.autocomplete.js',
	    'media/js/view_images.js',
	    'media/js/lib/functions.js',
	    'media/js/admin/common.js',
	    'media/js/admin/controllers.js',
	    'media/js/admin/model.js',
	);
    }

    public function action_index() {
	$content = View::factory('/admin/index');

	/*       try {
	  $a = 1 / 0;

	  } catch (Exception $e) {

	  Notification::Error($e->getMessage());
	  exit();
	  } */

	#Notification::Success();

	Session::instance()->set('last_url', $this->request->uri());

	$this->template->block_center = $content;
    }

    public function after() {
	
	$feedcount = ORM::factory('Feedback')->where('status', '=', 0)->count_all();

	$admin_menu = View::factory('/admin/admin_menu', array('feedcount' => $feedcount));
	$this->template->admin_menu = $admin_menu;

	parent::after();
    }

}
