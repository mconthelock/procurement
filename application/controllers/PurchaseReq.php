<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PurchaseReq extends MY_Controller {
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->views('pr/create');
    }
}