<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Feedback extends Controller_Admin_Index {

    public function before() {
	parent::before();
	//Вывод в шаблон
	$this->template->page_title = 'Запросы на фидбэк';
    }

    public function action_index() {


	$feedback = ORM::factory('Feedback');

	$count = $feedback->count_all();

	$pagination = Pagination::factory(array('total_items' => $count, 'current_page' => array('source' => 'query_string', 'key' => 'page')))->route_params(array(
	    'controller' => Request::current()->controller(),
	    'action' => Request::current()->action(),
	));

	$feedback_items = $feedback->order_by('id', 'desc')->limit($pagination->items_per_page)
		->offset($pagination->offset)
		->find_all();

	$content = View::factory('/admin/feedback/feedback_list', array('feedback_items' => $feedback_items, 'pagination' => $pagination))->render();

	$this->template->page_title = 'Запросы на фидбэк';
	$this->template->block_center = $content;
    }

    public function action_view() {

	$id = $this->request->param('id');


	$feedback = ORM::factory('Feedback', $id);

	if ($feedback->status == 0) {
	    $feedback->set('status', 1);
	    $feedback->save();
	}


	$content = View::factory('/admin/feedback/feedback_one', array('feedback' => $feedback));

	$this->template->block_center = $content;
	#feedback_one
    }

    public function action_delete() {

	$id = $this->request->param('id');
	
	$feedback = ORM::factory('Feedback',$id);
	$result = $feedback->delete();
	
	if($result) {
	    Notification::Success('Обратный вызов удален!');
	}else {
	    Notification::Error('Обратный вызов не удален!');	    
	}
	
	HTTP::redirect('/admin/feedback');
	
    }

}
