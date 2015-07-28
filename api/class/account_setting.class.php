<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of account_setting
 *
 * @author IT
 */
class account_setting {
    
    protected $_db;

    public function __construct() {
        $this->_db = db::getInstance();
    }
    
    public function get_price() {
	
        
        $data = $this->_db->rawQuery("SELECT * FROM rms_account_settings ORDER BY setting_id DESC LIMIT 1");
        return $data[0];
	}

}
