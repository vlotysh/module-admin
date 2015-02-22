<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Order_Castom extends Model_Order {

    const ORDER_TYPE = 2;

    public function newOrder($data) {
	
	$sql_order = "INSERT INTO orders (info,user_id,comment,type,date) VALUES (:info,:user_id,:comment,:type,:date)";

	$order_date = date("Y-m-d");
	$info = json_encode($data);
	$status = 0;
	$type = self::ORDER_TYPE;
	
	$query = DB::query(Database::INSERT, $sql_order)
		->bind(':info',$info)
		->bind(':user_id', $data['user_id'])
		->bind(':comment', $data['comment'])
		->bind(':type', $type)
		->bind(':date', $order_date)
		->execute();
	
	$order_id = $query[0];

	return true;	
	
    }
    



}
