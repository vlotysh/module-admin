<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Users extends Controller_Admin_Index {

    public function before() {
	parent::before();
	$this->template->page_title = 'Пользователи';
    }

    public function action_index() {

	$users = ORM::factory('User')
		->join('roles')
		->on('user.role_id', '=', 'roles.id')
		->select('*')
		->order_by('user.id', 'desc')
		->find_all();

	$content = View::factory('admin/user/users', array('users' => $users, 'url' => $this->url));
	$this->template->block_center = $content;
    }

    public function action_add() {

	if (isset($_POST['submit'])) {

	    if ($this->user->username == 'demo') {
		$this->request->redirect('admin/users?act=demo');
		exit;
	    }

	    $data = Arr::extract($_POST, array('username', 'password', 'first_name', 'password_confirm', 'email', 'phone', 'status'));

	    $users = ORM::factory('User');

	    try {
		$users->create_user($_POST, array(
		    'username',
		    'password',
		    'email',
		    'first_name',
		    'phone',
		    'address',
		    'country_id',
		    'zone_id',
		    'status'
		));

		$role = ORM::factory('Role', array('name' => 'login'));
		//   $users->add('roles', $role);
		$users->add('roles', ORM::factory('Role', array('name' => 'login')));
		//$users->add('roles', ORM::factory('role', array('name' => 'admin')));
		$this->request->redirect('/admin/users');
	    } catch (ORM_Validation_Exception $e) {
		$errors = $e->errors('user');
	    }
	}


	$content = View::factory('admin/user/usersadd')
		->bind('errors', $errors)
		->bind('data', $data);

	$this->template->block_center = $content;
    }

    public function action_edit() {
	$id = (int) $this->request->param('id');

	if (isset($_POST['submit'])) {

	    if ($this->user->username == 'demo') {
		$this->request->redirect('admin/users?act=demo');
		exit;
	    }

	    $users = ORM::factory('User');
	    try {
		$users->where('id', '=', $id)
			->find()
			->update_user($_POST, array(
			    'username',
			    'password',
			    'first_name',
			    'email',
			    'phone',
			    'status'
		));

		$this->request->redirect('admin/users');
	    } catch (ORM_Validation_Exception $e) {
		$errors = $e->errors('user');
	    }
	}

	$user = ORM::factory('User', $id);
	if (!$user->loaded()) {
	    $this->request->redirect('admin/users');
	}

	// Выводим в шаблон
	$content = View::factory('admin/user/usersedit')->bind('users', $user)->bind('errors', $errors);
	$this->template->page_title = 'Редактирование ползователя';
	$this->template->block_center = $content;
    }

    public function action_delete() {

	if ($this->user->username == 'demo') {
	    $this->request->redirect('admin/users?act=demo');
	    exit;
	}

	$id = (int) $this->request->param('id');
	$user = ORM::factory('User', $id);

	if (!$user->loaded()) {
	    $this->request->redirect('admin/users');
	}

	$user->delete();
	$this->request->redirect('/admin/users');
    }

}
