<?php

//header('Content-Type: text/html; charset=utf-8');
require_once '../include.php';

$mail_format = new mail_format();
$users = new users();

if (array_key_exists('_wysihtml5_mode', $_POST)) {
    unset($_POST['_wysihtml5_mode']);
}
$sizeof_post = sizeof($_POST);
//print_r($_POST);
extract($_POST);
//print_r($_POST['school']);
//echo $_POST['school']['email_daily'];
 if (array_key_exists("email_daily", $school)) {
        $_POST['school']['email_daily'] = 1;
    } else {
       $_POST['school']['email_daily'] = 0;
    }
    if (array_key_exists("email_weekly", $school)) {
         $_POST['school']['email_weekly'] = 1;
    } else {
         $_POST['school']['email_weekly'] = 0;
    }
$new_array = array_merge($_POST['site'], $_POST['school']);
unset($_POST['site']);
unset($_POST['school']);
$msg = '';
//echo'sites_id'.$sites_id;
if ($users_id == '') {
    $insert_uncommon_fields = array(
        "modified_by" => "" . $_SESSION['user_data'][0]['user_id'] . "",
        "created_date" => date('Y-m-d H:i:s'),
        "modified_date" => date('Y-m-d H:i:s'),
        "created_by" => "" . $_SESSION['user_data'][0]['user_id'] . "");
    $insert_data = array_merge($insert_uncommon_fields, $new_array);
    $id = $db->insert(TBL_USERS, $insert_data);
    if ($id) {
        $db->where('card_id', $site['card_id']);
        $db->update(TBL_CARD, array('assign_to' => $id));
        $msg = "Data inserted successfully";
        $msg_type = 'success';
    } else {
        $msg = "Error inserting";
        $msg_type = 'error';
    }
} else {

    $insert_uncommon_fields = array(
        "modified_by" => "" . $_SESSION['user_data'][0]['user_id'] . "",
        "modified_date" => date('Y-m-d H:i:s'));
    $db->where('assign_to', $users_id);
    $db->update(TBL_CARD, array('assign_to' => ''));
    $insert_data = array_merge($insert_uncommon_fields, $new_array);
     
    $db->where("user_id", $users_id);
    $id = $db->update(TBL_USERS, $insert_data);

    if ($id) {
        $msg = "Data Update successfully";
        $msg_type = 'success';
        $db->where('card_id', $site['card_id']);
        $db->update(TBL_CARD, array('assign_to' => $users_id));
    } else {
        $msg = "Error inserting";
        $msg_type = 'error';
    }
}

$return = array(
    "id" => $id,
    "message" => $msg,
    'type' => $msg_type
);
echo json_encode($return);
?>