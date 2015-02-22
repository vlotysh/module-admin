<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Manufactures extends Controller_Admin_Index{

	public function before()
	{
		parent::before();
		//Вывод в шаблон
		$this->template->page_title = 'Производительи';
	
	}

	public function action_index(){
			$data = ORM::factory('Manufactures')->find_all();
			$content = View::factory('admin/manufacture/manufactures',array('data' => $data,'url'=>$this->url));
			$this->template->page_title = 'Производительи';
			$this->template->block_center = $content;
	}	

	public function action_add(){
		if(isset($_POST['submit'])){
 
			$data = Arr::extract($_POST, array('title', 'alias', 'url'));
			$m = ORM::factory('Manufactures');
			$m->values($data);
				
			try{
				$m->save();

			if (!empty($_FILES['image']['name'])){
		
                $image  = $_FILES['image']['tmp_name'];
 
				$filename = $this->_upload_img($image);

                    // Запись в БД
                $m->image = $filename;
                $m->save();
            }
					
		HTTP::redirect('/admin/manufactures');
			}
			catch(ORM_Validation_Exception $e){
					$errors = $e->errors('validation');
			}

		}
		
		$content = View::factory('admin/manufacture/manufctureadd')
					->bind('errors', $errors)
					->bind('data',$data);
		
		$this->template->page_title = 'Добавить производителя';
		$this->template->block_center = $content;
	}
	
	public function action_edit(){
	$id =(int) $this->request->param('id');
	$m = ORM::factory('Manufactures', $id);
	
	if(!$m->loaded()){
		HTTP::redirect('/admin/manufactures');
	}
	
	$data = $m->as_array();
	
	// Редактирование
        if (isset($_POST['submit'])) {
		
			if($this->user->username =='demo') {
				HTTP::redirect('admin/manufactures');
				exit;
			}	
		
            $data = Arr::extract($_POST, array('title', 'alias', 'url', 'image'));
            $m->values($data);

            try {
                $m->save();
				
				
			if (!empty($_FILES['image']['name'])){
		
                $image  = $_FILES['image']['tmp_name'];
 
				$filename = $this->_upload_img($image);

                    // Запись в БД
                $m->image = $filename;
                $m->save();
            }				
				
				
            HTTP::redirect('admin/manufactures');
            }
            catch (ORM_Validation_Exception $e) {
                $errors = $e->errors('validation');
            }
        }
		
		$content = View::factory('admin/manufacture/manufactureedit')
					->bind('id', $id)
					->bind('errors', $errors)
					->bind('data', $data);
					
		$this->template->page_title = 'Редактировть страницу';
		$this->template->block_center = $content;
	}
	
	public function action_delete(){
	
		if($this->user->username =='demo') {
			HTTP::redirect('admin/manufactures?act=demo');
			exit;
		}
	
	    $id = (int) $this->request->param('id');
        $data = ORM::factory('Manufactures', $id);

        if(!$data->loaded()) {
            HTTP::redirect('admin/manufactures');
        }

        $data->delete();
        HTTP::redirect('admin/manufactures');
	
	}
	
	
	
	public function _upload_img($file, $ext = NULL, $directory = NULL){

        if($directory == NULL){
            $directory = 'media/manufactures';
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