<?php

namespace App\Controllers;

class Products extends BaseController
{
    public function index()
    {
        
    }

    public function order()
    {
        echo view('order_products_page');
    }

    public function add()
    {
        echo view('add_products_page');
    }
}