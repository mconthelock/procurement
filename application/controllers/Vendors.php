<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendors extends MY_Controller {
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->views('vendors/index');
    }

    public function detail($id = ''){
        $this->views('vendors/detail', [
            'id' => $id
        ]);
    }
}