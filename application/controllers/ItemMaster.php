<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ItemMaster extends MY_Controller {
    function __construct(){
		parent::__construct();
    }

    public function index(){
       $this->views('ItemMaster/index', ['title' => 'item-master']);
    }
}