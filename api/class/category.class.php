<?php

class category {

    protected $_db;

        public function __construct() {
            $this->_db = db::getInstance();
        }
        public function getAllcategory(){
            return $data = $this->_db->get(TBL_CATEGORY);
        }
        public function getCategoryByid($category_id, $field_name = '') {
            //echo "applicant_id".$applicant_id;
            $this->_db->where('id', $category_id);
            $data = $this->_db->getOne(TBL_CATEGORY);
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
