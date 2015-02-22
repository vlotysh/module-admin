<?php defined('SYSPATH') or die('No direct script access.');

class Model_User extends Model_Auth_User {

    protected $_table_name = 'users';
    protected $_primary_key = 'id';
    protected $_db_group = 'default';

//

  public function labels()
    {
        return array(
            'username' => 'Логин',
            'email' => 'E-mail',
            'password' => 'Пароль',
            'password_confirm' => 'Повторить пароль',
        );
    }

    public function rules()
	{
		return array(
			'username' => array(
				array('not_empty'),

			),
			'password' => array(
				array('not_empty'),
			    array('min_length', array(':value', 4)),

			),
                        'captcha' => array(
                            array('Captcha::valid'),
                        ),
			'email' => array(
				array('not_empty'),
				
				array('email'),
			    array(array($this, 'unique'), array('email', ':value')),
			),
			
		);
	}



    public function filters()
    {
        return array(
            TRUE => array(
                array('trim'),
            ),
            'password' => array(
				array(array(Auth::instance(), 'hash'))
			),
			'username' => array(
                array('strip_tags'),
            ),
        );
    }

	

} 
