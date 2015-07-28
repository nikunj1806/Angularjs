<?php

class receive {

    protected $_db;

    public function __construct() {
        $this->_db = db::getInstance();
    }

    public function getReceived($id) {
        $this->_db->where('id', $id);
        return $data = $this->_db->getOne(TBL_RECEIVE);
    }

    public function getItemByreceivedId($id) {
        
        $this->_db->where('received_id', $id);
        $data = $this->_db->get(TBL_RECEIVED_ITEM);
        
        foreach ($data as $key => $value) {
            $new_arry = self:: getItemByItemId($value['item_id']);
            $category = self:: getCategoryById($new_arry['category']);
            $final[$key] = array_merge($new_arry,$data[$key],$category);
        }
        return $final;
    }

    public function getItemByItemId($id) {
        
        $this->_db->where('id', $id);
        return $data = $this->_db->getOne(TBL_ITEM);
    }
    public function getCategoryById($id) {
        
        $this->_db->where('id', $id);
        return $data = $this->_db->getOne(TBL_CATEGORY);
    }

}
