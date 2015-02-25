<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Services extends Controller_Admin_Index {

    public function before() {
	parent::before();
	//Вывод в шаблон
	$this->template->page_title = 'Дополинительные сервисы';
    }

    public function action_index() {

	$services = ORM::factory('Services')->listService();
	$content = View::factory('admin/services/services', array('services' => $services));
	$this->template->block_center = $content;
    }

    public function action_add() {


	if ($_POST) {
	    $articles = ORM::factory('Services')->addNewService($_POST);
	    Notification::Success('Свойство добавлено!');
	    HTTP::redirect('/admin/services');
	}
	$categories = ORM::factory('Category');
	$categories = $categories->fulltree()->as_array();

	$content = View::factory('admin/services/services_add_edit', array('categories' => $categories))->bind('data', $data);
	$this->template->block_center = $content;
    }

    public function action_edit() {
	
	$serviceModel = ORM::factory('Services');
	
	$service_id = $this->request->param('id');

	if ($_POST) {
	    
	    $result = $serviceModel->updateService($service_id,$_POST);
	    
	    $result ? Notification::Success("Сервис '{$_POST['service_title']}' обновлен успешно ") : Notification::Error('Произошла ошибка, данные не обновленны');
	    
	    HTTP::redirect('/admin/services');

	}

	$services = $serviceModel->oneService($service_id);

	$categories = ORM::factory('Category');
	$categories = $categories->fulltree()->as_array();

	$content = View::factory('admin/services/services_add_edit', array('categories' => $categories))->bind('data', $services);
	$this->template->block_center = $content;
    }

    public function action_remove() {
	
	$service_id = $this->request->param('id');
		
	$serviceModel = ORM::factory('Services');
	$result = $serviceModel->deleteService($service_id);
	
	$result ? Notification::Success("Сервис успешно удален!") : Notification::Error('Произошла ошибка, данные не обновленны');
	    
	HTTP::redirect('/admin/services');
	
    }

}
