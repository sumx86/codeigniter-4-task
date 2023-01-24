<?php

namespace App\Controllers;

use \App\Libraries\Str;

class MakeOrderController extends BaseController
{
    public $db = null;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = $this->request->getJSON();
        $totalPrice = number_format((float) $data->total_price, 2, '.', '');

        foreach($data as $key => $value) {
            if($key != 'total_price') {
                // името на склада
                $table = $key;
                // всички поръчки за склада [масив]
                $orders = $value;

                if($this->process_order($table, $orders)) {
                    echo json_encode(['success' => 'Orders for ['. Str::upper($table) .'] processed successfully!']);
                }
            }
        }
    }

    /*
     * Проверяване и вкарване на всяка една поръчка от склада $table в pending_orders
     */
    public function process_order($table, $ordersArray)
    {
        foreach($ordersArray as $order) {
            if(intval($order->broika) > 0 && number_format((float) $order->cena, 2, '.', '') > 0.00) {
                $order->sklad = $table;
                if($this->add_pending_order($order) != 1) {
                    echo json_encode(['error' => 'There was an error processing order [' . $order->ime . ']']);
                    return false;
                }
                $this->update_item_count($order, $table);
            }
        } return true;
    }

    /*
     * Update на бройката на артикула $data->ime в склада $table
     */
    public function update_item_count($data, $table)
    {
        $builder = $this->db->table($table);
        $builder->set('broika', intval($this->get_item_count($data->ime, $table)) - intval($data->broika));
        $builder->where('ime', $data->ime);
        $builder->update();
    }
 
    /*
     * Извличане на бройката за артикул $item от склада $table
     */
    public function get_item_count($item, $table)
    {
        $builder = $this->db->table($table);
        $builder->select('broika');
        $builder->where('ime', $item);
        $result = $builder->get();
        if($result->getNumRows() == 1) {
            return $result->getResult()[0]->broika;
        }
    }

    public function add_pending_order($order)
    {
        $builder = $this->db->table('pending_orders');
        $builder->insert($order);
        return $this->db->affectedRows();
    }
}