<?php defined('SYSPATH') or die('No direct script access.');

class Model_Download extends Model {

	public function download(){
	$count = DB::query(Database::SELECT, "SELECT download_count from downloads")->execute();
	
	foreach($count as $sum)
	$count =  $sum['download_count']+1;
	
	$row = $query = DB::query(Database::INSERT, "update downloads set download_count=$count where id=1")->execute();
	}
}
