<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Countries extends Controller_Admin_Index{

	public function before()
	{
		parent::before();
		//Вывод в шаблон
		$this->template->page_title = 'Страны';
	}

	public function action_index(){

			$count = ORM::factory('Country')->count_all();

            $pagination = Pagination::factory(array('total_items' => $count,))
						->route_params(array(
						'controller' => Request::current()->controller(),
						'action' => Request::current()->action(),
						));
			
			$countries = ORM::factory('Country')
							->limit($pagination->items_per_page)
							->offset($pagination->offset)
							->find_all();
				
			$content = View::factory('/admin/countries',array('countries' => $countries, 'pagination'=>$pagination));
			$this->template->page_title = 'Страны';
			$this->template->block_center = $content;
	}	

	public function action_add(){
		if(isset($_POST['submit'])){
 
			$data = Arr::extract($_POST, array('country_name', 'iso_code_2', 'iso_code_3'));
			$countries = ORM::factory('Country');
			$countries->values($data);
				
			try{
					$countries->save();
					$this->request->redirect('/admin/countries');
			}
			catch(ORM_Validation_Exception $e){
					$errors = $e->errors('validation');
			}

		}
		
		$content = View::factory('/admin/addcoutry')
					->bind('errors', $errors)
					->bind('data',$data);
		
		$this->template->page_title = 'Добавить страницу';
		$this->template->block_center = $content;
	}
	
	public function action_edit(){
	$id =(int) $this->request->param('id');
	$countries = ORM::factory('Country', $id);
	
	if(!$countries->loaded()){
		$this->request->redirect('/admin/countries');
	}
	
	$data = $countries->as_array();
	
		
	// Редактирование
        if (isset($_POST['submit'])) {
		
			if($this->user->username =='demo') {
			$this->request->redirect('admin/countries?act=demo');
			exit;
			}	
		
            $data = Arr::extract($_POST, array('country_name', 'iso_code_2', 'iso_code_2'));
            $countries->values($data);

            try {
                $countries->save();
                $this->request->redirect('admin/countries');
            }
            catch (ORM_Validation_Exception $e) {
                $errors = $e->errors('validation');
            }
        }
		$content = View::factory('/admin/editcountry')
					->bind('id', $id)
					->bind('errors', $errors)
					->bind('data', $data);
					
		$this->template->page_title = 'Редактировть страницу';
		$this->template->block_center = $content;
	}
	
	public function action_delete(){
	
		if($this->user->username =='demo') {
			$this->request->redirect('admin/countries?act=demo');
			exit;
		}
	
	    $id = (int) $this->request->param('id');
        $countries = ORM::factory('Country', $id);

        if(!$countries->loaded()) {
            $this->request->redirect('admin/countries');
        }

        $countries->delete();
        $this->request->redirect('admin/countries');
	
	}
}