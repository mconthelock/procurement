<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends MY_Controller {
    public function index() {
        $this->views('Categories/index', [
            'title' => 'Category Management'
        ]);
    }

    public function create() {
        $this->views('Categories/detail', [
            'title' => 'Add New Category',
            'mode' => 'create'
        ]);
    }

    public function detail($id) {
        $this->views('Categories/detail', [
            'title' => 'Edit Category',
            'mode' => 'edit',
            'id' => $id
        ]);
    }
}