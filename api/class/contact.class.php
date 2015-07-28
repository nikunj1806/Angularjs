<?php

class contact {

    protected $_db;

        public function __construct() {
            $this->_db = db::getInstance();
        }
        public function getAllContct(){
            return $data = $this->_db->get(TBL_CONTACT);
        }
        public function getContactByField($category_id, $field_name = '') {
            //echo "applicant_id".$applicant_id;
            $this->_db->where('id', $category_id);
            $data = $this->_db->getOne(TBL_CONTACT);
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
    public function getContactByfilter($type) {
        $this->_db->where('type',$type);
        $data = $this->_db->get(TBL_CONTACT);
        //$data = $this->_db->get('inv_contact con', NULL, 'con.id as id,con.name as label', 'con.id as value1');
        return $data;
    }
	

}
