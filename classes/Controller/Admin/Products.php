<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * Продукты
 */

class Controller_Admin_Products extends Controller_Admin_Index {

    public function before() {
	parent::before();
    }

    public function action_index() {

	$types = ORM::factory('Type')->find_all();

	$categories = ORM::factory('Category')->find_all();
	
	$product_model = ORM::factory('Product');
	
	$type_id = isset($_GET['type']) ? $_GET['type'] : 1;

	// получаем общее количество товаров
	$count = ORM::factory('Product')->count_all();
	// передаем значение количества товаров в модуль pagination и формируем ссылки
	$pagination = Pagination::factory(array('total_items' => $count, 'current_page' => array('source' => 'query_string', 'key' => 'page')))->route_params(array(
	    'controller' => Request::current()->controller(),
	    'action' => Request::current()->action(),
	));

	$products = $product_model->order_by('id', 'desc')->limit($pagination->items_per_page)
		->offset($pagination->offset)
		->find_all();
	



	/*  $id = (int) $_GET['cat_id'];

	  $category = ORM::factory('Category')->where('id', '=', $id)->find();

	  $count = $category->products->count_all();

	  $pagination = Pagination::factory(array('total_items' => $count, 'current_page' => array('source' => 'query_string', 'key' => 'page')))->route_params(array(
	  'controller' => Request::current()->controller(),
	  'action' => Request::current()->action(),
	  ));

	  $products = $category->products->order_by('id', 'desc')->limit($pagination->items_per_page)
	  ->offset($pagination->offset)
	  ->find_all();
	 */

	$content = View::factory('admin/product/products', array('products' => $products, 'categories' => $categories, 'pagination' => $pagination, 'url' => $this->url, 'types' => $types))->render();

	$this->template->page_title = 'Товары';
	$this->template->block_center = $content;
    }

    public function action_add() {

	$cats_select = false;
	$services = array();
	$cat_id = $this->request->query('category');
	$categories = ORM::factory('Category');
	$categories = $categories->fulltree()->as_array();


	if ($cat_id) {

		
	    if (isset($_POST['submit'])) {
			var_dump($_POST);
			var_dump($_FILES);
		exit();

		$data = array();


		// Работа с товаром
		$data = Arr::extract($_POST, array('cat_id', 'type_id', 'title', 'product_uri', 'description', 'values', 'grades', 'price', 'images', 'meta_description', 'meta_keywords', 'status','origin_url'),null);
		
		
		$data['add_date'] = date("Y-m-d");
		$products = ORM::factory('Product');
		$services = ORM::factory('Services');
		/* if (isset($_POST['value'])) {

		  $innerCounter = 0;
		  foreach ($_POST['value'] as $k => $v) {
		  if ($v == '') {

		  //Добавляем новое значение для фильтра, в данном случае ключ указывает на фильтер

		  $newId = $filteModel->addFilterValue($_POST['filter_title'][$k], $k);

		  $newId ? $new_values[$innerCounter] = '' . $newId : false;
		  }

		  $innerCounter++;
		  }

		  // Склеим массив с новыми id и теми что уже были

		  $new_values = Arr::array_clean(array_merge($new_values, $_POST['value']));
		  } */




		$products->values($data);

		try {

		    $products->save();

		    //Добавление сервиса
		    if (isset($_POST['services'])) {
			$products->productAddServices($products->pk(), $_POST['services']);
		    }

		    $products->add('categories', $data['cat_id']);
		    
		    /*
		    if (count($new_values)) {
			$filteModel->addValuesToProduct($new_values, $products->pk());
		    }

		    if (!$filteModel) {
			echo 'Все очень плохо...';
			exit();
		    }*/
		    
		    
		    // Работа с изображениями
		    if (!empty($_FILES['images']['name'][0])) {

			print_r($_FILES['images']['name'][0]);
			foreach ($_FILES['images']['tmp_name'] as $image) {

			    $filename = $this->_upload_img($image);

			    // Запись в БД
			    $im_db = ORM::factory('Image');
			    $im_db->product_id = $products->pk();
			    $im_db->name = $filename;
			    $im_db->save();

			    $p_db = ORM::factory('Product', $products->pk());
			    if ($p_db->image_id == 0) {
				$p_db->image_id = $im_db->pk();
				$p_db->save();
			    }
			}
		    }
	    
		    Notification::Success("Продукт добавлен успешно '{$data['title']}'!");

		    HTTP::redirect('admin/products');
		    
		    
		} catch (ORM_Validation_Exception $e) {
		    
		    Notification::Error("Продукт не добавлен!");
		    
		    $errors = $e->errors('validation');
		}
	    } else {
		$services = ORM::factory('Services')->listService($cat_id);
	    }
	} else {
	    $cats_select = true;
	}

	$content = View::factory('admin/product/addproduct', array('categories' => $categories, 'cats_select' => $cats_select))->bind('data', $data)->bind('services', $services);

	$this->template->block_center = $content;



	/*




	  //Получение категорий
	  $categories = ORM::factory('Category');
	  $filteModel = Model::factory('Filters');
	  $types = ORM::factory('Type')->find_all();

	  $categories = $categories->fulltree()->as_array();

	  $new_values = array();



	  if (isset($_POST['submit'])) {

	  if (isset($_POST['value'])) {

	  $innerCounter = 0;
	  foreach ($_POST['value'] as $k => $v) {
	  if ($v == '') {

	  //Добавляем новое значение для фильтра, в данном случае ключ указывает на фильтер

	  $newId = $filteModel->addFilterValue($_POST['filter_title'][$k], $k);

	  $newId ? $new_values[$innerCounter] = '' . $newId : false;
	  }

	  $innerCounter++;
	  }

	  // Склеим массив с новыми id и теми что уже были

	  $new_values = Arr::array_clean(array_merge($new_values, $_POST['value']));
	  }

	  // Работа с товаром
	  $data = Arr::extract($_POST, array('cat_id' , 'type_id', 'title', 'product_uri', 'description','values','grades', 'price', 'images', 'meta_description', 'meta_keywords', 'status'));

	  $data['add_date'] = date("Y-m-d");
	  $products = ORM::factory('Product');
	  $products->values($data);

	  try {

	  $products->save();

	  $products->add('categories', $data['cat_id']);

	  if (count($new_values)) {
	  $filteModel->addValuesToProduct($new_values, $products->pk());
	  }

	  if (!$filteModel) {
	  echo 'Все очень плохо...';
	  exit();
	  }
	  // Работа с изображениями
	  if (!empty($_FILES['images']['name'][0])) {

	  print_r($_FILES['images']['name'][0]);
	  foreach ($_FILES['images']['tmp_name'] as $image) {

	  $filename = $this->_upload_img($image);

	  // Запись в БД
	  $im_db = ORM::factory('Image');
	  $im_db->product_id = $products->pk();
	  $im_db->name = $filename;
	  $im_db->save();

	  $p_db = ORM::factory('Product', $products->pk());
	  if ($p_db->image_id == 0) {
	  $p_db->image_id = $im_db->pk();
	  $p_db->save();
	  }
	  }
	  }

	  HTTP::redirect('admin/products');
	  } catch (ORM_Validation_Exception $e) {
	  $errors = $e->errors('validation');
	  }
	  }

	  $content = View::factory('admin/product/addproduct')
	  ->bind('errors', $errors)
	  ->bind('cats', $categories)
	  ->bind('data', $data)
	  ->bind('types', $types);

	  // Вывод в шаблон
	  $this->template->page_title = 'Товары :: Добавить';
	  $this->template->block_center = $content;
	 * 
	 */
    }

    public function action_edit() {

	$id = (int) $this->request->param('id');

	$products = ORM::factory('Product', $id);
	
	$services = $products->productListServices($id);
	
	//Получение категорий
	$categories = ORM::factory('Category');
	$categories = $categories->fulltree()->as_array();
	$types = ORM::factory('Type')->find_all();

	$data = $products->getProductById($id);


	$filters = $products->getValues($id);

	$data['images'] = $products->getProductImage($id);

	$manufactures = ORM::factory('Manufactures')->find_all();

	// Редактирование
	if (isset($_POST['submit'])) {

	    
	    // Работа с товаром
	    $data = Arr::extract($_POST, array('cat_id', 'title', 'type_id', 'values', 'description', 'price', 'images', 'meta_description', 'meta_keywords', 'grades', 'status','services'));
	    
	    $data['type_id'] = $data['type_id'] ? $data['type_id'] : 1;

	    if(!isset($data['services']))  $data['services'] = array();
	    
	    $products->productAddServices($id,$data['services']);
	    
	    $products->values($data);

	    try {
		$products->save();
		$products->remove('categories');
		$products->add('categories', $data['cat_id']);

		// Работа с изображениями
		if (!empty($_FILES['images']['name'][0])) {
		    foreach ($_FILES['images']['tmp_name'] as $i => $image) {
			$filename = $this->_upload_img($image);

			// Запись в БД
			$im_db = ORM::factory('Image');
			$im_db->product_id = $products->pk();
			$im_db->name = $filename;
			$im_db->save();

			$p_db = ORM::factory('Product', $products->pk());
			if ($p_db->image_id == 0) {
			    $p_db->image_id = $im_db->pk();
			    $p_db->save();
			}
		    }
		}
		
	    Notification::Success("Продукт обноавлен успешно '{$data['title']}'!");

		 HTTP::redirect('admin/products/edit/' . $products->pk());
		// HTTP::redirect('admin/products');
	    } catch (ORM_Validation_Exception $e) {
		$errors = $e->errors('validation');
	    }
	}

	$content = View::factory('admin/product/editproduct', array('manufactures' => $manufactures, 'cats' => $categories, 'filters' => $filters, 'data' => $data, 'types' => $types,'services' => $services));

	// Вывод в шаблон
	$this->template->page_title = 'Товары :: Редактировать';
	$this->template->block_center = $content;
    }

    public function action_delete() {

	$id = (int) $this->request->param('id');
	$products = ORM::factory('Product', $id);

	if (!$products->loaded()) {
	    HTTP::redirect('admin/products');
	}

	$products->delete();
	HTTP::redirect('admin/products?act=demo');
    }

    // Удалить изображение
    public function action_delimg() {
	$id = (int) $this->request->param('id');
	$images = ORM::factory('Image', $id);
	$product_id = $images->product_id;

	if (!$images->loaded()) {
	    HTTP::redirect('admin/products?act=demo');
	}

	$p_db = ORM::factory('Product', $product_id);
	if ($p_db->image_id == $id) {
	    $p_db->image_id = 0;
	    $p_db->save();
	}

	$images->delete();

	HTTP::redirect('admin/products/edit/' . $product_id);
    }

    // Сделать главное изображение
    public function action_mainimg() {
	$id = (int) $this->request->param('id');
	$images = ORM::factory('Image', $id);
	$product_id = $images->product_id;

	$product = ORM::factory('Product', $product_id);
	$product->image_id = $id;
	$product->save();

	HTTP::redirect('admin/products/edit/' . $product_id . '#img');
    }

    public function _upload_img($file, $ext = NULL, $directory = NULL) {

	if ($directory == NULL) {
	    $directory = 'media/products';
	}

	if ($ext == NULL) {
	    $ext = 'jpg';
	}

	// Генерируем случайное название
	$symbols = '0123456789abcdefghijklmnopqrstuvwxyz';
	$filename = substr(str_shuffle($symbols), 0, 16);

	// Изменение размера и загрузка изображения
	$im = Image::factory($file);

	if ($im->height > 150) {
	    $im->resize(NULL, 150);
	}
	$im->save("$directory/small_$filename.$ext");

	$im = Image::factory($file);
	$im->save("$directory/$filename.$ext");

	return "$filename.$ext";
    }

}
