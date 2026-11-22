<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendors extends MY_Controller {
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->breadcrumb->add('Vendor Directory');
        $this->views('vendors/index', ['title' => 'nav-vendors']);
    }

    public function list(){
        $this->breadcrumb->add('Vendor List (Indirect & Subcontractor)');
        $this->views('vendors/list', ['title' => 'nav-vendors-list']);
    }

    public function detail($id = ''){
        $this->breadcrumb->add('Vendor Directory', base_url('vendors'));
        $this->breadcrumb->add('Vendor Detail');
        $this->views('vendors/detail', [
            'id' => $id,
            'title' => 'nav-vendors'
        ]);
    }

    //Vendors Users
    public function users(){
        $this->breadcrumb->add('Vendor Directory', base_url('vendors'));
        $this->breadcrumb->add('Vendor Users');
        $this->views('vendors/users', [
            'title' => 'nav-vendors-users'
        ]);
    }
}