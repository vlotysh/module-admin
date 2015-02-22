<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Категории товаров
 */

class Controller_Admin_Category extends Controller_Admin_Index {

    public function before() {
        parent::before();
       
       $id = (int) $this->request->param('id');
       $repit = true;
       $pid = $id;
       $bradcrumps = array();
       $i = 0;
       
        while ($repit) {
            
              $query = DB::query(Database::SELECT, 'SELECT * FROM categories WHERE id = :id')
                ->param(':id', $pid)
                ->execute();
                $bradcrumps[$i]['title'] = $query[0]['category_title'];
                $bradcrumps[$i]['id'] = $query[0]['id'];
                
              if($query[0]['parent_id'] == 0) {
                  $repit = false;
                  $bradcrumps = array_reverse($bradcrumps);
              }else {
                  $pid = $query[0]['parent_id'];
              }
              $i++;
        }
        
       
        var_dump($bradcrumps);
        
        foreach ($bradcrumps as $b) {
            echo '/<a href="#'.$b['id'].'">'.$b['title'].'</a>';
        }
    }

    public function action_index() {
        $categories = ORM::factory('Category');

        $categories = $categories->fulltree()->as_array();

        $content = View::factory('admin/category/category', array('url' => $this->url))
                ->bind('categories', $categories)
                ->bind('errors', $errors);

        // Вывод в шаблон
        $this->template->page_title = 'Категории';
        $this->template->block_center = $content;
    }

    public function action_add() {
        $categories = ORM::factory('Category');
        
        $cat = Arr::extract($_POST, array('category_title', 'cat_id','uri','category_description'));

        if (isset($_POST['submit'])) {
            
            $categories->category_title = $cat['category_title'];
            $categories->uri = $cat['uri'];
            $categories->category_description = $cat['category_description'];
            
            try {
                if (!$cat['cat_id']) {
                    $categories->make_root();
                } else {
                    $categories->insert_as_last_child($cat['cat_id']);
                }
                HTTP::redirect('admin/category');
            } catch (ORM_Validation_Exception $e) {
                $errors = $e->errors('validation');
            }
        }
        // Вывод в шаблон
        $categories = $categories->fulltree()->as_array();
        $content = View::factory('admin/category/categoryadd')
                ->bind('categories', $categories)
                ->bind('errors', $errors);
        $this->template->page_title = 'Категории';
        $this->template->block_center = $content;
    }

    public function action_edit() {
        $id = (int) $this->request->param('id');
        $category = ORM::factory('Category', $id);
        $data = $category->as_array();

        if (!$category->loaded()) {
            HTTP::redirect('admin/category');
        }

        $categories = ORM::factory('Category');
        
       

        $categories = $categories->fulltree()->as_array();


        
        $content = View::factory('admin/category/categoryedit')
                ->bind('id', $id)
                ->bind('categories', $categories)
                ->bind('data', $data)
                ->bind('errors', $errors);


        // Редактирование
        if (isset($_POST['submit'])) {


            $data = Arr::extract($_POST, array('category_title', 'category_description', 'template'));
            $category->values($data);

            try {
                $category->save();

               HTTP::redirect('admin/category');
            } catch (ORM_Validation_Exception $e) {
                $errors = $e->errors('validation');
            }
        }

        // Вывод в шаблон
        $this->template->page_title = 'Категории';
        $this->template->block_center = $content;
    }

    public function action_delete() {

        if ($this->user->username == 'demo') {
            HTTP::redirect('admin/category?act=demo');
            exit;
        }

        $id = (int) $this->request->param('id');
        $data = ORM::factory('Category', $id);

        if (!$data->loaded()) {
            HTTP::redirect('admin/category');
        }

        $data->delete();
       HTTP::redirect('admin/category');
    }

}
