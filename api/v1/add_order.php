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
$a['order_number'] = $_POST['order']['order_number'];
$a['date'] = $_POST['order']['date'];
$a['delivery_date'] = $_POST['order']['delivery_date'];
$a['contact'] = $_POST['order']['contact'];
$a['client_reference'] = $_POST['order']['client_reference'];
$a['status'] = $_POST['order']['status'];
$insert_data = array_merge($insert_uncommon_fields, $a);
$id = $db->insert($_POST['table'], $insert_data);
if ($id) {
    $b = array();
    for($i=0; $i<sizeof($_POST['item_code']);$i++){
        $b['item_id'] = $_POST['item_code'][$i];
        $b['item_code'] = $_POST['item_code2'][$i];
        $b['item_name'] = $_POST['item_name'][$i];
        $b['size'] = $_POST['size'][$i];
        $b['category'] = $_POST['category'][$i];
        $b['quantity'] = $_POST['quantity'][$i];
        $b['on_order'] = $_POST['on_order'][$i];
        $b['total_stock'] = $_POST['total_stock'][$i];
        $b['pending'] = $_POST['pending'][$i];
//        $b['status'] = $_POST['status'][$i];
        $b['order_id'] = $id;
        $insert_itemlist = array_merge($insert_uncommon_fields, $b);
        $id2 = $db->insert(TBL_ORDERED_ITEM, $insert_itemlist);
        //$c['on_order'] = $_POST['on_order'][$i];
        $c['total_in_stock'] = $_POST['total_stock'][$i];
        $c['on_order'] = $_POST['on_order'][$i] + $_POST['quantity'][$i];
        $update_itemlist = array_merge($update_uncommon_fields, $c);
        $db->where('id', $_POST['item_code'][$i]);
        $id3 = $db->update(TBL_ITEM, $update_itemlist);
    }

}
if($id && $id2){
    $msg = "Data inserted successfully";
    $msg_type = 'success';
} else {
    $msg = "Error inserting";
    $msg_type = 'error';
}
$return = array('msg'=>$msg,'type'=>$msg_type);
echo json_encode($return);
?>