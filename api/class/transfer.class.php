<?php

class transfer {

    protected $_db;

    public function __construct() {
        $this->_db = db::getInstance();
    }

    public function getAllTrnasfer() {
        return $data = $this->_db->get(TBL_TRANSFER);
    }

    public function getTransferByField($id, $field_name = '') {
        //echo "applicant_id".$applicant_id;
        $this->_db->where('id', $id);
        $data = $this->_db->getOne(TBL_TRANSFER);
        if ($field_name == "") {
            return $data;
        } else {
            $field_names = explode(',', $field_name);
            $return_data = "";
            foreach ($field_names as $field) {
                $return_data.= $data[0][$field] . ' ';
            }
            return trim($return_data);
        }
    }
    
    public function getTransferedItem($id, $field_name = '') {
        //echo "applicant_id".$applicant_id;
        $this->_db->where('transfer_id', $id);
        $data = $this->_db->get(TBL_TRANSFERRED_ITEM);
        foreach ($data as $key => $value){
            $return_all[$key] = self::getItemByTransferId($value['item_id']);
            $a[$key] = array_merge($return_all[$key],$data[$key]);
        }
        return $a;
//        if ($field_name == "") {
//            return $data;
//        } else {
//            $field_names = explode(',', $field_name);
//            $return_data = "";
//            foreach ($field_names as $field) {
//                $return_data.= $data[0][$field] . ' ';
//            }
//            return trim($return_data);
//        }
    }
    public function getItemByTransferId($id){
        $this->_db->where('id', $id);
        return $data = $this->_db->getOne(TBL_ITEM);
    }
    

}
