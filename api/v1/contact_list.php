<?php

//header('Content-Type: text/html; charset=utf-8');
require_once '../html/includes/include.php';

//$mail_format = new mail_format();
$contact = new contact();


if (array_key_exists('_wysihtml5_mode', $_POST)) {
    unset($_POST['_wysihtml5_mode']);
}
$contact_data = $contact->getSearchContact($_REQUEST);
$return = array('msg'=>$msg,'type'=>$msg_type,'data'=>$contact_data);
    



//echo json_encode($return);
?>