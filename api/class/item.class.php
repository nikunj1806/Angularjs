<?php

class item {

    protected $_db;

        public function __construct() {
            $this->_db = db::getInstance();
        }
        public function getAllItem(){
            return $data = $this->_db->get(TBL_ITEM);
        }
        public function getItemByid($id, $field_name = '') {
            //echo "applicant_id".$applicant_id;
            $this->_db->where('id', $id);
            $data = $this->_db->getOne(TBL_ITEM);
            if ($field_name == "") { 
                return $data;
            } 
            else {
                $field_names = explode(',', $field_name);
                $return_data = "";
                foreach ($field_names as $field) {
                    $return_data.= $data[0][$field] . ' ';
                }
                return trim($return_data);
            }
        }
        public function getOrderItemByOrderid($id, $field_name = '') {
            
            $this->_db->where('order_id', $id);
            $data = $this->_db->get(TBL_ORDERED_ITEM);
            if ($field_name == "") { 
                return $data;
            } 
            else {
                $field_names = explode(',', $field_name);
                $return_data = "";
                foreach ($field_names as $field) {
                    $return_data.= $data[0][$field] . ' ';
                }
                return trim($return_data);
            }
        }
        public function getItemByCategory_id($id, $field_name = '') {
            
            $this->_db->where('category', $id);
            $data = $this->_db->get(TBL_ITEM);
            if ($field_name == "") { 
                return $data;
            } 
            else {
                $field_names = explode(',', $field_name);
                $return_data = "";
                foreach ($field_names as $field) {
                    $return_data.= $data[0][$field] . ' ';
                }
                return trim($return_data);
            }
        }
        public function getOnOrderItemByitemId($id, $field_name = '') {
            
            $this->_db->where('item_code', $id);
            $data = $this->_db->get(TBL_ORDERED_ITEM);
            if ($field_name == "") { 
                return $data;
            } 
            else {
                $field_names = explode(',', $field_name);
                $return_data = "";
                foreach ($field_names as $field) {
                    $return_data.= $data[0][$field] . ' ';
                }
                return trim($return_data);
            }
        }
	

}
