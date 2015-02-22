<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Категории товаров
 */

class Controller_Admin_Filters extends Controller_Admin_Index {

    public function action_index() {
        Cache::$default = 'file';

// Load the memcache cache driver using default setting
        $cache = Cache::instance();

        if (true) { #!$cache->get('filters_cont' . $_SERVER['REQUEST_URI'])) {

            //модель для фильтров

            $prodModel = Model::factory('Product');

            #$prodres = $prodModel->ProductsByValue(null,$_GET);

            $filteModel = Model::factory('Filters');

            //Выборка категорий
            $categories = ORM::factory('Category');

            $categories = $categories->fulltree()->as_array();

            if ($this->request->query('cat_id')) {
                #$allfilters = $filteModel->getFiltersByCat($this->request->query('cat_id')); //скорее всего основной запрос на выборка в товарах
            } else {
                
            }
            $allfilters = $filteModel->getAllFilters();
            #$new_array = Helper_Producthelper::prepareFiltersTree($allfilters);

            $content = View::factory('admin/filters', array('categories' => $categories, 'allfilters' => $allfilters))->render();

            $cache->set('filters_cont' . $_SERVER['REQUEST_URI'], serialize($content));
        } else {

            $content = unserialize($cache->get('filters_cont' . $_SERVER['REQUEST_URI']));
        }
        $this->template->page_title = 'Фильтры';
        $this->template->block_center = $content;
    }

    public function action_add() {

        $filteModel = Model::factory('Filters');
        
        $categories = ORM::factory('Category');

        $categories = $categories->fulltree()->as_array();

        if ($_POST) {

            $result = $filteModel->addFilter($_POST);

            if ($result) {

                Notification::Success();
            } else {
                Notification::Error();
            }

            HTTP::redirect('/admin/filters');
        }

        $content = View::factory('admin/filters_add', array('categories' => $categories));

        $this->template->block_center = $content;
    }

    public function action_edit() {

        $filteModel = Model::factory('Filters');

        if ($_POST) {
            
            $result = $filteModel->updateFilter($_POST);

            if ($result) {

                Notification::Success();
                
            } else {
                
                Notification::Error();
            }

            HTTP::redirect('/admin/filters/edit?filter_id=' . $_POST['filter_id']);
        }
        $filter_id = $this->request->query('filter_id');


        $categories = ORM::factory('Category');

        $categories = $categories->fulltree()->as_array();

        if ($filter_id) {
            $filter = $filteModel->getFiltersById($filter_id);
            $values = $filteModel->getFilterValues($filter_id);

            $filter_cats = $filteModel->getCatsToFilters($filter_id);

            $content = View::factory('admin/filters_edit', array('filter' => $filter, 'values' => $values, 'categories' => $categories, 'filter_cats' => $filter_cats));
            $this->template->block_center = $content;
        } else {
            
            HTTP::redirect('admin/filters');
            
        }
    }
    
    public function action_delete() {
        
         $id = $this->request->query('filter_id');
         
         if($id) {
             
              $filteModel = Model::factory('Filters');
              
              $filteModel->deleteFilter($id);

         }
         
         HTTP::redirect('admin/filters');
    }

    public function action_values() {
        if ($this->request->is_ajax()) {
            $id = $this->request->query('filter_id');
            $filteModel = Model::factory('Filters');

            $res['suggestions'] = $filteModel->getFilterValues($id);
            echo json_encode($res);
            exit();
        }
    }

    public function action_catvalues() {
        if ($this->request->is_ajax()) {
            $id = $this->request->query('cat_id');

            $filteModel = Model::factory('Filters');
            $res = $filteModel->getFiltersCatList($id);

            echo json_encode($res);
            exit();
        }
    }

}
