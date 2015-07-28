<?php

//header('Content-Type: text/html; charset=utf-8');
require_once '../html/includes/include.php';

$item = new item();
$category = new category();


if (array_key_exists('_wysihtml5_mode', $_POST)) {
    unset($_POST['_wysihtml5_mode']);
}

$item_data = $item->getItemByid($_POST['item']);

$category_data = $category->getCategoryByid($item_data['category']);
$a['item_name'] = $item_data['item_name'];
$a['item_code'] = $item_data['item_code'];
$a['size'] = $item_data['size'];
$a['on_order'] = $item_data['on_order'];
$a['total_stock'] = $item_data['total_in_stock'];
$a['in_stock_ar'] = $item_data['in_stock_ar'];
$a['in_stock_pd'] = $item_data['in_stock_pd'];
$a['category'] = $category_data;
//print_r($item_data);
//$return = array('msg'=>$msg,'type'=>$msg_type,'data'=>$item_data);
    



echo json_encode($a);
?>