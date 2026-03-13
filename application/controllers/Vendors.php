<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendors extends MY_Controller {
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->views('Vendors/index');
    }

    public function detail($id = ''){
        $this->views('Vendors/detail', [
            'id' => $id
        ]);
    }
    public function create()
{
     $this->views('Vendors/create', [
        'title' => 'Create New Vendor'
    ]); 
}
}