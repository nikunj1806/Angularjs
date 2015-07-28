<?php
//header('Content-Type: text/html; charset=utf-8');
require_once '../html/includes/include.php';
error_reporting(E_ALL);
$mail_format = new mail_format();

$check = (isset($_POST['app_ref'])) ? 1 : 0;

$id2 = 0;
if (array_key_exists('_wysihtml5_mode', $_POST)) {
    unset($_POST['_wysihtml5_mode']);
}

if ($_POST['user'] == 2) {
    if (isset($_POST['company']['register_me']) && $_POST['company']['register_me'] == 1) {
        $new_array1 = array();
        $pass1 = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $val = substr(str_shuffle($pass1), 0, 10);
        $user_password = $val;
        $new_array1['password'] = md5($user_password);
        $sizeof_post = sizeof($_POST['company']);
        $company_array = array_slice($_POST['company'], 0, $sizeof_post, true);
        //print_r($company_array);
        $new_array = array_merge($new_array1, $company_array);
    } else {
        $sizeof_post = sizeof($_POST['company']);
        $new_array = array_slice($_POST['company'], 0, $sizeof_post, true);
    }
} else {
    $new_array = '';
}
$sizeof_post2 = sizeof($_POST['applicant']);
$new_array2 = array_slice($_POST['applicant'], 0, $sizeof_post2, true);
extract($_POST);
$msg = '';
$insert_uncommon_fields = array(
    "created_date" => date('Y-m-d H:i:s'),
    "modified_date" => date('Y-m-d H:i:s'));
$insert_data2 = array_merge($insert_uncommon_fields, $new_array2);
if ($_POST['user'] == 2) {
    $insert_data = array_merge($insert_uncommon_fields, $new_array);
} else {
    $insert_data = '';
}
//print_r($insert_data);
$c = array();
if ($_POST['user'] == 2) {
    $customer = new customer();
    $customer_data = $customer->check_data($insert_data['email']);
    //print_r($customer_data);
    if(sizeof($customer_data) > 0)
    {
        $return = array(
           'message' => "Employer Email Address Already Exist",
           'type' => "warning",
           'for' => "email",
        );
      
    }
    else
    {
        $id = $db->insert($_POST['table_name'], $insert_data);
        if ($id) {
            $msg = "Employer Submitted successfully";
            $msg_type = 'success';
            $for = 'cust';
        } else {
            $msg = "Error inserting";
            $msg_type = 'error';
            $for = "cust";
        }
        $return = array(
            "id" => $id,
            "message" => $msg,
            "type" => $msg_type,
            "for" => $for
        );
    }
//echo "id".$id;
    if (isset($_POST['company']['register_me']) && $_POST['company']['register_me'] == 1) {
        $mail_data = array();
        $mail_data['first_name'] = $insert_data['contact_fname'];
        $mail_data['last_name'] = $insert_data['contact_lname'];
        $mail_data['email'] = $insert_data['email'];
        $mail_data['phone'] = $insert_data['cell_number'];
        $mail_data['password'] = $user_password;
        $mail_data['company_name'] = $lang->lang['company_name'];
        $mail_data['link_forward'] = SITE_URL . 'signup.php';
        $subject = $mail_format->render_subject(1, $mail_data);
        $message = $mail_format->render_message(1, $mail_data);
        $fn->send_mail($mail_data['email'], '', '', $subject, $message, $alert_msg = '', $attachments = '');
    }
} else {
    $id = $_POST['company']['customer_id'];
}

if (($_POST['user'] == 1)  || (sizeof($customer_data) == 0 && $check == 1)) {
    if ($id) {
        $c['customer_id'] = $id;
        $insert_applicant_array = array_merge($insert_data2, $c);
        $id2 = $db->insert(TBL_APPLICANTS, $insert_applicant_array);
        $_SESSION['applicant_id'] = $id2;
        //print_r($id2);
        function rsendSMS($content) {
            $ch = curl_init('https://www.smsbroadcast.com.au/api-adv.php');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close($ch);
            return $output;
        }
        if ($id2) {
            for ($i = 0; $i < sizeof($_POST['referee']['businesses_name']); $i++) {
                $a = array();
                $a['businesses_name'] = $_POST['referee']['businesses_name'][$i];
                $a['first_name'] = $_POST['referee']['first_name'][$i];
                $a['last_name'] = $_POST['referee']['last_name'][$i];
                $a['applicant_relation'] = $_POST['referee']['applicant_relation'][$i];
                $a['email'] = $_POST['referee']['email'][$i];
                $a['cell_number'] = $_POST['referee']['cell_number'][$i];
                $a['land_number'] = $_POST['referee']['land_number'][$i];
                $a['position_held'] = $_POST['referee']['position_held'][$i];
                $a['emp_start'] = $_POST['referee']['emp_start'][$i];
                $a['emp_end'] = $_POST['referee']['emp_end'][$i];                
                $a['is_active'] = $_POST['referee']['is_active'][$i];
                $a['applicant_id'] = $id2;
                $insert_referee_data = array_merge($insert_uncommon_fields, $a);
                //print_r($insert_data_app);
                $id3 = $db->insert(TBL_REFEREE, $insert_referee_data);
                //print_r($id3);
                $ref = new referee();
                $ref_data = $ref->get_record($id3);
                //print_r($ref_data);
                $customer = new customer();
                $cdata = $customer->get_customerbyfield($c['customer_id']);
                //print_r($cdata['email']);
                if ($_POST['user'] == 1) {
                    $mail_data2 = array();
                    $mail_data2['first_name'] = $cdata['contact_fname'];
                    $mail_data2['last_name'] = $cdata['contact_lname'];
                    $mail_data2['link_forward'] = SITE_URL . 'signup.php';
                    $mail_data2['email'] = $cdata['email'];
                    //print_r($mail_data2['email']);
                    $subject = $mail_format->render_subject(5, $mail_data2);
                    $message = $mail_format->render_message(5, $mail_data2);
                    $fn->send_mail($mail_data2['email'], '', '', $subject, $message, $alert_msg = '', $attachments = '');                                        
                    $username = 'DE';
                    $password = 'desms111';
                    $destination = $cdata['cell_number']; //Multiple numbers can be entered, separated by a comma
                    $source = 'CTP Team';
                    $text = 'Hi,'."\n".'An applicant has submitted a reference.Please login & approve by selecting the survey type & payment method'."\n";
                    $text .='<a href="'.SITE_URL.'signup.php">Click Here</a>'; 
                    $text .="\n".'Regards'."\n".'CTP';                                                                            
            //        $content = 'username=' . rawurlencode($username) .
            //                '&password=' . rawurlencode($password) .
            //                '&to=' . rawurlencode($destination) .
            //                '&from=' . rawurlencode($source) .
            //                '&message=' . rawurlencode($text) .
            //                '&ref=' . rawurlencode($ref);
                    $len = strlen($text);  
                    
                    if(strlen($text) > 160)
                    {
                       $smsg = str_split($text,97);
                       //print_r($smsg);
                       $many = count($smsg);               
                       foreach($smsg as $index => $msg)
                       {
                            $msg_num = $index + 1;
                            
                            $smstext[$msg_num] = "(".$msg_num."/".$many.")".$msg;  
                            //print_r($smstext[$msg_num]);
                            $content = 'username=' . rawurlencode($username) .
                                        '&password=' . rawurlencode($password) .
                                        '&to=' . rawurlencode($destination) .
                                        '&from=' . rawurlencode($source) .
                                        '&message=' . rawurlencode($smstext[$msg_num]);                   
                            $smsbroadcast_response = rsendSMS($content);
                            $response_lines = explode("\n", $smsbroadcast_response);               
                       }
                    }
            //        $smsbroadcast_response = sendSMS($content);
            //        $response_lines = explode("\n", $smsbroadcast_response);        
                    foreach ($response_lines as $data_line) {
                        $message_data = "";
                        $message_data = explode(':', $data_line);
                        if ($message_data[0] == "OK") {                     
                    //print_r($text);            
                            $msge = "The message to " . $message_data[1] . " was successful, with reference " . $message_data[2] . "\n";
                            $msg_typee = 'success';
                        } elseif ($message_data[0] == "BAD") {
                            $msge = "The message to " . $message_data[1] . " was NOT successful. Reason: " . $message_data[2] . "\n";
                            $msg_typee = 'error';
                        } elseif ($message_data[0] == "ERROR") {
                            $msge = "There was an error with this request. Reason: " . $message_data[1] . "\n";
                            $msg_typee = 'error';
                        }
                    }
                }
                if ($_POST['user'] == 2) {
                    $applicant = new applicant();
                    $app_data = $applicant->get_applicantbyfield($id2);
                    //print_r($app_data);
                    $referee = new referee();
                    $referee_data = $referee->get_record($id3);
                    //print_r($referee_data);
                    $msg = '';
//                    $new_array = array();
//                    $new_array['customer_id'] = $app_data['customer_id'];
//                    $new_array['referral_form_id'] = $_POST['referral_form_id'];
//                    $new_array['applicant_id'] = $id2;
//                    $new_array['referee_id'] = $id3;
//                    $new_array['status'] = 1;
                    $_SESSION['customer_id'] = $app_data['customer_id'];
                    $rf_id[$i] = $_POST['referee']['referral_form_id'][$i];
                    $ref_id[$i] = $id3;
//                    $id4 = $db->insert(TBL_FEEDBACK, $new_array);
//                    $feedback = new feedback();
//                    $feedback_data = $feedback->feedback_data($id4);
//                    //print_r($feedback_data);
//                    //print_r($referee_data[0]['email']);
//                    $mail_data3 = array();
//                    $mail_data3['first_name'] = $referee_data[0]['first_name'];
//                    $mail_data3['last_name'] = $referee_data[0]['last_name'];
//                    $mail_data3['email'] = $referee_data[0]['email'];
//                    $mail_data3['phone'] = $referee_data[0]['cell_number'];
//                    $mail_data3['link_forward'] = SITE_URL . 'demo.php?id=' . $feedback_data[0]['feedback_id'];
//                    $mail_data3['company_name'] = $lang->lang['company_name'];
//                    $subject = $mail_format->render_subject(2, $mail_data3);
//                    $message = $mail_format->render_message(2, $mail_data3);
//                    $fn->send_mail($mail_data3['email'], '', '', $subject, $message, $alert_msg = '', $attachments = '');
                }
            }
            if($_POST['user'] == 2)
            {
                $_SESSION['referal_form_id'] = $rf_id;
                $_SESSION['referee_id'] = $ref_id;
            }
            
            // print_r($_SESSION);
        }
    }
}
if ($id2 != '') {
    if ($id) {
        $msg = "Referee Submitted successfully";
        $msg_type = 'success';
        $for = 'ref';
    } else {
        $msg = "Error inserting";
        $msg_type = 'error';
        $for = 'ref';
    }
    
    if($_POST['user'] == 1)
    {
        $return['sms'] = array(      
            "message" => $msge,
            "type" => $msg_typee,        
        );
        
        $return['ref'] = array(
            "id" => $id,
            "message" => $msg,
            "type" => $msg_type,
            "confirm" => 1
        );
    }
    else
    {
        $return = array(
            "id" => $id,
            "message" => $msg,
            "type" => $msg_type,
            "confirm" => 1,
            "for" => $for
        );
    }
} else {
    // $_SESSION['applicant_id'] = $id2;
   if($customer_data == 0)
   {
//    if ($id) {
//        $msg = "Employer Submitted successfully";
//        $msg_type = 'success';
//    } else {
//        $msg = "Error inserting";
//        $msg_type = 'error';
//    }
//    $return = array(
//        "id" => $id,
//        "message" => $msg,
//        "type" => $msg_type
//    );
   }
}
//print_r($return);
echo json_encode($return);
?>