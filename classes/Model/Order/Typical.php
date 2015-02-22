<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Order_Typical extends Model_Order {
    
    const ORDER_TYPE = 1;

    public function newOrder($data) {	
	
	try {   
	Database::instance()->begin();	
	
	$sql_order = "INSERT INTO orders (info,price,user_id,comment,type,date) VALUES (:info,:price,:user_id,:comment,:type,:date)";
	$order_date = date("Y-m-d");
	$info = json_encode($data);
	$status = 0;
	$type = self::ORDER_TYPE;

	$query = DB::query(Database::INSERT, $sql_order)
		->bind(':info', $info)
		->bind(':user_id',  $data['user_id'])
		->bind(':price', $data['user_id'])
		->bind(':comment', $data['comment'])
		->bind(':type', $type)
		->bind(':date', $order_date)
		->execute();

	$order_id = $query[0];

	$sql_order_product = "INSERT INTO orders_product (order_id, product_id) VALUES (:order_id, :product_id)";

	$query = DB::query(Database::INSERT, $sql_order_product)
		->bind(':order_id', $order_id)
		->bind(':product_id', $data['product_id'])
		->execute();
	
	if(isset($data['services']) && count($data['services'])) {
	    	    
		$sql_order_service = "INSERT INTO orders_services (order_id, service_id) VALUES ";
	    
	    $sql_order_service .= "({$order_id},{$data['services'][0]})";
	    
	    for ($i = 1;$i < count($data['services']);$i++) {
		
		$sql_order_service .= ",({$order_id},{$data['services'][$i]})";
		
	    }
	    
	    $query = DB::query(Database::INSERT, $sql_order_service)
		    ->execute();
	    
	    $product_update = "UPDATE `olant`.`products` SET `status` = '2' WHERE `products`.`id` = " . $data['product_id'];
		
	    $query = DB::query(Database::INSERT, $product_update)->execute();
			
	}
	
	    Database::instance()->commit();
	 
	}catch(Database_Exception $e) {
	   
	    Database::instance()->rollback();
	    
	    /*echo '<b>File</b> '.$e->getFile().' ';
	    echo '<b>Line</b> '.$e->getLine().' ';
	    echo '<b>Masege</b> '.$e->getMessage();*/
	    
	    return false;
	}

	return true;
    }
    



}
