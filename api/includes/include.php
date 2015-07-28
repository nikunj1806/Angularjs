<?php



require_once "config.php";

function __autoload($class_name) {
    //see if the file exsists

    $directory = DOCUMENT_ROOT . 'api/class/';

    if (file_exists($directory . $class_name . '.class.php')) {
        require_once $directory . $class_name . '.class.php';
        //$$class_name = new $class_name();
        //only require the class once, so quit after to save effort (if you got more, then name them something else

        return;
    }
}

require_once DOCUMENT_ROOT . 'api/modal/db.class.php';
//require_once DOCUMENT_ROOT . 'html/lang/en.php';
//$lang = new en();
$db = new db(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
//define the table name
$sql = "SELECT TABLE_NAME FROM information_schema.`TABLES` WHERE TABLE_TYPE LIKE 'BASE TABLE' AND TABLE_SCHEMA LIKE '" . DB_DATABASE . "'";
$results = $db->rawQuery($sql);
//print_r($results);
foreach ($results as $key => $val) {
    extract($val);
    $table_name = explode(DB_PREFIX, $TABLE_NAME);
    define(strtoupper('tbl_' . $table_name[1]), $TABLE_NAME);
    //echo $Tables_in_lds;
}
$menu = new menu();
$fn = new functions();
//print_r($_SESSION['user_data']);
//if (isset($_SESSION['user_data'])) {
////    $company_id = $_SESSION['user_data'][0]['company_id'];
//    $role_id = $_SESSION['user_data'][0]['role_id'];
//    $user_id = $role_id == 1 ? $_SESSION['user_data'][0]['user_id'] : $_SESSION['user_data'][0]['customer_id'];
//    $user_email = $_SESSION['user_data'][0]['email'];
//}

//print_r($fn->get_user_role(1));
?>
