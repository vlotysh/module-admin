<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Order extends ORM {

    const TYPICAL = 1;
    const CASTOM = 2;

    protected $_table_name = 'orders';
    protected $_primary_key = 'order_id';
    protected $_db_group = 'default';
    
    protected $_belongs_to = array(
	'users' => array(
	    'model' => 'User',
	    'foreign_key' => 'order_user_id'
	),
    );

    public function newOrder($data) {
	throw new Exception('Использовать унаследованный метод');
    }

}
