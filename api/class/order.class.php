<?php

class order {

    protected $_db;

        public function __construct() {
            $this->_db = db::getInstance();
        }
        public function getAllOrder(){
            return $data = $this->_db->get(TBL_ORDER);
        }
        public function getOrderByField($id, $field_name = '') {
            //echo "applicant_id".$applicant_id;
            $this->_db->where('id', $id);
            $data = $this->_db->getOne(TBL_ORDER);
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
        public function getSearchContact($term) {
        $this->_db->where("name LIKE '%$term%'");
        
        $data = $this->_db->get('inv_contact con', NULL, 'con.id as id,con.name as label', 'con.id as value1');
        return $data;
    }
	

}
