<?php
//header('Content-Type: text/html; charset=utf-8');
require_once '../html/includes/include.php';
extract($_POST);
if (array_key_exists('_wysihtml5_mode', $_POST)) {
    unset($_POST['_wysihtml5_mode']);
}
$item = new item();
$item_data = $item->getItemByid($item_id);
$category = new category();
$category_data = $category->getCategoryByid($item_data['category']);
?>
<tr class="item_list" id="item<?php echo $item_data['id']; ?>">
<td><input type="text" name="item_code[]"  class="form-control item_code" value="<?php echo $item_data['item_code'] ?>" readonly></td>
<td><input type="text" name="item_name[]"  class="form-control item_name" value="<?php echo $item_data['item_name'] ?>" readonly></td>
<td><input type="text" name="size[]"  class="form-control size" value="<?php echo $item_data['size'] ?>" readonly><input type="hidden" name="item_id[]" value="<?php echo $item_data['id'] ?>"  class="form-control item_id" readonly></td>
<td><input type="text" name="canc" value="<?php echo $category_data['name'] ?>" class="form-control" readonly><input type="hidden" name="category[]" value="<?php echo $item_data['category'] ?>" class="form-control" readonly></td>
<td><input type="text" name="quantity[]" value="<?php echo $quantity ?>"  class="form-control quantity" readonly></td>
<td><input type="text" name="date[]" value="<?php echo date('Y-m-d'); ?>"  class="form-control date" readonly>
<input type="hidden" name="in_stock_ar[]" value="<?php echo $item_data['in_stock_ar']; ?>"  class="form-control" readonly>
<input type="hidden" name="in_stock_pd[]" value="<?php echo $item_data['in_stock_pd']; ?>"  class="form-control" readonly>
<input type="hidden" name="total_stock[]" value="<?php echo $item_data['total_in_stock']; ?>"  class="form-control" readonly>
</td>
<td><button type="button" value="" class="form-control" onclick="remove_item2(this)"><span class="fa fa-trash-o"></span></button></td>
                                                                            

</tr>


