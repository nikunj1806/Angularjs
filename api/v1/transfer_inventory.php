<?php

//header('Content-Type: text/html; charset=utf-8');
require_once '../html/includes/include.php';


if (array_key_exists('_wysihtml5_mode', $_POST)) {
    unset($_POST['_wysihtml5_mode']);
}
//print_r($_POST);



$insert_uncommon_fields = array(
    "created_by" => "" . $_SESSION['user_data'][0]['user_id'] . "",
    "modified_by" => "" . $_SESSION['user_data'][0]['user_id'] . "",
    "created_date" => date('Y-m-d H:i:s'),
    "modified_date" => date('Y-m-d H:i:s'));
$update_uncommon_fields = array(
    "modified_by" => "" . $_SESSION['user_data'][0]['user_id'] . "",
    "modified_date" => date('Y-m-d H:i:s'));
$a = array();
$a['st_number'] = $_POST['transfer']['st_number'];
$a['date'] = $_POST['transfer']['date'];

$insert_data = array_merge($insert_uncommon_fields, $a);
$id = $db->insert($_POST['table'], $insert_data);
if ($id) {
    $b = array();
    for ($i = 0; $i < sizeof($_POST['item_code']); $i++) {
        $b['item_id'] = $_POST['item_id'][$i];
        $b['transfer_id'] = $id;
        $b['quntity_transferred'] = $_POST['quantity'][$i];
        $b['date'] =  date('Y-m-d');
        $insert_itemlist = array_merge($insert_uncommon_fields, $b);
        $id2 = $db->insert(TBL_TRANSFERRED_ITEM, $insert_itemlist);
        $c['in_stock_ar'] = $_POST['in_stock_ar'][$i] - $_POST['quantity'][$i];
        $c['in_stock_pd'] = $_POST['quantity'][$i] + $_POST['in_stock_pd'][$i];
        
        $update_itemlist = array_merge($c,$update_uncommon_fields);
        $db->where('id',$_POST['item_id'][$i]);
        $id3 = $db->update(TBL_ITEM,$update_itemlist);
    }
}
if ($id && $id2) {
    $msg = "Data inserted successfully";
    $msg_type = 'success';
} else {
    $msg = "Error inserting";
    $msg_type = 'error';
}
$return = array('msg' => $msg, 'type' => $msg_type);
echo json_encode($return);
?>