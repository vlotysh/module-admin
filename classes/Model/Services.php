<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Services extends ORM {

    protected $_table_name = 'services';
    protected $_primary_key = 'id';
    protected $_db_group = 'default';

    /**
     * 
     * Получение списка сервисов
     * 
     * @return array
     */
    public function listService($cat_id = null) {

	$sql = "SELECT `services`.`id`,`services`.`service_title`,`services`.`service_description`,`services`.`service_status`,`service_categories`.`services_price`,`categories`.`category_title` from  `services` "
	. "JOIN `service_categories` ON (`service_categories`.`service_id` = `services`.`id`)"
	. "JOIN `categories` ON (`service_categories`.`cat_id` = `categories`.`id`)";
	
	if($cat_id) {
	    $sql .= "WHERE `service_categories`.`cat_id` = {$cat_id}";
	}
	
	$query = DB::query(Database::SELECT,$sql);
	
	return $query->execute()->as_array();
    }

    /**
     * 
     * Получение информации по сервису
     * 
     * @param int $cat_id
     * @return array
     */
    public function oneService($cat_id) {

	$new_array = array();

	$query = DB::query(Database::SELECT, "SELECT `services`.`id`, `service_categories`.`cat_id`,`services`.`service_title`,`services`.`service_status`,`services`.`service_description`,`service_categories`.`services_price`,`categories`.`category_title` from  `services` "
			. "JOIN `service_categories` ON (`service_categories`.`service_id` = `services`.`id`)"
			. "JOIN `categories` ON (`service_categories`.`cat_id` = `categories`.`id`)"
			. "WHERE  `service_categories`.`service_id` = " . $cat_id);



	$result = $query->execute()->as_array();

	$new_array['id'] = $result[0]['id'];
	$new_array['service_title'] = $result[0]['service_title'];
	$new_array['service_status'] = $result[0]['service_status'];
	$new_array['service_description'] = $result[0]['service_description'];

	foreach ($result as $res) {

	    $new_array['cats'][$res['cat_id']] = $res['services_price'];
	}

	return $new_array;
    }

    /**
     * 
     * Обновление сервиса
     * 
     * @param type $data
     */
    public function updateService($service_id, $data) {

	$result = $this->factory('Services', $service_id)
		->set('service_title', $data['service_title'])
		->set('service_status', $data['status'])
		->set('service_description', $data['service_description'])
		->update();

	$result = $this->addServiceRevelation($service_id, $data);

	return $result;
    }

    /**
     * 
     * Удаление сервиса и связей по id
     * 
     * @param int $service_id
     * @return boolean
     */
    public function deleteService($service_id) {

	$result = $this->removeServiceRevelation($service_id);
	if ($result) {
	    $result = $this->factory('Services', $service_id)->delete();
	}

	return $result ? true : false;
    }

    /**
     * 
     * Добавление нового сервиса
     * 
     * @param type $post
     * @return boolean
     */
    public function addNewService($data) {

	try {

	    $query = DB::query(Database::INSERT, "INSERT INTO services (service_title, service_status,service_description) VALUES (:title, :status,:description)")
		    ->bind(':title', $data['service_title'])
		    ->bind(':status', $data['status'])
		    ->bind(':description', $data['service_description'])
		    ->execute();

	    $service_id = $query[0];

	    $result = $this->addServiceRevelation($service_id, $data);
	} catch (Exception $e) {
	    echo $e->getMessage();
	    exit();
	    return $result;
	}

	return $result;
    }

    /**
     * 
     * Добавление связи сервис-категория, Один-к-Многим
     * 
     * @param int $service_id
     * @param array $cats
     * @return boolean
     */
    private function addServiceRevelation($service_id, $data) {

	//удаление старых связей перед добавлением новых
	$this->removeServiceRevelation($service_id);

	$sql = 'INSERT INTO service_categories (service_id,cat_id,services_price) VALUES ';

	$first = true;

	foreach ($data['cats'] as $cat) {

	    if ($first) {
		$sql.= "({$service_id},{$cat},{$data['cat_price'][$cat]})";
		$first = false;
	    } else {
		$sql.= ",({$service_id},{$cat},{$data['cat_price'][$cat]})";
	    }
	}

	$query = DB::query(Database::INSERT, $sql);
	$result = $query->execute();

	return $result ? true : false;
    }

    /**
     * 
     * Удаление связи сервиса и категорий
     * 
     * @param type $service_id
     * @return boolean
     */
    private function removeServiceRevelation($service_id) {

	$db = Database::instance();

	try {
	    $db->begin();

	    $sql = "DELETE FROM `service_categories` WHERE `service_id` = {$service_id}";

	    $result = DB::query(Database::DELETE, $sql)->execute();

	    $db->commit();
	} catch (Database_Exception $e) {

	    $db->rollback();

	    $result = false;
	}

	return $result ? true : false;
    }
    


}
