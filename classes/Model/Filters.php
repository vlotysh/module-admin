<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Filters extends Model {

    public function getAllFilters() {
        return $query = DB::query(Database::SELECT, "select * from filters")->execute()->as_array();

        # return $query = DB::query(Database::SELECT, "select * from filters JOIN `values` ON (`filters`.`id` = `values`.`filter_id`) order by `values`.`filter_id`, `values`.`value`")->execute()->as_array();
    }

    public function addFilter($data) {

        #filte_title

        list($insert_filter_id, $affected_rows) = DB::query(Database::INSERT, $sql = "INSERT INTO `kohshop`.`filters` (`id`, `filter_title`, `position`, `visible`) VALUES (NULL, '" . $data['filte_title'] . "', '1', '1');")->execute();


        if (isset($data['categories']))
            $car_str = implode(',', $data['categories']);

        $sql = "insert into `kohshop`.`category_filters` (`cat_id`, `filter_id`)";

        if (isset($data['categories'])) {

            $i = 0;

            foreach ($data['categories'] as $cat) {
                if ($i == 0) {
                    $sql .= " VALUES ('" . $cat . "', '" . $insert_filter_id . "')";
                } else {
                    $sql .= ", ('" . $cat . "', '" . $insert_filter_id . "')";
                }


                $i++;
            }
        } else {
            $sql .= " VALUES ('0', '" . $insert_filter_id . "')";
        }


        $query = DB::query(Database::INSERT, $sql)->execute();

        return $query;
    }

    public function visibleFilter() {
        //Запрос
        #UPDATE `filters` SET `filters`.`visible` = ABS( ABS(`filters`.`visible`) - 1) WHERE `filters`.`id` = 3
    }

    public function updateFilter($data = '') {

        if (isset($data['categories']))
            $car_str = implode(',', $data['categories']);


        $q1 = DB::query(Database::DELETE, 'DELETE FROM `category_filters` WHERE `category_filters`.`filter_id` = ' . $data['filter_id'] . ' ')->execute();


        if (!isset($data['categories']))
            return true;

        $sql = "insert into `kohshop`.`category_filters` (`cat_id`, `filter_id`)";

        if ($data['categories']) {

            $i = 0;

            foreach ($data['categories'] as $cat) {
                if ($i == 0) {
                    $sql .= " VALUES ('" . $cat . "', '" . $data['filter_id'] . "')";
                } else {
                    $sql .= ", ('" . $cat . "', '" . $data['filter_id'] . "')";
                }


                $i++;
            }
        }


        $query = DB::query(Database::INSERT, $sql)->execute();

        return $query;
    }

    public function deleteFilter($filter_id) {

        $db = Database::instance();

        $db->begin();

        try {

            $q1 = DB::query(Database::DELETE, 'DELETE FROM `products_values` WHERE `products_values`.`value_id` IN (SELECT  `values`.`id` FROM `values` WHERE  `values`.`filter_id` = ' . $filter_id . ' ) ')->execute();

            $q2 = DB::query(Database::DELETE, 'DELETE FROM `category_filters` WHERE `category_filters`.`filter_id` = ' . $filter_id . ' ')->execute();

            $q3 = DB::query(Database::DELETE, 'DELETE FROM `filters` WHERE `filters`.`id` = ' . $filter_id . ' ')->execute();

            $q4 = DB::query(Database::DELETE, 'DELETE FROM `values` WHERE `values`.`filter_id` = ' . $filter_id . ' ')->execute();

            $db->commit();
        } catch (Database_Exception $e) {
            $db->rollback();
            echo $e->getMessage();
            exit();
        }
    }

    public function getFiltersByCat($cat_id = null, $values = array()) {

        if ($values) {


            $values = str_replace('-', ',', $values);

            $sql_sub = "select *,count(`values`.`id`) from `values` WHERE `values`.`id` IN ($values) GROUP by `values`.`filter_id`  ";

            $sub_query = DB::query(Database::SELECT, $sql_sub)->execute()->as_array();


            if (count($sub_query) == 1) {

                var_dump($sub_query[0]['filter_id']);

                $sql_1 = "select *,count(`values`.`id`) AS `Total` from `filters`  JOIN `category_filters` "
                        . "ON (`filters`.`id` = `category_filters`.`filter_id`) "
                        . "JOIN `values` ON (`filters`.`id` = `values`.`filter_id`) "
                        . "JOIN `products_values` ON (`values`.`id` = `products_values`.`value_id`) "
                        . "JOIN `products_categories` ON (`products_values`.`prod_id` = `products_categories`.`product_id`)  "
                        . "WHERE `category_filters`.`cat_id` = :id AND `products_categories`.`category_id` = :id";

                $sql_1 .= " AND `products_values`.`prod_id` IN ( SELECT `products_values`.`prod_id`
                FROM `products_values` 
                JOIN `values` ON (`products_values`.`value_id` = `values`.`id`)
                WHERE `products_values`.`value_id`
                IN ( $values )) AND `values`.`filter_id` <> " . $sub_query[0]['filter_id'] . " GROUP BY `values`.`id` order by `values`.`filter_id`";




                $query = DB::query(Database::SELECT, $sql_1);

                $res_sub = $query->param(':id', $cat_id)->execute()->as_array();


                $sql_2 = "SELECT * , count( `values`.`id` ) AS `Total`
                    FROM `filters`
                    JOIN `category_filters` ON ( `filters`.`id` = `category_filters`.`filter_id` )
                    JOIN `values` ON ( `filters`.`id` = `values`.`filter_id` )
                     JOIN `products_values` ON (`values`.`id` = `products_values`.`value_id`)
                        JOIN `products_categories` ON (`products_values`.`prod_id` = `products_categories`.`product_id`)                    WHERE `category_filters`.`cat_id` = :id
                    
                    AND `values`.`filter_id` = :filter_id
                    GROUP BY `values`.`id`
                    ORDER BY `values`.`filter_id` , `values`.`value`";

                $query2 = DB::query(Database::SELECT, $sql_2);

                $res_main = $query2->param(':filter_id', $sub_query[0]['filter_id'])->param(':id', $cat_id)->execute()->as_array();

                $result = array_merge($res_sub, $res_main);
            } else {

                $sql_1 = "select *,count(`values`.`id`) AS `Total` from `filters`  JOIN `category_filters` "
                        . "ON (`filters`.`id` = `category_filters`.`filter_id`) "
                        . "JOIN `values` ON (`filters`.`id` = `values`.`filter_id`) "
                        . "JOIN `products_values` ON (`values`.`id` = `products_values`.`value_id`) "
                        . "JOIN `products_categories` ON (`products_values`.`prod_id` = `products_categories`.`product_id`)  "
                        . "WHERE";

                $sql_1 .= " `products_values`.`prod_id` IN ( SELECT `products_values`.`prod_id`
                FROM `products_values` 
                JOIN `values` ON (`products_values`.`value_id` = `values`.`id`)
                WHERE `products_values`.`value_id`
                IN ( $values )) GROUP BY `values`.`id` order by `values`.`filter_id`";


                $query = DB::query(Database::SELECT, $sql_1);

                $res_sub = $query->param(':id', $cat_id)->execute()->as_array();

                $result = $res_sub;
            }
        } else {
            $sql_1 = "select *,count(`values`.`id`) AS `Total` from `filters`  JOIN `category_filters` "
                    . "ON (`filters`.`id` = `category_filters`.`filter_id`) "
                    . "JOIN `values` ON (`filters`.`id` = `values`.`filter_id`) "
                    . "JOIN `products_values` ON (`values`.`id` = `products_values`.`value_id`) "
                    . "JOIN `products_categories` ON (`products_values`.`prod_id` = `products_categories`.`product_id`)  "
                    . "WHERE `category_filters`.`cat_id` = :id AND `products_categories`.`category_id` = :id";

            /*$sql_1 .= " GROUP BY `values`.`id` order by `values`.`filter_id`";
            
            $sql_1 = "select *,count(`values`.`id`) AS `Total` from `filters`  JOIN `category_filters` "
                    . "ON (`filters`.`id` = `category_filters`.`filter_id`) "
                    . "JOIN `values` ON (`filters`.`id` = `values`.`filter_id`) "
                    
                    . "WHERE `category_filters`.`cat_id` = :id ";*/

            $sql_1 .= " GROUP BY `values`.`id` order by `values`.`filter_id`";


            $query = DB::query(Database::SELECT, $sql_1);

            $res_sub = $query->param(':id', $cat_id)->execute()->as_array();

            $result = $res_sub;
        }

        return $result;

    }

    public function getFiltersCatList($cat_id) {
        $query = DB::query(Database::SELECT, "select * from `filters`  JOIN `category_filters` "
                        . "ON (`filters`.`id` = `category_filters`.`filter_id`)"
                        . "WHERE `category_filters`.`cat_id` = :id");


        return $res = $query->param(':id', $cat_id)->execute()->as_array();
    }

    public function getFiltersById($filter_id) {
        $query = DB::query(Database::SELECT, "select * from filters  JOIN `category_filters` "
                        . "ON (`filters`.`id` = `category_filters`.`filter_id`) WHERE `filters`.`id` = :id");
        $res = $query->param(':id', $filter_id)->execute()->as_array();

        return $res = $res[0];
    }

    public function getCatsToFilters($filter_id) {

        $cat_filter = array();

        $query = DB::query(Database::SELECT, "select * from filters  JOIN `category_filters` "
                        . "ON (`filters`.`id` = `category_filters`.`filter_id`) WHERE `filters`.`id` = :id");
        $res = $query->param(':id', $filter_id)->execute()->as_array();

        foreach ($res as $r) {
            $cat_filter[] = $r['cat_id'];
        }

        return $cat_filter;
    }

    public function getFilterValues($filter_id) {
        $query = DB::query(Database::SELECT, "select * from `values` WHERE `filter_id` = :id order by `value`");
        return $res = $query->param(':id', $filter_id)->execute()->as_array();
    }

    public function addFilterValue($title = '', $filter_id = null) {
        if ($title AND $filter_id) {
            try {

                $title = str_replace('\'', '\\\'', $title);

                list($dad['last_id'], $dad['total']) = DB::query(Database::INSERT, "INSERT INTO `kohshop`.`values` (`id`, `filter_id`, `value`) VALUES (NULL, " . $filter_id . ", '" . $title . "')")->execute();

                return $dad['last_id'];
            } catch (Database_Exception $e) {

                Notification::Error($e->getMessage());
            }
        }
    }

    /**

     * INSERT INTO `kohshop`.`products_values` (
      `pv_id` ,
      `value_id` ,
      `prod_id`
      )
      VALUES (
      NULL , '111', '111'
      ), (
      NULL , '123', '123'
      );
     *              */

    /**
     * Добавление связки продукта и свойства для новых продуктов
     * 
     * @param array $values
     * @param type $prod_id
     * @return boolean
     */
    public function addValuesToProduct(array $values, $prod_id = null) {
        $sql = "INSERT INTO `kohshop`.`products_values` (`pv_id`,`value_id`,`prod_id`) VALUES";

        $innserCounter = 0;

        foreach ($values as $val) {

            if ($innserCounter == 0) {
                $sql .= "(NULL , " . $val . ", " . $prod_id . ")";
            } else {
                $sql .= ",(NULL , " . $val . ", " . $prod_id . ")";
            }

            $innserCounter++;
        }

        $res = DB::query(Database::INSERT, $sql)->execute();

        if ($res) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* public function addFilterValue????() {

      list($dad['last_id'],$dad['total']) = DB::query(Database::INSERT, "INSERT INTO `kohshop`.`filters` (`id`, `filter_title`, `position`, `visible`) VALUES (NULL, 'adsdasdasd', '33', '33');")->execute();
      var_dump($dad);

      exit();

      $query = DB::query(Database::INSERT, "insert into `values` (`filter_id`, `value`)  VALUES (:filter_id, :value)");

      return $res = $query->param(':id', $filter_id)->execute()->as_array();
      } */
}
