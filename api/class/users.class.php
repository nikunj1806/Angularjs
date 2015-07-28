<?php

class users {

    protected $_db;

    public function __construct() {
        $this->_db = db::getInstance();
    }

    public function get_users($role_id, $company_id = '') {
        if ($role_id == 1) {
            $this->_db->where('role_id', '2');
            //     $this->_db->where('compny_id', 0);
        } else {
            $this->_db->where('role_id', '2', '>');
            $this->_db->where('company_id', $company_id);
        }
        $data = $this->_db->get(TBL_USERS);
        return $data;
    }

    public function get_username($company_id) {

        $this->_db->where('company_id', $company_id);
        $data = $this->_db->getOne(TBL_USERS, 'username');
        return $data;
    }

    public function get_userbyfield($user_id, $field_name = '') {

        $this->_db->where('user_id', $user_id);
        $data = $this->_db->get(TBL_USERS);

        if ($field_name == "") {
            return $data[0];
        } else {
            $field_names = explode(',', $field_name);
            $return_data = "";
            foreach ($field_names as $field) {
                $return_data.= $data[0][$field] . ' ';
            }
            return trim($return_data);
        }
    }

    public function get_user_field($user_id, $field_name = '') {
        $this->_db->where('user_id', $user_id);

        if (empty($field_name)) {
            $result = $this->_db->get(TBL_USERS);
            $data = $result[0];
        } else {
            $result = $this->_db->get(TBL_USERS, null, $field_name);
            $data = implode(' ', $result[0]);
        }
        return $data;
    }

}
