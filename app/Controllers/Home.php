<?php

namespace App\Controllers;

use App\Libraries\TestLibrary;

class Home extends BaseController
{
    public $tl = null;

    public function __construct() {
        $this->tl = new TestLibrary();
    }

    public function index()
    {
        // PARSER
        /* $parser = \Config\Services::parser();
        $data   = [
            'page_title' => $this->request->uri->getSegment(1)
        ];
        return $parser->setData($data)->render('welcome_message'); */



        //echo view('welcome_message', $data);
        //echo view('product_view');



        // TABLES
        /* $table = new \CodeIgniter\View\Table();
        $data = [
            ['Name' , 'Color'],
            ['Jared', 'Red'],
            ['James', 'White']
        ];
        $records['users'] = $table->generate($data);
        echo view('welcome_message', $records); */


        //$db = \Config\Database::connect();
        //$query  = $db->query("select * from users");
        //$result = $query->getResult();
        //$records['users'] = $result;
        //echo view('welcome_message');
        $data = $this->tl->getData();
        echo "<pre>";
        print_r($data);
    }

    public function welcome($id)
    {
        echo "yes";
    }
}