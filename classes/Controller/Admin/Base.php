<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Base extends Controller_Template {

    public $template = 'admin/layout';
    public $themes = 'default';
    protected $user;
    protected $auth;
    protected $cache;
    protected $session;
    public $url;
    public $uri;

    public function before() {
        Kohana::add_path('thems/' . $this->themes . '/');
        parent::before();

        I18n::lang('ru');

        // $this->cache = Cache::instance('file');
        $this->session = Session::instance();
        $this->auth = Auth::instance();
        $this->user = $this->auth->get_user();
        $this->url = URL::site('admin');
        $this->uri = $this->request->uri();

        //Вывод в шаблон
        $this->template->title = null;
        $this->template->page_title = null;
        
        list( $this->template->errors, $this->template->message) = Notification::getNotification();

        // Подключаем стили и скрипты
        $this->template->styles = array();
        $this->template->scripts = array();

        //Подключаем блоки
        $this->template->admin_menu = null;
        $this->template->block_left = null;
        $this->template->block_center = null;
        $this->template->block_right = null;
    }

}
