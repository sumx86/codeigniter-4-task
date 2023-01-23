<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Data extends BaseController
{
    public function index()
    {
        $userModel = new UsersModel();
        $records['users'] = $userModel->getData();
        echo view('welcome_message', $records);
    }
}