<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Banners extends Controller_Admin_Index{

	public function before()
	{
		parent::before();
		//Вывод в шаблон
		$this->template->page_title = 'Баннеры';
	
	}

	public function action_index(){

		$banners = ORM::factory('Banner')->find_all();
		$content = View::factory('admin/banner/banners',array('banners' => $banners,'url'=>$this->url));
		$this->template->block_center = $content;
	}	

	public function action_add(){
	    
		if(isset($_POST['submit'])){
		
 			if($this->user->username =='demo') {
			$this->request->redirect('admin/banners?act=demo');
			exit;
			}
			
			$data = Arr::extract($_POST, array('banner_title', 'banner_url', 'image', 'banner_status'));
			$banners = ORM::factory('Banner');
			$banners->values($data);
				
			try{
				$banners->save();
					
				if (!empty($_FILES['image']['name'])){
		
                $image  = $_FILES['image']['tmp_name'];
 
		$filename = $this->_upload_img($image);

               // Запись в БД
                $banners->banner_image = $filename;
                $banners->save();
            }	
					
				$this->request->redirect('/admin/banners');
			}
			catch(ORM_Validation_Exception $e){
					$errors = $e->errors('validation');
			}

		}
		
		$content = View::factory('admin/banner/banneradd')
					->bind('errors', $errors)
					->bind('data',$data);
		
		$this->template->page_title = 'Добавить баннер';
		$this->template->block_center = $content;
	}
	
	public function action_edit(){
		$id =(int) $this->request->param('id');
		$banners = ORM::factory('Banner', $id);
		
		if(!$banners->loaded()){
			$this->request->redirect('/admin/banners');
		}
		
		$data = $banners->as_array();
		
		// Редактирование
        if (isset($_POST['submit'])) {
		
			if($this->user->username =='demo') {
			$this->request->redirect('admin/banners?act=demo');
			exit;
			}
		
            $data = Arr::extract($_POST, array('title', 'url', 'image', 'banner_status'));
            $banners->values($data);

            try {
                $banners->save();
                $this->request->redirect('admin/banners');
            }
            catch (ORM_Validation_Exception $e) {
                $errors = $e->errors('validation');
            }
        }
		$content = View::factory('admin/banner/banneredit')
					->bind('id', $id)
					->bind('errors', $errors)
					->bind('data', $data);
					
		$this->template->page_title = 'Редактировть';
		$this->template->block_center = $content;
	}
	
	public function action_delete(){
	
		if($this->user->username =='demo') {
			$this->request->redirect('admin/banners?act=demo');
			exit;
		}	
	
	    $id = (int) $this->request->param('id');
        $banners = ORM::factory('Banner', $id);

        if(!$banners->loaded()) {
            $this->request->redirect('admin/banners');
        }

        $banners->delete();
        $this->request->redirect('admin/banners');
	
	}
	
	
	
	public function _upload_img($file, $ext = NULL, $directory = NULL){

        if($directory == NULL){
            $directory = 'media/banners';
        }

        if($ext== NULL){
            $ext= 'jpg';
        }

        // Генерируем случайное название
        $symbols = '0123456789abcdefghijklmnopqrstuvwxyz';
        $filename = substr(str_shuffle($symbols), 0, 16);

        // Изменение размера и загрузка изображения
        $im = Image::factory($file);

        if($im->width > 150){
            $im->resize(150);
        }
        
		$im->save("$directory/small_$filename.$ext");

        $im = Image::factory($file);
        $im->save("$directory/$filename.$ext");

        return "$filename.$ext";
    }
	
	
}