<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Mailing extends ORM {

    protected $_table_name = 'mailing';
    protected $_primary_key = 'id';
    protected $_db_group = 'default';
    
        public function labels()
    {
        return array(
            'email' => 'Е-мейл',
        );
    }
    
    public function rules() {
	return array(
	    'email' => array(
		array('not_empty'),
		array('min_length', array(':value', 4)),
		array('max_length', array(':value', 127)),
		array('email'),
	    ),
	);
    }

}
