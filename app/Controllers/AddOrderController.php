<?php

namespace App\Controllers;

use \App\Libraries\Str;
use CodeIgniter\Cookie\Cookie;
use Config\Services;

class AddOrderController extends BaseController
{
    public $db = null;

    public $assertionMessage = [];

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $table = $this->request->getVar('sklad');
        $item  = $this->request->getVar('artikul');
        $count = intval($this->request->getVar('broika'));
        $itemData = $this->get_item($item, $table);
        
        if(!empty($itemData)) {
            if($count <= 0) {
                echo json_encode(['error' => [
                    'sklad'   => $table,
                    'message' => 'Please choose a valid order count!'
                ]]);
                return;
            }
            if($itemData[0]->broika <= 0) {
                echo json_encode(['error' => [
                    'sklad'   => $table,
                    'message' => 'Item [' . $item . '] is out of stock!'
                ]]);
                return;
            }
            if($count > $itemData[0]->broika) {
                echo json_encode(['error' => [
                    'sklad'   => $table,
                    'message' => 'The available count for this product is ' . $itemData[0]->broika . '!'
                ]]);
                return;
            }

            // $newCount = intval($itemData[0]->broika) - $count;
            // $this->update_item_count($item, $table, $newCount);

            echo json_encode(['order' => [
                'sklad'  => $table,
                'ime'    => $item,
                'cena'   => $this->calculate_price($itemData[0]->cena, $count),
                'broika' => $count
            ]]);
        }
    }

    /*
     * Проверка дали $item го има на склад
     */
    public function get_item($item, $table)
    {
        $builder = $this->db->table($table);
        $builder->select('*');
        $builder->where('ime', $item);
        $result = $builder->get();
        if($result->getNumRows() == 1) {
            return $result->getResult();
        }
        return [];
    }

    /*
     * Update на бройката на артикула
     */
    public function update_item_count($item, $table, $count)
    {
        $builder = $this->db->table($table);
        $builder->set('broika', $count);
        $builder->where('ime', $item);
        $builder->update();
    }

    public function calculate_price($price, $count)
    {
        return number_format((float) $price * $count, 2, '.', '');
    }
}