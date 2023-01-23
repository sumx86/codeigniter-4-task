<?php

namespace App\Libraries;

class TestLibrary {

    public $db = null;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

    public function getData() {
        return $this->db->query("Select username from users")->getResultArray();
    }
}
?>