<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Orders extends Controller_Admin_Index{

	public function before()
	{
		parent::before();
	}

	public function action_index(){

		if(!Auth::instance()->logged_in()) {
				$this->request->redirect('/admin/auth');
		}
		$this->template->page_title = 'Заказы';
        $orders = ORM::factory('Order')->find_all();
		$this->template->block_center = View::factory('admin/order/orders', array('orders'=>$orders));
	}

	public function action_details(){
	
		$id = (int) $this->request->param('id');
		$order = ORM::factory('Order',$id);
		
		$oproducts =  ORM::factory('Orders_Product')->where('order','=',$order->order)->find_all();
		$this->template->page_title = 'Просмотр заказа';
		$this->template->block_center = View::factory('admin/order/order_details', array('order'=>$order, 'oproducts'=>$oproducts));
	}
	
	
	public function action_delete(){
	
		if($this->user->username =='demo') {
                    HTTP::redirect('admin/orders?act=demo');
                    
			exit;
		}
	
	    $id = (int) $this->request->param('id');
        $orders = ORM::factory('Order', $id);

        if(!$orders->loaded()) {
            HTTP::redirect('admin/orders');

        }

        $orders->delete();
        HTTP::redirect('admin/orders');

	}
}