<?php

namespace App\Controllers;

use \App\Libraries\Str;

class AddProductController extends BaseController
{
    public $db = null;

    public $forge = null;

    // List of errors
    public $assertionError = '';

    public function __construct() {
        $this->db    = \Config\Database::connect();
        $this->forge = \Config\Database::forge();
    }

    public function index()
    {
        $table = $this->request->getVar('sklad-select');
        $item  = $this->request->getVar('nov-artikul');
        $price = $this->request->getVar('nov-artikul-cena');
        $count = $this->request->getVar('nov-artikul-broika');
        $opisanie = $this->request->getVar('nov-artikul-opisanie');

        $dataArray = [
            'ime'      => $item,
            'cena'     => $price,
            'broika'   => $count,
            'opisanie' => $opisanie
        ];

        if($this->assertError($dataArray) && $this->db->tableExists($table)) {
            $this->update_table_data($dataArray, $table);
        } else {
            echo $this->assertionError;
        }
    }

    /*
     * Проверка за грешки 
     */
    public function assertError($data)
    {
        if(Str::is_empty($data['ime'])) {
            $this->assertionError = json_encode(['error' => 'Please enter a valid item!']);
            return false;
        }
        if(Str::is_empty($data['opisanie'])) {
            $this->assertionError = json_encode(['error' => 'Please provice a description!']);
            return false;
        }
        if(!is_numeric($data['cena'])) {
            $this->assertionError = json_encode(['error' => 'Please enter a valid price!']);
            return false;
        }
        if(intval($data['broika']) <= 0) {
            $this->assertionError = json_encode(['error' => 'Please enter a valid count!']);
            return false;
        }
        return true;
    }

    /*
     * Проверка дали $item го има на склада $table
     */
    public function has_item($item, $table)
    {
        $builder = $this->db->table($table);
        $builder->select('id');
        $builder->where('ime', $item);
        $result = $builder->get();
        if($result->getNumRows() == 1) {
            return true;
        }
        return false;
    }

    /*
     * Добавяне или промяна на артикул към склад $table
     */
    public function update_table_data($data, $table)
    {
        $item = $data['ime'];
        if(!$this->has_item($item, $table)) {
            if($this->add_item($data, $table) == 1) {
                echo json_encode(['success' => '['.Str::upper($item).'] added successfully!']);
            } else {
                echo json_encode(['error' => 'There was an error adding item ['.Str::upper($item).']!']);
            }
        } else {
            $this->update_item($data, $table);
            echo json_encode(['success' => 'Data for ['.Str::upper($item).'] updated successfully!']);
        }
    }

    /*
     * Добавяне на $item към склада $table
     */
    public function add_item($data, $table)
    {
        $builder = $this->db->table($table);
        $builder->insert($data);
        return $this->db->affectedRows();
    }

    /*
     * Update на данните за $item в склада $table
     */
    public function update_item($data, $table)
    {
        $item = $data['ime'];
        $data = [
            'cena'     => $data['cena'],
            'broika'   => $data['broika'],
            'opisanie' => $data['opisanie']
        ];
        $builder = $this->db->table($table);
        $builder->set($data);
        $builder->where('ime', $item);
        $builder->update();
    }
}