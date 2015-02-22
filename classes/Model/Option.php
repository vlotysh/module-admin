<?php defined('SYSPATH') or die('No direct script access.');

class Model_Feature extends ORM {
      protected $_has_many = array(
      

        'orders' => array(
            'model' => 'Order',
            'foreign_key' => 'product_id',
            'through' => 'Orders_Products',
            'far_key' => 'orders_id',
        ),
    );
    
}