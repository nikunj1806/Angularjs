<?php

//header('Content-Type: text/html; charset=utf-8');
require_once '../html/includes/include.php';

//$mail_format = new mail_format();
//$category = new category();


if (array_key_exists('_wysihtml5_mode', $_POST)) {
    unset($_POST['_wysihtml5_mode']);
}
$sizeof_post = sizeof($_POST);
$new_array = array_slice($_POST, 0, $sizeof_post-1, true);


$insert_uncommon_fields = array(
    "created_by" => "" . $_SESSION['user_data'][0]['user_id'] . "",
    "modified_by" => "" . $_SESSION['user_data'][0]['user_id'] . "",
    "created_date" => date('Y-m-d H:i:s'),
    "modified_date" => date('Y-m-d H:i:s'));
$insert_data = array_merge($insert_uncommon_fields, $new_array);

$id = $db->insert($_POST['table'], $insert_data);
if ($id) {
    $msg = "Data inserted successfully";
    $msg_type = 'success';
} else {
    $msg = "Error inserting";
    $msg_type = 'error';
}
$return = array('msg'=>$msg,'type'=>$msg_type);
    



echo json_encode($return);
?>