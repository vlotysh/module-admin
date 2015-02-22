<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Product extends ORM {

    protected $_table_name = 'products';
    protected $_primary_key = 'id';
    protected $_db_group = 'default';
    protected $_has_many = array(
	'images' => array(
	    'model' => 'Image',
	    'foreign_key' => 'product_id',
	),
	'categories' => array(
	    'model' => 'Category',
	    'foreign_key' => 'product_id',
	    'through' => 'products_categories',
	    'far_key' => 'category_id',
	),
	'features' => array(
	    'model' => 'Feature',
	    'through' => 'options',
	),
	'orders' => array(
	    'model' => 'order',
	    'foreign_key' => 'product_id',
	    'through' => 'orders_products',
	    'far_key' => 'orders_id',
	),
    );
    protected $_belongs_to = array(
	'main_img' => array(
	    'model' => 'Image',
	    'foreign_key' => 'image_id',
	),
	    /* 'manufactures' => array(
	      'model' => 'Manufactures',
	      'foreign_key' => 'manufacture_id',
	      ), */
    );

    public function rules() {
	return array(
	    'title' => array(
		array('not_empty'),
	    ),
	    'description' => array(
		array('not_empty'),
	    ),
	    'price' => array(
		//  array('not_empty'),
		array('numeric'),
	    ),
	);
    }

    public function labels() {
	return array(
	    'title' => 'Наименование',
	    'description' => 'Описание',
	    'price' => 'Цена',
	    'type_id' => 'Тип товара',
	    'cat_id' => 'Категория',
	);
    }

    public function filters() {
	return array(
	    TRUE => array(
		array('trim'),
	    ),
	    'title' => array(
		array('strip_tags'),
	    ),
	    'price' => array(
		array('strip_tags'),
	    ),
	);
    }

    public function NextAndPrev($prod_id, $cat_id) {

	$result = array();

	$prev = "SELECT `products`.*
	FROM `products`
	JOIN `products_categories` ON (`products_categories`.`product_id` = `products`.`id`)
	WHERE `products`.`type_id` = 1 AND `products`.`id` < {$prod_id} AND `products_categories`.`category_id` = {$cat_id} LIMIT 1";

	$query = DB::query(Database::SELECT, $prev);

	$prev_prod = $query->as_object()->execute();

	$result['prev_prod'] = $prev_prod[0];

	$next = "SELECT `products`.*,`products_categories`.`category_id`
	FROM `products`
	JOIN `products_categories` ON (`products_categories`.`product_id` = `products`.`id`)
	WHERE `products`.`type_id` = 1 AND `products`.`id` > {$prod_id} AND `products_categories`.`category_id` = {$cat_id} LIMIT 1
         ";

	$query1 = DB::query(Database::SELECT, $next);

	$next_prod = $query1->as_object()->execute();

	$result['next_prod'] = $next_prod[0];

	return $result;
    }

    public function ProductsByValue($cat = null, $values = null, $offset = null, $limit = null) {

	$single = 0;

	$sql_stet = "SELECT `products`.* ,`images`.`name` AS `src_img`,`categories`.`category_title`, `categories`.`uri` AS `category_uri`
         FROM `products`
         JOIN `products_categories` ON (`products_categories`.`product_id` = `products`.`id`)
         JOIN `categories` ON ( `categories`.`id` = `products_categories`.`category_id`)
         LEFT JOIN `images` ON ( `images`.`id` = `products`.`image_id`)
	 WHERE `products`.`type_id` = 1
	 AND `products`.`status` = 1 ";

	if ($cat) :

	    $sql_stet .= "AND `categories`.`uri` = '{$cat}'";

	endif;

	$sql_stet .= " ORDER BY `products`.`id` desc";

	if ($offset):

	    $sql_stet .= " LIMIT {$offset}";

	endif;

	if ($limit):

	    $sql_stet .= ", {$limit}";

	endif;

	/* $sql_stet = "SELECT `products`.* , count( `products_values`.`prod_id` ) AS total ,`images`.`name` AS `src_img`
	  FROM `category_filters`
	  JOIN `filters` ON ( `filters`.`id` = `category_filters`.`filter_id` )
	  JOIN `values` ON ( `values`.`filter_id` = `category_filters`.`filter_id` )
	  JOIN `products_values` ON ( `products_values`.`value_id` = `values`.`id` )
	  JOIN `products` ON (`products_values`.`prod_id` = `products`.`id`)
	  LEFT JOIN `images` ON ( `images`.`product_id` = `products`.`id`)
	  ";

	  if (isset($values['values']) && isset($cat)) {

	  $range = str_replace('-', ',', $values['values']);

	  $sql_stet .= " AND `values`.`id` IN (" . $range . ")";

	  $sql_sub = "select *, count(`values`.`id`) from `values` WHERE `values`.`id` IN ($range) GROUP by `values`.`filter_id`  ";

	  $sub_query = DB::query(Database::SELECT, $sql_sub)->execute()->as_array();

	  $single = count($sub_query);
	  } */

	#$sql_stet .= 'WHERE GROUP BY `products`.`id` ';
	#$sql_stet .= ' GROUP BY `products_values`.`prod_id`';

	/*
	  if($single != 1 && $single != 0) {
	  $sql_stet .= ' HAVING total > 1';
	  }

	  $sql_stet .= '  LIMIT 10';
	 */

	$query = DB::query(Database::SELECT, $sql_stet);

	/*
	  if (isset($cat)) {
	  $query->bind(':id', $cat);
	  }
	 */

	return $res = $query->execute()->as_array();
    }

    public function getProductById($id) {

	$sql_stet = "select"
		. "`products`.* , `products_categories`.*  FROM `products`"
		. "JOIN `products_categories` ON (`products_categories`.`product_id` = `products`.`id`)"
		#. "JOIN `manufactures` ON (`manufactures`.`id` = `products`.`manufacture_id`)"
		. "WHERE `products`.`id` = :id";

	$query = DB::query(Database::SELECT, $sql_stet);
	$query->bind(':id', $id);

	$res = $query->execute()->as_array();

	return $res = $res[0];
    }

    public function getProductImage($id) {

	$sql_stet = "select * FROM  `images`"
		. "WHERE `images`.`product_id` = :id";

	$query = DB::query(Database::SELECT, $sql_stet);
	$query->bind(':id', $id);
	return $res = $query->execute()->as_array();
    }

    public function getValues($id = null) {
	if ($id) {
	    /* $sql_stet = "select * from  `filters`  JOIN  `values` "
	      . "ON (`filters`.`id` = `values`.`filter_id`) JOIN `products_values` ON (`values`.`id` =  `products_values`.`value_id`) WHERE `products_values`.`prod_id` = :id"; */

	    $sql_stet = "select * from  `filters`  LEFT JOIN  `values` "
		    . "ON (`filters`.`id` = `values`.`filter_id`) JOIN `products_values` ON (`values`.`id` =  `products_values`.`value_id`) JOIN `category_filters` ON ( `category_filters`.`filter_id` = `filters`.`id`) WHERE `products_values`.`prod_id` = :id";

	    $query = DB::query(Database::SELECT, $sql_stet);

	    $res = $query->param(':id', $id)->execute()->as_array();

	    return $res;
	}
    }

    /**
     * @deprecated
     */
    public function optionService($cat_id) {
	$sql_stet = "select * from  `products`  JOIN  `products_categories` "
		. "ON (`products`.`id` = `products_categories`.`product_id`)"
		. " WHERE  `products_categories`.`category_id` = :cat_id"
		. " AND `products`.`type_id` = 2";

	$query = DB::query(Database::SELECT, $sql_stet);

	$res = $query->param(':cat_id', $cat_id)->as_object()->execute();

	return $res;
    }

    public function getProductServices($prod_id) {
	
    }

    public function productAddServices($prod_id, array $servies) {
	
	$this->productRemoveServices($prod_id);
	
	if(empty($servies)) {
	    return false;
	}
	
	//products_services
	$res = array();
	$sql_stet = 'INSERT INTO products_services (prod_id,service_id) VALUES (:prod_id,:service_id)';

	$query = DB::query(Database::INSERT, $sql_stet)
		->bind(':prod_id', $prod_id);

	foreach ($servies as $s) {

	    $res[] = $query->bind(':service_id', $s)
		    ->execute();
	}

    }

    protected function productRemoveServices($prod_id) {
	
	    $sql = "DELETE FROM `products_services` WHERE `prod_id` = {$prod_id}";

	    $result = DB::query(Database::DELETE, $sql)->execute();
	    
    }

    public function productListServices($prod_id) {
	
	$sql_stet = "SELECT * FROM `service_categories` LEFT JOIN (SELECT `products_services`.`prod_id` AS `revel_prod`,`products_services`.`service_id` AS `serv_id` FROM `products_services` WHERE `products_services`.`prod_id` = :prod_id) `product` ON (`service_categories`.`service_id` = `product`.`serv_id`) JOIN `services` ON (`services`.`id` = `service_categories`.`service_id`) WHERE  `service_categories`.`cat_id` = (SELECT `products_categories`.`category_id` FROM `products_categories` WHERE `products_categories`.`product_id` =:prod_id)";

	$result = DB::query(Database::SELECT, $sql_stet)
			->bind(':prod_id', $prod_id)
			->execute()->as_array();
	
#	echo $result;exit();
	return $result;
    }

}
