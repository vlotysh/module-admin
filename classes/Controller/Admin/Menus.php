<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Menus extends Controller_Admin_Index{

	public function before()
	{
		parent::before();
		//Вывод в шаблон
		$this->template->page_title = 'Меню сайта';
               
	
	}

	public function action_index(){
	
		$menus = ORM::factory('Menugroup')->find_all();

		$content = View::factory('admin/menu/menu_groups', array('menus'=>$menus,'url'=>$this->url));
		$this->template->block_center = $content;
	}


	public function action_menu(){
	    $id = (int) $this->request->param('id');
		$menus = ORM::factory('Menu')->where('menu_group_id','=',$id)->find_all();

		$content = View::factory('admin/menu/menus', array('menus'=>$menus,'url'=>$this->url));
		$this->template->block_center = $content;
	}
	
	public function action_addgroup(){

		if(isset($_POST['submit'])){
		
			if($this->user->username =='demo') {
				 HTTP::redirect('admin/menus');
                                
				exit;
			}	
		
		$data = Arr::extract($_POST, array('menu_group_title', 'menu_group_position'));
		$m = ORM::factory('Menugroup');
		$m->values($data);

			try{
				$m->save();
				 HTTP::redirect('/admin/menus');
			}
			catch(ORM_Validation_Exception $e){
					$errors = $e->errors('validation');
			}
	
	}
	
	
	$content = View::factory('admin/menu/menu_group_form')->bind('data',$data)->bind('errors',$errors);
	$this->template->block_center = $content;
	}
	

	
	public function action_editgroup(){

	$id = (int) $this->request->param('id');
    $m = ORM::factory('Menugroup', $id);

        if(!$m->loaded()) {
             HTTP::redirect('admin/menus');
    }
	
	if(isset($_POST['submit'])){
	
		$data = Arr::extract($_POST, array('menu_group_title', 'menu_group_position'));
		
		$m->values($data);

			try{
					$m->save();
					 HTTP::redirect('/admin/menus');
			}
			catch(ORM_Validation_Exception $e){
					$errors = $e->errors('validation');
			}
	
	}
	
	$data = $m->as_array();
	
	$content = View::factory('admin/menu/menu_group_form', array('data'=>$data));
	$this->template->block_center = $content;
	}

	


	public function action_deletegroup(){
	
		if($this->user->username =='demo') {
			 HTTP::redirect('admin/menus');
			exit;
		}
	
	    $id = (int) $this->request->param('id');
        $m = ORM::factory('Menugroup', $id);

        if(!$m->loaded()) {
             HTTP::redirect('admin/menus');
        }

        $m->delete();
         HTTP::redirect('admin/menus');
	
	}


	
	
	
	public function action_add(){

	if(isset($_POST['submit'])){
		$data = Arr::extract($_POST, array('menu_group_id', 'menu_group_position', 'menu_title', 'menu_type', 'menu_alias', 'menu_url'));
		$m = ORM::factory('Menu');
		$m->values($data);

			try{
					$m->save();
					 HTTP::redirect('/admin/menus');
			}
			catch(ORM_Validation_Exception $e){
					$errors = $e->errors('validation');
			}
	
	
	}
	
	
	$content = View::factory('admin/menu/menu_form')->bind('errors',$errors);
	$this->template->block_center = $content;
	}


	public function action_edit(){

	$id = (int) $this->request->param('id');
    $m = ORM::factory('Menu', $id);

        if(!$m->loaded()) {
             HTTP::redirect('admin/menus');
    }
	
	if(isset($_POST['submit'])){
	
		if($this->user->username =='demo') {
			 HTTP::redirect('admin/menus');
			exit;
		}
	
		$data = Arr::extract($_POST, array('menu_title', 'menu_type', 'menu_alias', 'menu_url'));
		
		$m->values($data);

			try{
					$m->save();
					 HTTP::redirect('/admin/menus');
			}
			catch(ORM_Validation_Exception $e){
					$errors = $e->errors('validation');
			}
	
	
	}
	
	$data = $m->as_array();
	
	$content = View::factory('admin/menu/menu_form')
	->bind('data', $data);
	$this->template->block_center = $content;
	}


	public function action_delete(){
	
		if($this->user->username =='demo') {
			 HTTP::redirect('admin/menus');
			exit;
		}
	
	    $id = (int) $this->request->param('id');
        $m = ORM::factory('Menu', $id);

        if(!$m->loaded()) {
             HTTP::redirect('admin/menus');
        }

        $m->delete();
         HTTP::redirect('admin/menus');
	
	}
	
}