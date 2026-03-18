<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends MY_Controller {
    public function index() {
        $permission = $_GET['permission'] ?? 'EDIT';
        $this->views('Categories/index', [
            'title' => 'Category Management',
            'permission' =>  $permission
        ]);
    }

    public function create($permission='') {
        $this->views('Categories/detail', [
            'title' => 'Add New Category',
            'mode' => 'create',
            'permission' =>  $permission
        ]);
    }

    public function detail($id,$permission) {
        $this->views('Categories/detail', [
            'title' => 'Edit Category',
            'mode' => 'edit',
            'id' => $id,
            'permission' => $permission
        ]);
    }
}