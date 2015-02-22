<?php defined('SYSPATH') or die('No direct script access.');

class Model_Password extends ORM {

    protected $_table_name = 'users';
    protected $_primary_key = 'id';
    protected $_db_group = 'default';
}