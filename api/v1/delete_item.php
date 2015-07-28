<?php

//header('Content-Type: text/html; charset=utf-8');
require_once '../html/includes/include.php';
extract($_POST);
$item = new item();



if (array_key_exists('_wysihtml5_mode', $_POST)) {
    unset($_POST['_wysihtml5_mode']);
}

$item_data = $item->getItemByid($_POST['item_id']);
//print_r($item_data);
if ($condition == 2) {
    $a['total_in_stock'] = $item_data['total_in_stock'] - $_POST['quantity'];
    $a['in_stock_ar'] = $item_data['total_in_stock'] - $_POST['quantity'];
} else {
    $a['on_order'] = $item_data['on_order'] - $_POST['quantity'];
}
$db->where('id', $_POST['item_id']);
$id2 = $db->update(TBL_ITEM, $a);
if ($condition == 2) {
    $db->where('general_id', $general_id);
$id = $db->delete(TBL_RECEIVED_ITEM);
} else {
    $db->where('id', $general_id);
    $id = $db->delete(TBL_ORDERED_ITEM);
}

if ($id && $id2) {
    $msg = "Data deleted successfully";
    $msg_type = 'success';
} else {
    $msg = "Error Deleting records";
    $msg_type = 'error';
}
$return = array('msg' => $msg, 'type' => $msg_type);
echo json_encode($return);
?>