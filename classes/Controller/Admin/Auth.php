<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Auth extends Controller_Admin_Base {

    public $template = 'admin/login';

    public function before() {
        parent::before();
 
        // Выводим в шаблон
        $this->template->title = 'Вход в пенель управления';
        $this->template->page_title = 'Авторизация';
    }

    public function action_index() {
        
        if(Auth::instance()->logged_in('admin')){
            HTTP::redirect('admin');
        }else {
             $this->action_login(); 
        }
      
    }

    public function action_login() {
        if (isset($_POST['submit'])) {

            $data = Arr::extract($_POST, array('username', 'password', 'remember'));
            $status = Auth::instance()->login($data['username'], $data['password'], (bool) $data['remember']);

            if ($status) {

                if (Auth::instance()->logged_in('admin')) {
                    HTTP::redirect('admin');
                } else {
                    Auth::instance()->logout();
                }


            } else {

                $errors = array(Kohana::message('validation', 'no_user'));
                $this->template->errors = $errors;
            }
        }
    }

    public function action_logout() {

        if (Auth::instance()->logout()) {
            HTTP::redirect('admin');
        }
    }

}
