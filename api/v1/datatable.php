<?php

//header('Content-Type: text/html; charset=utf-8');
require_once '../html/includes/include.php';
$datatable = new datatable();
$method = $_REQUEST['method'];
//if ((isset($_REQUEST['filter']) && $_REQUEST['filter'] != '') && (isset($_REQUEST['search_filter']) && $_REQUEST['search_filter'] != '')) {
//    return $datatable->{$method}($_REQUEST['filter'], $_REQUEST['search_filter']);
//} else if (isset($_REQUEST['filter']) && $_REQUEST['filter'] != '') {
//    return $datatable->{$method}($_REQUEST['filter'], '');
//} else if (isset($_REQUEST['search_filter']) && $_REQUEST['search_filter'] != '') {
//    return $datatable->{$method}('', $_REQUEST['search_filter']);
//} else {
//    return $datatable->{$method}();
//}
if (isset($_REQUEST['filter']) && $_REQUEST['filter'] != '') {
    return $datatable->{$method}($_REQUEST['filter']);
} else {
    return $datatable->{$method}();
}

?>