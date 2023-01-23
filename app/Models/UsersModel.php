<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model {

    public function getData()
    {
        $db = \Config\Database::connect();
        return $db->query("select * from users")->getResult();
    }
}

?>