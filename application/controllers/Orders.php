<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends MY_Controller {
    public function __construct(){
        parent::__construct();
    }

	public function index(){
        $this->breadcrumb->add('Purchase Orders');
        $this->views('po/index', ['title' => 'nav-orders']);
    }

    public function detail($id = ''){
        $this->breadcrumb->add('Purchase Orders', base_url('orders'));
        $this->breadcrumb->add('Purchase Order Detail');
        $this->views('po/detail', [
            'id' => $id,
            'title' => 'nav-orders'
        ]);
    }

    public function report(){
        $this->breadcrumb->add('Purchase Orders', base_url('orders'));
        $this->breadcrumb->add('Search Report');
        $this->views('po/report', ['title' => 'nav-orders']);
    }
}