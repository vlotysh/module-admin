<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_System extends Controller_Admin_Index{

	public function before()
	{
		parent::before();
		//Вывод в шаблон
		$this->template->page_title = 'Система';
	}

	public function action_index(){
		$this->template->block_center = View::factory('/admin/system');
	}	

public function action_settings(){
		$s = ORM::factory('Setting',1);

		if(isset($_POST['submit'])){
		
			if($this->user->username =='demo') {
                            HTTP::redirect('admin/system/?act=demo');
				exit;
			}

			$data = Arr::extract($_POST, array('title', 'url', 'email', 'meta_description', 'meta_keywords'));
		
			$s->values($data);
				
			try{
					$s->save();
                                        HTTP::redirect('/admin/system/settings');
			}
			catch(ORM_Validation_Exception $e){
					$errors = $e->errors('setting');
			}

		}
		$settings = ORM::factory('Setting',1);
		$content = View::factory('/admin/settings', array('settings'=>$settings))
					->bind('errors', $errors)
					->bind('data',$data);
		
	
		$this->template->block_center = $content ;
	
	}
		
}