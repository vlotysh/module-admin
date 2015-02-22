<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Articles extends Controller_Admin_Index{

	public function before()
	{
		parent::before();
		//Вывод в шаблон
		$this->template->page_title = 'Статии';

	}

	public function action_index(){

			$articles = ORM::factory('Article')->find_all();
			$content = View::factory('admin/article/articles',array('articles' => $articles));
			$this->template->page_title = 'Статии';
			$this->template->block_center = $content;
	}

	public function action_add(){
		if(isset($_POST['submit'])){
		
			if($this->user->username =='demo') {
			$this->request->redirect('admin/articles?act=demo');
			exit;
			}
			
			$data = Arr::extract($_POST, array('article_title', 'article_alias', 'article_text', 'article_description', 'article_keywords', 'article_status'));
			$article = ORM::factory('Article');
			$article->values($data);

			try{
					$article->save();
					$this->request->redirect('/admin/articles');
			}
			catch(ORM_Validation_Exception $e){
					$errors = $e->errors('validation');
			}

		}

		$content = View::factory('admin/article/articlesadd')
					->bind('errors', $errors)
					->bind('data',$data);

		$this->template->page_title = 'Добавить страницу';
		$this->template->block_center = $content;
	}

	public function action_edit(){
		$id =(int) $this->request->param('id');
		$article = ORM::factory('Article', $id);

		if(!$article->loaded()){
			$this->request->redirect('/admin/articles');
		}

		$data = $article->as_array();


	// Редактирование
        if (isset($_POST['submit'])) {
		
			if($this->user->username =='demo') {
			$this->request->redirect('admin/articles?act=demo');
			exit;
			}
		
            $data = Arr::extract($_POST, array('article_title', 'article_alias', 'article_text', 'article_description', 'article_keywords', 'article_status'));
            $article->values($data);

            try {
                $article->save();
                $this->request->redirect('admin/articles');
            }
            catch (ORM_Validation_Exception $e) {
                $errors = $e->errors('validation');
            }
        }
		$content = View::factory('admin/article/articlesedit')
					->bind('id', $id)
					->bind('errors', $errors)
					->bind('data', $data);

		$this->template->page_title = 'Редактировть страницу';
		$this->template->block_center = $content;
	}

	public function action_delete(){

		if($this->user->username =='demo') {
			$this->request->redirect('admin/articles?act=demo');
			exit;
		}	
	
	    $id = (int) $this->request->param('id');
        $article = ORM::factory('Article', $id);

        if(!$article->loaded()) {
            $this->request->redirect('admin/articles');
        }

        $article->delete();
        $this->request->redirect('admin/articles');

	}
}