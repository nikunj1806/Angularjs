<?php

//header('Content-Type: text/html; charset=utf-8');
require_once '../html/includes/include.php';
$item = new item();
$itemlist = $item->getOrderItemByOrderid($_POST['cond_value']);

if (array_key_exists('_wysihtml5_mode', $_POST)) {
    unset($_POST['_wysihtml5_mode']);
}
//print_r($_POST);
//$sizeof_post = sizeof($_POST['order']);
//$new_array = array_slice($_POST, 0, $sizeof_post-1, true);


$update_common_fields = array(
    "modified_by" => "" . $_SESSION['user_data'][0]['user_id'] . "",
    "modified_date" => date('Y-m-d H:i:s'));
$a = array();
$a['order_number'] = $_POST['order']['order_number'];
$a['date'] = $_POST['order']['date'];
$a['delivery_date'] = $_POST['order']['delivery_date'];
$a['contact'] = $_POST['order']['contact'];
$a['client_reference'] = $_POST['order']['client_reference'];
$a['status'] = $_POST['order']['status'];
$condition_filed = explode(',', $_POST['cond_field']);
$condition_value = explode(',', $_POST['cond_value']);
$update_fields = array_merge($update_common_fields, $a);
for ($i = 0; $i < sizeof($condition_filed); $i++) {
    $db->where($condition_filed[$i], $condition_value[$i]);
}
$id = $db->update($_POST['table'], $update_fields);
//if () {
//    $b = array();
//    for ($i = 0; $i < sizeof($_POST['item_code']); $i++) {
//        $b['item_code'] = $_POST['item_code'][$i];
//        $b['item_name'] = $_POST['item_name'][$i];
//        $b['size'] = $_POST['size'][$i];
//        $b['category'] = $_POST['category'][$i];
//        $b['on_order'] = $_POST['on_order'][$i];
//        $b['total_stock'] = $_POST['total_stock'][$i];
//        $b['pending'] = $_POST['pending'][$i];
//        $b['order_id'] = $_POST['cond_value'];
//        
//        $update_itemlist = array_merge($update_common_fields, $b);
//        $db->where('id', $itemlist[$i]['id']);
//        $id2 = $db->update(TBL_ORDERED_ITEM, $update_itemlist);
//        //$id2 = $db->insert(TBL_ORDERED_ITEM, $insert_itemlist);
//    }
//   
//}

if ($id) {

    $msg = "Data inserted successfully";
    $msg_type = 'success';
} else {
    $msg = "Error inserting";
    $msg_type = 'error';
}
$return = array('msg' => $msg, 'type' => $msg_type);
echo json_encode($return);
?>