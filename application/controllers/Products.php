<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Products extends MY_Controller {
    public function index() {
        $permission = $_GET['permission'] ?? 'EDIT';
        $this->views('Products/index', [
            'title' => 'Product Management',
            'permission' =>  $permission
        ]);
    }



    public function create($permission='') {
        
        $this->views('Products/detail', [
            'title' => 'Add New Product',
            'mode' => 'create',
            'permission' => $permission
        ]);
    }

    public function detail($id,$permission) {
        $this->views('Products/detail', [
            'title' => 'Edit Product',
            'mode' => 'edit',
            'id' => $id,
            'permission' => $permission
        ]);
    }

    
}