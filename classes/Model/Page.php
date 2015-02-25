<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Page extends ORM_MPTT {

    protected $_table_name = 'pages';
    protected $_primary_key = 'id';
    protected $_db_group = 'default';

    public function labels() {
        return array(
            'page_title' => 'Название страницы',
            'url' => 'Путь к странице'
        );
    }

    public function rules() {
        return array(
            'page_title' => array(
                array('not_empty'),
                array(array($this, 'unique'), array('page_title', ':value')),
            ),
            'url' => array(
                array('not_empty'),
            ),
        );
    }


}
