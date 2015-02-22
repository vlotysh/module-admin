<?php defined('SYSPATH') or die('No direct script access.');

class Model_Feature extends ORM_MPTT {
    protected $_table_name = 'features';
    protected $_primary_key = 'id';
    protected $_db_group = 'default';
    
    protected $_has_many = array(
      'products' => array(
               'model' => 'Product',
               'through' => 'options',
          ),
    );
}