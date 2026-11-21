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
}