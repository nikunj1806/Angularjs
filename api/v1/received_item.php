<?php

//header('Content-Type: text/html; charset=utf-8');
require_once '../html/includes/include.php';


if (array_key_exists('_wysihtml5_mode', $_POST)) {
    unset($_POST['_wysihtml5_mode']);
}
//print_r($_POST);
//$sizeof_post = sizeof($_POST['order']);
//$new_array = array_slice($_POST, 0, $sizeof_post-1, true);


$insert_uncommon_fields = array(
    "created_by" => "" . $_SESSION['user_data'][0]['user_id'] . "",
    "modified_by" => "" . $_SESSION['user_data'][0]['user_id'] . "",
    "created_date" => date('Y-m-d H:i:s'),
    "modified_date" => date('Y-m-d H:i:s'));
$update_uncommon_fields = array(
    "modified_by" => "" . $_SESSION['user_data'][0]['user_id'] . "",
    "modified_date" => date('Y-m-d H:i:s'));
$a = array();
$a['batch_number'] = $_POST['receive']['batch_number'];
$a['date'] = $_POST['receive']['date'];
$a['contact_id'] = $_POST['receive']['contact'];
$a['supplier_reference'] = $_POST['receive']['supplier_reference'];

$insert_data = array_merge($insert_uncommon_fields, $a);
$id = $db->insert($_POST['table'], $insert_data);
if ($id) {
    $b = array();
    for($i=0; $i<sizeof($_POST['item_code']);$i++){
        $b['received_id'] = $id;
        $b['item_id'] = $_POST['item_id'][$i];
        $b['quantity_received'] = $_POST['quantity'][$i];
        $b['on_order'] = $_POST['on_order'][$i];
        $b['total_stock'] = $_POST['total_stock'][$i];
        $b['pending'] =  $_POST['total_stock'][$i]-$_POST['on_order'][$i];
        $insert_received_item = array_merge($insert_uncommon_fields, $b);
        $id2 = $db->insert(TBL_RECEIVED_ITEM, $insert_received_item);
        

        $c['on_order'] = $_POST['on_order'][$i];
        $c['total_in_stock'] = $_POST['total_stock'][$i] + $_POST['quantity'][$i];
        $c['in_stock_ar'] = $_POST['in_stock_ar'][$i] + $_POST['quantity'][$i];
        $update_itemlist = array_merge($update_uncommon_fields, $c);
        $db->where('id', $_POST['item_id'][$i]);
        $id3 = $db->update(TBL_ITEM, $update_itemlist);
        
    }

}
if($id && $id2 && $id3){
    $msg = "Data inserted successfully";
    $msg_type = 'success';
} else {
    $msg = "Error inserting";
    $msg_type = 'error';
}
$return = array('msg'=>$msg,'type'=>$msg_type);
echo json_encode($return);
?>