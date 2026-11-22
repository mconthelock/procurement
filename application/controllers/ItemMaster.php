<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ItemMaster extends MY_Controller {
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->breadcrumb->add('Item Master Catalog');
        $this->views('ItemMaster/index', ['title' => 'item-master']);
    }

    public function detail($id = ''){
        $this->breadcrumb->add('Item Master Catalog', base_url('ItemMaster'));
        $this->breadcrumb->add('Item Detail');
        $this->views('ItemMaster/detail', [
            'id' => urldecode($id),
            'title' => 'item-master'
        ]);
    }
}
