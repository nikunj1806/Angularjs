<?php

// mysql.php file has functions for select insert update delete. so no need to write static quries. just call functions with parameters.
require_once '../includes/include.php';
//if (session_status() == PHP_SESSION_NONE) {
//    session_start();
//}
$postdata = file_get_contents("php://input");
$request = json_decode($postdata, TRUE);

$return = array();
if ($request['do'] == 'authenticate') {
    //print_r($_POST);
// get password from textbox and converted in md5
    $password = md5($request["password"]);
    $username = $request["email"];
    $db->where("email ", $username);
    $db->where('password', $password);
    $results = $db->get(TBL_USERS);

    // checking whether any match found or not
    if ($db->count > 0) {
        if ($results[0]['first_login'] == 0) {
            $return['response'] = 2;
            $return['user_id'] = $results[0]['user_id'];
            $return['msg'] = 'Your account is not active.';
        } else {
            if ($results[0]['is_active'] == 1) {
                $return['response'] = 1;
                $return['data'] = $results[0];
            } else {
                $return['response'] = 0;
                $return['msg'] = 'Your account is not active.';
            }
        }
    } else {
// record not found. so message shown on screen
        $return['response'] = 0;
        $return['msg'] = 'Invalid User Name OR Password.';
    }
}

echo json_encode($return);





