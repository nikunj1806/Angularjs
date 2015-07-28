<?php

class account {

    protected $_db;

    public function __construct() {
        $this->_db = db::getInstance();
    }

    public function getRefferelPrice() {
        $this->_db->orderBy("setting_id", "Desc");
        $data = $this->_db->getOne(TBL_ACCOUNT_SETTINGS, 'value');
        return $data;
    }

    public function get_user_rolebyfields($role_id, $field_name = "") {

        $this->_db->where('role_id', $role_id);
        $data = $this->_db->get(TBL_ROLES);

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

}
