<?php

//header('Content-Type: text/html; charset=utf-8');
require_once '../html/includes/include.php';
$receive = new receive();
$received_item = $receive->getItemByreceivedId($_POST['cond_value']);

if (array_key_exists('_wysihtml5_mode', $_POST)) {
    unset($_POST['_wysihtml5_mode']);
}

//$sizeof_post = sizeof($_POST['order']);
//$new_array = array_slice($_POST, 0, $sizeof_post-1, true);


$update_common_fields = array(
    "modified_by" => "" . $_SESSION['user_data'][0]['user_id'] . "",
    "modified_date" => date('Y-m-d H:i:s'));
$a = array();
$a['batch_number'] = $_POST['receive']['batch_number'];
$a['date'] = $_POST['receive']['date'];
$a['contact_id'] = $_POST['receive']['contact'];
$a['supplier_reference'] = $_POST['receive']['supplier_reference'];

$condition_filed = explode(',', $_POST['cond_field']);
$condition_value = explode(',', $_POST['cond_value']);
$update_fields = array_merge($update_common_fields, $a);
for ($i = 0; $i < sizeof($condition_filed); $i++) {
    $db->where($condition_filed[$i], $condition_value[$i]);
}
$id = $db->update($_POST['table'], $update_fields);
//if ($id = $db->update($_POST['table'], $update_fields)) {
//    $b = array();
//    for ($i = 0; $i < sizeof($_POST['item_code']); $i++) {
//        $b['item_id'] = $_POST['item_code'][$i];
//        $b['transfer_id'] = $_POST['cond_value'];
//        $b['quntity_transferred'] = $_POST['quntity_transferred'][$i];
//        $b['date'] = $_POST['date'][$i];
//        $update_itemlist = array_merge($update_common_fields, $b);
//        $db->where('id', $_POST['id'][$i]);
//        $id2 = $db->update(TBL_TRANSFERRED_ITEM, $update_itemlist);
//        //$id2 = $db->insert(TBL_ORDERED_ITEM, $insert_itemlist);
//    }
//}
//
if ($id) {

    $msg = "Data Updated successfully";
    $msg_type = 'success';
} else {
    $msg = "Error inserting";
    $msg_type = 'error';
}
$return = array('msg' => $msg, 'type' => $msg_type);
echo json_encode($return);
?>