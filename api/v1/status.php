<?php

require_once '../include.php';
$msg = '';
if ($_REQUEST['do'] == "status") {

    $db->where($_REQUEST['id_field'], $_REQUEST['id']);

    if ($db->update($_REQUEST['table'], Array($_REQUEST['status_field'] => $_REQUEST['status']))) {
        $msg = 'successfully updated';
    } else {
        $msg = 'Error updating';
    }

    $return = array(
        "id" => $_REQUEST['id'],
        "message" => $msg
    );
} else if ($_REQUEST["do"] == "delete") { //to delete the record
    if($_REQUEST['id_field']=='role_id'){
 $db->where('menu_access_role_id',$_REQUEST['id']);
 $db->delete(TBL_MENU_ACCESS);
    
}
    $db->where($_REQUEST['id_field'], $_REQUEST['id']);

    if ($db->delete($_REQUEST['table'])) {
        $msg = 'successfully deleted';
    } else {
        $msg = 'Error deleting';
    }

    $return = array(
        "id" => $_REQUEST['id'],
        "message" => $msg
    );
} else if ($_REQUEST["do"] == "delete_rules") { //to delete the record
    $db->where($_REQUEST['id_field'], $_REQUEST['id']);

    if ($db->delete($_REQUEST['table'])) {
        $msg = 'successfully deleted';
        $db->where($_REQUEST['id_field'], $_REQUEST['id']);
        $db->delete(TBL_ESCALATION_RULE_ENTRY);
    } else {
        $msg = 'Error deleting';
    }

    $return = array(
        "id" => $_REQUEST['id'],
        "message" => $msg
    );
} else if ($_REQUEST['do'] == "menu_reorder") { //to update the record
    $i = 1;
    foreach ($_REQUEST['list'] as $key => $value) {
        $field_array = array('menu_order' => $i, 'menu_parent_id' => $value);

        $db->where('menu_id', $key);

        if ($db->update(TBL_MENUS, $field_array)) {
            $msg = 'successfully updated';
        }
        $i++;
    }
    $return = array(
        "id" => $_REQUEST['id'],
        "message" => $msg
    );
} else if ($_REQUEST['do'] == "menu_access") { //to update the record
    $role_id = $_REQUEST['role_id'];
    //to store the requested menu ids as comma-seperator in database table
    $menu_access_menu_ids = implode(",", $_REQUEST['menu_access_menu_ids']);
    //$dashboard_access_ids = implode(",", $_REQUEST['dashboard_access']);
    //check menu role_id exits
    $db->where('menu_access_role_id', $role_id);
    $db->get(TBL_MENU_ACCESS);
    $check_role_id_row = $db->count;

    if ($check_role_id_row != 0) {
        $db->where("menu_access_role_id", $role_id);
        $update_data = array("menu_access_menu_ids" => $menu_access_menu_ids);
        if ($db->update(TBL_MENU_ACCESS, $update_data)) {
            $msg = "Menu rights updated successfully";
            $type = 'success';
        } else {
            $msg = "Data update fail";
            $type = 'error';
        }
    } else {
        //This is table columns in database
        $uncommon_fields = array("menu_access_status" => "1",
            "menu_access_created_by" => "" . $_SESSION['user_data'][0]['user_id'] . "",
            "menu_access_modified_by" => "" . $_SESSION['user_data'][0]['user_id'] . "",
            "menu_access_created_date" => date('Y-m-d'),
            "menu_access_modified_date" => date('Y-m-d'),
            "menu_access_menu_ids" => $menu_access_menu_ids,
            // "dashboard_access_ids"      => $dashboard_access_ids,
            "menu_access_role_id" => $role_id);

        $id = $db->insert(TBL_MENU_ACCESS, $uncommon_fields);
        if ($id) {
            $msg = "Data inserted successfully";
            $type = 'success';
        } else {
            $msg = "Data insert fail";
            $type = 'error';
        }
//        $db->InsertData($uncommon_fields, TBL_MENU_ACCESS, '');
    }
    $return = array(
        "id" => $role_id,
        "message" => $msg,
        "type" => $type
    );
} else if ($_REQUEST['do'] == "check_lang") {
    $_SESSION['language'] = $_REQUEST['lang_name'];
}

echo json_encode($return);
?>