<?php

class valuation {

    protected $_db;

    public function __construct() {
        $this->_db = db::getInstance();
    }

    public function getAllvaluation() {
        return $data = $this->_db->get(TBL_ITEM);
    }

    
    

}
