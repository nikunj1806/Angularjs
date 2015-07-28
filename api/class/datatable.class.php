<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/inventory-bk/html/includes/config.php';

//require_once $_SERVER['DOCUMENT_ROOT'] . '/html/class/db.class.php';
require_once 'ssp.class.php';

require_once 'ssp2.class.php';

class datatable {

    protected $_db;
    protected $_sql_details = array(
        'user' => DB_USERNAME,
        'pass' => DB_PASSWORD,
        'db' => DB_DATABASE,
        'host' => DB_SERVER
    );

    public function __construct() {
        $this->_db = db::getInstance();
    }

    public function getCategory() {
        $table = 'inv_category';
        $primaryKey = 'id';
        $columns = array(
            array('db' => 'name', 'dt' => 0, 'field' => 'category_name', 'searchable' => 'name'),
            array('db' => 'description', 'dt' => 1, 'field' => 'description', 'searchable' => 'description'),
            array('db' => 'id', 'dt' => 2, 'field' => 'action', 'formatter' => function( $d, $row ) {
            return '<a href="category/edit/' . $d . '" class="btn btn-xs show-tooltip" title="" data-original-title="Edit"><span class="fa fa-edit"></span></a>';
        })
        );
        $sql = 'SELECT * FROM inv_category $where $order $limit';
        echo json_encode(
                SSP2::simple($_REQUEST, $this->_sql_details, $table, $primaryKey, $columns, $sql)
        );
    }

    public function getTransfer() {
        $table = 'inv_transfer';
        $primaryKey = 'id';
        $columns = array(
            array('db' => 'st_number', 'dt' => 0, 'field' => 'st_number', 'searchable' => 'st_number', 'formatter' => function( $d, $row ) {
            return '<a href="stock_transfer/edit/' . $row['id'] . '" style="color:blue;">' . $d . '</a>';
        }),
            array('db' => 'date', 'dt' => 1, 'field' => 'date', 'searchable' => 'date',)
        );
        $sql = 'SELECT * FROM inv_transfer $where $order $limit';
        echo json_encode(
                SSP2::simple($_REQUEST, $this->_sql_details, $table, $primaryKey, $columns, $sql)
        );
    }

    public function getContact($type = "") {

        if (isset($type) && $type != "") {
            $extraWhere = 'type =' . $type;
        } else {
            $extraWhere = '';
        }
        $table = 'inv_contact';
        $primaryKey = 'id';
        $columns = array(
            array('db' => 'name', 'dt' => 0, 'field' => 'name', 'searchable' => 'name'),
            array('db' => 'type', 'dt' => 1, 'field' => 'type', 'formatter' => function( $d, $row ) {
            $a = $d == 1 ? 'Client' : 'Supplier';
            return $a;
        }),
            array('db' => 'phone', 'dt' => 2, 'field' => 'phone', 'searchable' => 'phone'),
            array('db' => 'email', 'dt' => 3, 'field' => 'email', 'searchable' => 'email'),
            array('db' => 'country', 'dt' => 4, 'field' => 'country', 'searchable' => 'country'),
            array('db' => 'id', 'dt' => 5, 'field' => 'action', 'formatter' => function( $d, $row ) {
            return '<a href="contact/edit/' . $d . '" class="btn btn-xs show-tooltip" title="" data-original-title="Edit"><span class="fa fa-edit"></span></a>';
        })
        );
        $joinQuery = 'SELECT * FROM inv_contact $where $order $limit';
        echo json_encode(
                SSP2::simple($_REQUEST, $this->_sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
        );
    }

    public function getShipment($type = "") {
        $table = 'inv_shipment';
        $primaryKey = 'id';
        $columns = array(
            array('db' => 'id', 'dt' => 0, 'field' => 'sh_number', 'searchable' => 'id'),
            array('db' => 'created_date', 'dt' => 1, 'field' => 'date', 'searchable' => 'created_date'),
            array('db' => 'delivery_date', 'dt' => 2, 'field' => 'delivery_date', 'searchable' => 'delivery_date'),
            array('db' => 'contact', 'dt' => 3, 'field' => 'contact', 'searchable' => 'contact'),
            array('db' => 'client_reference', 'dt' => 4, 'field' => 'client_reference', 'searchable' => 'client_reference'),
            array('db' => 'status', 'dt' => 5, 'field' => 'action', 'formatter' => function( $d, $row ) {
            if ($d == 1) {
                return 'Pending';
            } else {
                return 'Completed';
            };
        })
        );

        $sql = "SELECT * FROM inv_shipment";
        echo json_encode(
                SSP2::simple($_REQUEST, $this->_sql_details, $table, $primaryKey, $columns, $sql)
        );
    }

    public function getInventory() {

        $table = 'inv_item';
        $primaryKey = 'id';
        $columns = array(
            array('db' => 'item_code', 'dt' => 0, 'field' => 'item_code', 'searchable' => 'item.item_code'),
            array('db' => 'item_name', 'dt' => 1, 'field' => 'item_name', 'searchable' => 'item.item_name'),
            array('db' => 'size', 'dt' => 2, 'field' => 'size', 'searchable' => 'item.size'),
            array('db' => 'category', 'dt' => 3, 'field' => 'category', 'searchable' => 'cat.name'),
            array('db' => 'on_order', 'dt' => 4, 'field' => 'on_order', 'searchable' => 'item.on_order'),
            array('db' => 'in_stock_ar', 'dt' => 5, 'field' => 'in_stock_ar', 'searchable' => 'item.in_stock_ar'),
            array('db' => 'in_stock_pd', 'dt' => 6, 'field' => 'in_stock_pd', 'searchable' => 'item.in_stock_pd'),
            array('db' => 'total_in_stock', 'dt' => 7, 'field' => 'total_in_stock', 'searchable' => 'item.total_in_stock'),
            array('db' => 'item_code', 'dt' => 8, 'field' => 'pending', 'formatter' => function( $d, $row ) {
            if ($row['on_order'] > $row['total_in_stock']) {
                return $row['on_order'] - $row['total_in_stock'];
            }else{
                return '-';
            }
        }),
            array('db' => 'item_code', 'dt' => 9, 'field' => 'over_stock', 'formatter' => function( $d, $row ) {
            if ($row['on_order'] > $row['total_in_stock']) {
                return '-';
            }else{
                return $row['total_in_stock']-$row['on_order'];
            }
        })
        );

        $joinQuery = 'SELECT item.item_code,item.on_order,item.in_stock_ar,item.in_stock_pd, item.total_in_stock ,item.item_name ,item.size,cat.name as category FROM inv_item as item JOIN inv_category as cat ON item.category = cat.id $where $order $limit';

        echo json_encode(
                SSP2::simple($_REQUEST, $this->_sql_details, $table, $primaryKey, $columns, $joinQuery)
        );
    }

    public function getItem() {
        $table = 'inv_item';
        $primaryKey = 'id';
        $columns = array(
            array('db' => 'item_code', 'dt' => 0, 'field' => 'item_code', 'searchable' => 'item.item_code'),
            array('db' => 'item_name', 'dt' => 1, 'field' => 'item_name', 'searchable' => 'item.item_name'),
            array('db' => 'size', 'dt' => 2, 'field' => 'size', 'searchable' => 'item.size'),
            array('db' => 'category', 'dt' => 3, 'field' => 'category', 'searchable' => 'cat.name'),
            array('db' => 'id', 'dt' => 4, 'field' => 'action', 'formatter' => function( $d, $row ) {
            return '<a href="item_master/edit/' . $d . '" class="btn btn-xs show-tooltip" title="" data-original-title="Edit"><span class="fa fa-edit"></span></a>';
        })
        );
        $joinQuery = 'SELECT item.id,item.item_code ,item.item_name ,item.size,cat.name as category FROM inv_item as item JOIN inv_category as cat ON item.category = cat.id $where $order $limit';

        echo json_encode(
                SSP2::simple($_REQUEST, $this->_sql_details, $table, $primaryKey, $columns, $joinQuery)
        );
    }

    public function getOrder($type = "") {
        if (isset($type) && $type != "") {
            $extraWhere = 'o.status =' . $type;
        } else {
            $extraWhere = '';
        }

        $table = 'inv_order';
        $primaryKey = 'id';
        $columns = array(
            array('db' => 'order_number', 'dt' => 0, 'field' => 'order_number', 'searchable' => 'o.order_number', 'formatter' => function( $d, $row ) {
            return '<a href="order/view/' . $row['id'] . '" style="color:blue;">' . $d . ' </a>';
        }),
            array('db' => 'date', 'dt' => 1, 'field' => 'date', 'searchable' => 'o.date'),
            array('db' => 'delivery_date', 'dt' => 2, 'field' => 'delivery_date', 'searchable' => 'o.delivery_date'),
            array('db' => 'contact', 'dt' => 3, 'field' => 'contact', 'searchable' => 'c.name'),
            array('db' => 'client_reference', 'dt' => 4, 'field' => 'client_reference', 'searchable' => 'o.client_reference'),
            array('db' => 'status', 'dt' => 5, 'field' => 'action', 'formatter' => function( $d, $row ) {
            if ($d == '0') {
                return 'Pending';
            } else {
                return 'Completed';
            };
        })
        );
        $joinQuery = 'SELECT o.id,o.order_number ,o.date ,o.delivery_date,o.client_reference,o.status,c.name as contact FROM inv_order as o JOIN inv_contact as c ON o.contact = c.id $where $order $limit';
        //echo json_encode($_REQUEST);
        echo json_encode(
                SSP2::simple($_REQUEST, $this->_sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
        );
    }

    public function getValuation($type = "") {
        $extraWhere = (isset($type) && $type != "") ? 'cat.id = ' . $type : '';
        $table = 'inv_item';
        $primaryKey = 'id';
        $columns = array(
            array('db' => 'item_code', 'dt' => 0, 'field' => 'item_code', 'searchable' => 'item.item_code', 'formatter' => function( $d, $row ) {
            return '<a href="item_master/edit/' . $row['id'] . '" style="color:blue;">' . $d . ' </a>';
        }),
            array('db' => 'item_name', 'dt' => 1, 'field' => 'item_name', 'searchable' => 'item.item_name'),
            array('db' => 'size', 'dt' => 2, 'field' => 'size', 'searchable' => 'item.size'),
            array('db' => 'category', 'dt' => 3, 'field' => 'category', 'searchable' => 'cat.name'),
            array('db' => 'total_in_stock', 'dt' => 4, 'field' => 'total_in_stock', 'searchable' => 'item.total_in_stock'),
            array('db' => 'cost_per_unit', 'dt' => 5, 'field' => 'cost_per_unit', 'searchable' => 'item.cost_per_unit'),
            array('db' => 'id', 'dt' => 6, 'field' => 'total', 'formatter' => function( $d, $row ) {
            return '$' . $row['total_in_stock'] * $row['cost_per_unit'];
        }),
        );
        $joinQuery = 'SELECT item.id,item.item_code,item.total_in_stock,item.cost_per_unit, item.item_name,item.size,cat.id as cat_id,cat.name as category FROM inv_item as item JOIN inv_category as cat ON item.category = cat.id $where $order $limit';

        echo json_encode(
                SSP2::simple($_REQUEST, $this->_sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
        );
    }

    public function getBatch($type = "") {
        $extraWhere = (isset($type) && $type != "") ? 'cat.id = ' . $type : '';
        $table = 'inv_receive';
        $primaryKey = 'id';
        $columns = array(
            array('db' => 'batch_number', 'dt' => 0, 'field' => 'batch_number', 'searchable' => 'r.batch_number', 'formatter' => function( $d, $row ) {
            return '<a href="inventory_batch/view/' . $row['id'] . '" style="color:blue;">' . $d . ' </a>';
        }),
            array('db' => 'date', 'dt' => 1, 'field' => 'date', 'searchable' => 'r.date'),
            array('db' => 'contact', 'dt' => 2, 'field' => 'contact_id', 'searchable' => 'c.name'),
            array('db' => 'supplier_reference', 'dt' => 3, 'field' => 'supplier_reference', 'searchable' => 'r.supplier_reference')
        );
        $joinQuery = 'SELECT r.id, r.batch_number, r.date, c.name as contact, r.supplier_reference  FROM inv_receive as r JOIN inv_contact as c ON c.id = r.contact_id $where $order $limit';

        echo json_encode(
                SSP2::simple($_REQUEST, $this->_sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
        );
    }

}
