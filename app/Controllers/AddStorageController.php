<?php

namespace App\Controllers;

use \App\Libraries\Str;

class AddStorageController extends BaseController
{
    public $forge = null;

    public $db = null;

    public $assertionMessage = [];

    public function __construct() {
        $this->forge = \Config\Database::forge();
        $this->db    = \Config\Database::connect();
    }
    
    /*
     * Създаване на нов склад
     */
    public function index()
    {
        $table = $this->request->getVar('nov-sklad');
        if(Str::is_empty($table)) {
            echo json_encode(['error' => 'Please enter a valid storage name!']);
            return;
        }
        if($this->db->tableExists($table)) {
            echo json_encode(['error' => 'Storage ['. $table .'] already exists!']);
            return;
        }
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'null' => false
            ],
            'ime' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'cena' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'broika' => [
                'type' => 'INT',
                'null' => false,
            ],
            'opisanie' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable($table);
        echo json_encode(['success' => 'Storage ['. $table .'] created successfully!']);
    }
}
