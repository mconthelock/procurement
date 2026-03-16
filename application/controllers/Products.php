<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Products extends MY_Controller {
    public function index() {
        $this->views('Products/index', [
            'title' => 'Product Management'
        ]);
    }

    public function create() {
        $this->views('Products/detail', [
            'title' => 'Add New Product',
            'mode' => 'create'
        ]);
    }

    public function detail($id) {
        $this->views('Products/detail', [
            'title' => 'Edit Product',
            'mode' => 'edit',
            'id' => $id
        ]);
    }

    
}