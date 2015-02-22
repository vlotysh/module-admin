<?php defined('SYSPATH') or die('No direct script access.');

class Model_Delivery extends ORM {
    
    protected $_table_name = 'delivery';
   // protected $_primary_key = 'id';
   // protected $_db_group = 'default';
	
	public function rules()
    {
        return array(
            'title' => array(
                array('not_empty'),
            ),
            'name' => array(
                array('not_empty'),
                array('alpha_dash'),
                array(array($this, 'uniq_alias'), array(':value', ':field')),
            ),

        );


    }


    public function labels()
    {
        return array(
            'title' => 'Название',
            'name' => 'Алиас',
        );
    }

    public function filters()
    {
        return array(
            TRUE => array(
                array('trim'),
            ),
            'title' => array(
                array('strip_tags'),
            ),
        );
    }


    public function uniq_alias($value, $field)
    {
        $delivery = ORM::factory($this->_object_name)
                ->where($field, '=', $value)
                ->and_where($this->_primary_key, '!=', $this->pk())
                ->find();
        
        if ($delivery->pk())
        {
            return false;
        }
        
        
        return true;
    }
	
	
	
}