<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Pages extends Controller_Admin_Index{

	public function before()
	{
		parent::before();
		//Вывод в шаблон
		$this->template->page_title = 'Страницы';
	
	}

	public function action_index(){

			$pages = ORM::factory('Pages')->find_all();
			$content = View::factory('admin/page/pages',array('pages' => $pages,'url'=>$this->url));
			$this->template->page_title = 'Страницы';
			$this->template->block_center = $content;
	}	

	public function action_add(){
		if(isset($_POST['submit'])){
 
			$data = Arr::extract($_POST, array('page_title', 'page_alias', 'page_text', 'page_description', 'page_keywords', 'page_status' ));
			$pages = ORM::factory('Pages');
			$pages->values($data);
				
			try{
					$pages->save();
					HTTP::redirect('/admin/pages');
			}
			catch(ORM_Validation_Exception $e){
					$errors = $e->errors('validation');
			}

		}
		
		$content = View::factory('admin/page/addpages')
					->bind('errors', $errors)
					->bind('data',$data);
		
		$this->template->page_title = 'Добавить страницу';
		$this->template->block_center = $content;
	}
	
	public function action_edit(){
		$id =(int) $this->request->param('id');
		$pages = ORM::factory('Pages', $id);
		
		if(!$pages->loaded()){
			HTTP::redirect('/admin/pages');
		}
		
		$data = $pages->as_array();
	
		
		// Редактирование
        if (isset($_POST['submit'])) {

		
		$data = Arr::extract($_POST, array('page_title', 'page_alias',  'page_text',  'page_description', 	'page_keywords', 'page_status'));
            $pages->values($data);

            try {
                $pages->save();
                HTTP::redirect('admin/pages');
            }
            catch (ORM_Validation_Exception $e) {
                $errors = $e->errors('validation');
            }
        }
		$content = View::factory('admin/page/editpages')
					->bind('id', $id)
					->bind('errors', $errors)
					->bind('data', $data);
					
		$this->template->page_title = 'Редактировть страницу';
		$this->template->block_center = $content;
	}
	
	public function action_delete(){
	
		if($this->user->username =='demo') {
			HTTP::redirect('admin/pages?act=demo');
			exit;
		}
	
	    $id = (int) $this->request->param('id');
        $pages = ORM::factory('Pages', $id);

        if(!$pages->loaded()) {
            HTTP::redirect('admin/pages');
        }

        $pages->delete();
        HTTP::redirect('admin/pages');
	
	}
}