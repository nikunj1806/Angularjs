<?php
class subsription {
    protected $_db;
    
    public function __construct() {
        $this-> _db = db::getInstance();
    }
    
    public function get_all_record() {
	
        $data = $this->_db->get(TBL_SUBSCRIPTION);
	return $data;
    }
    
     public function get_record_paypal($method) {
//        $this->_db->where('payment_method', $method);
//        $this->_db->groupBy('applicant_id');
//        $data = $this->_db->get(TBL_SUBSCRIPTION);
//        return $data;
         $r = $this->_db->rawQuery("select applicant_id, sum(total_price) as total from rms_subscription where payment_method = '".$method."' group by applicant_id");
         return $r;
    }
    
    public function get_record_paypal_cid($customer_id, $method) {
//        $this->_db->where('payment_method', $method);
//        $this->_db->groupBy('applicant_id');
//        $data = $this->_db->get(TBL_SUBSCRIPTION);
//        return $data;
         $r = $this->_db->rawQuery("select applicant_id, sum(total_price) as total from rms_subscription where payment_method = '".$method."' and customer_id = '".$customer_id."' group by applicant_id");
         return $r;
    }
    
    public function get_selected_record($customer_id) {
	$this->_db->where('customer_id', $customer_id);
        $data = $this->_db->get(TBL_SUBSCRIPTION);
	return $data;
    }
    
    public function get_selected_record2($customer_id, $method) {
	$this->_db->where('customer_id', $customer_id);
        $this->_db_>where('payment_method', ".$method.");
        $data = $this->_db->get(TBL_SUBSCRIPTION);        	
     return $data;
    }
    
}
