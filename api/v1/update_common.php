<?php

//header('Content-Type: text/html; charset=utf-8');
require_once '../html/includes/include.php';

//$mail_format = new mail_format();
//$category = new category();


if (array_key_exists('_wysihtml5_mode', $_POST)) {
    unset($_POST['_wysihtml5_mode']);
}
$sizeof_post = sizeof($_POST);
$new_array = array_slice($_POST, 0, $sizeof_post - 3, true);


$update_common_fields = array(
    "modified_by" => "" . $_SESSION['user_data'][0]['role_id'] . "",
    "modified_date" => date('Y-m-d H-i-s')
);
$condition_filed = explode(',', $_POST['cond_field']);
$condition_value = explode(',', $_POST['cond_value']);
$update_fields = array_merge($update_common_fields, $new_array);
for ($i = 0; $i < sizeof($condition_filed); $i++) {
    $db->where($condition_filed[$i], $condition_value[$i]);
}
if ($db->update($_POST['table'], $update_fields)) {
    $msg = "Data Upadated successfully";
    $msg_type = 'success';
} else {
    $msg = "Error in Updating";
    $msg_type = 'error';
}
$return = array('msg' => $msg, 'type' => $msg_type);




echo json_encode($return);
?>