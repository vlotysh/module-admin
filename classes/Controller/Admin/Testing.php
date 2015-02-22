<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Testing extends Controller_Admin_Index {

    public function before() {
	parent::before();
	//Вывод в шаблон

	$this->auto_render = false;

	Response::factory()->send_headers('Content-Type: text/html; charset=utf-8');
	$this->template->page_title = 'Тестирование';
    }
    public function action_devmod() {
	
	if(!isset($_GET['dev_mod'])) HTTP::redirect ('/');
	
	$dev = $_GET['dev_mod'];
	
	if($dev) {
	    Cookie::set('dev_mod',1);
	}else {
	    Cookie::delete('dev_mod');
	}
	
	$url = Session::instance()->get('last_url');
	HTTP::redirect($url);
	
    }
    public function action_index() {
	$order = Order::Factory(2);
	
	echo $order->createOrder();
    }

    public function action_iframe() {

	echo View::factory('admin/testing/iframe');

    }
    
    public function action_hmvc() {


	
		$csv_file = '/tmp.csv';

	$spreadsheet = Spreadsheet::factory(
			array(
		    'filename' => '/List_Microsoft_Office_Excel_1.xls'
			), FALSE)
		->load()
		->read();

	var_dump($spreadsheet);
	exit();
	foreach ($spreadsheet as $v) {
	    echo $v['A'] . ' ' . $v['C'] . '<br>';
// где $v['A'] - данные из ячейки A страницы Excel
	}
	
	
	
	
	
	
 
	  	  $curl = curl_init();
	 
$fields = array('username' => "строчка с русскими символами",
            'api_key' => urlencode("1234"),
            'images' => array('asd'=>1));

$field_string = http_build_query($fields);

	  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	  curl_setopt($curl, CURLOPT_HEADER, 1);
	 curl_setopt($curl, CURLOPT_HTTPHEADER, array("Cookie: authautologin=f38ea38f9b2eced0c9aec41daff1b3333a8017cd%7E21c13965b543d5d64832fce5e49ba5e465f98f7c"));
	    curl_setopt($curl , CURLOPT_NOBODY, true);
	  curl_setopt($curl, CURLOPT_POST, true);
	  
	  	  curl_setopt($curl, CURLOPT_URL, URL::site('', true) . '/admin/products/add?category=5');
	  curl_setopt($curl, CURLOPT_POSTFIELDS, $field_string);
	  $out = curl_exec($curl);
	  echo '<pre>';
	  print_r($out);
	  echo '</pre>';
	  curl_close($curl);
	  
	  
	  




	/* curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
	  $result = curl_exec($ch); // run the whole process
	  curl_close($ch); */
    }

    public function action_curltest() {

	$download_url = urldecode($this->request->query('url'));

	if (!$download_url)
	    throw new Exception('Требуется GET параметр url');


	/////////////////////
//
//		//Curl example
	/*
	  $url = "http://cs540108.vk.me/c540102/v540102611/3d1b7/YccmKhzn4ng.jpg";


	  $request = Request::factory($url);

	  $request->client()->options(array(
	  CURLOPT_SSL_VERIFYPEER => FALSE
	  ));
	  $res = $request->execute()->headers();

	  foreach ($res as $key => $value) {
	  echo $key . ' ' .$value.'<br>';
	  }

	  echo $res = $request->execute();



	  exit();
	 */
//////////////////////// img curl 

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $download_url);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$response = curl_exec($ch);
	$info = curl_getinfo($ch);

	function get_headers_from_curl_response($response) {
	    $headers = array();

	    foreach (explode("\r\n", $response) as $i => $line)
		if ($i === 0)
		    $headers['http_code'] = $line;
		else {
		    @list ($key, $value) = explode(': ', $line);

		    $headers[$key] = $value;
		}

	    return $headers;
	}

	$headers = get_headers_from_curl_response($response);

	function grab_image($url, $saveto = null) {

	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_HEADER, 1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
	    $raw = curl_exec($ch);

	    curl_close($ch);

	    list($header, $body) = explode("\r\n\r\n", $raw, 2);
	    $header = get_headers_from_curl_response($header);

	    //
	    var_dump($header['Content-Type']);

	    list($type, $format) = explode('/', $header['Content-Type']);

	    if ($type == 'image') {

		$new_file = 'tmp/';

		if (!$saveto) {

		    $new_file .= substr(uniqid(), 0, 10) . '.' . $format;
		} else {

		    $new_file .= $saveto . '.' . $format;
		}


		if (file_exists($new_file)) {
		    unlink($new_file);
		}


		$fp = fopen($new_file, 'x');
		fwrite($fp, $body);
		fclose($fp);

		return $new_file;
	    } else {
		return false;
	    }
	}

	$src = grab_image($download_url);



	echo '<img src="' . URL::base() . $src . '">';
    }

    public function action_cvs() {

	$csv_file = '/tmp.csv';

	$spreadsheet = Spreadsheet::factory(
			array(
		    'filename' => '/tmp1.xls'
			), FALSE)
		->load()
		->read();

	var_dump($spreadsheet);
	exit();
	foreach ($spreadsheet as $v) {
	    echo $v['A'] . ' ' . $v['C'] . '<br>';
// где $v['A'] - данные из ячейки A страницы Excel
	}
    }

}
