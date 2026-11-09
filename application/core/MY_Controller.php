<?php

defined('BASEPATH') OR exit('No direct script access allowed');
    use duncan3dc\Laravel\BladeInstance;
    class MY_Controller extends CI_Controller {

    protected $views = APPPATH . 'views';
    protected $cache = APPPATH . 'cache';
    protected $blade;
    protected $callback;

    public function __construct(){
        parent::__construct();
        $this->blade = new BladeInstance($this->views, $this->cache);
        $this->callback = $_ENV['APP_HOST'].'/form/authen/index/'.$_ENV['APP_ID'].'/';
        $GLOBALS['version'] = $_ENV['STATE'] == 'production' ? $_ENV['VERSION'] :  time();
    }

    public function views($view_name, $data = array()){
        echo $this->blade->render($view_name, $data);
    }

    public function session_expire(){
        if(!isset($_SESSION['user'])){
            if ($this->isAjaxRequest()) {
                echo json_encode(['status' => '403', 'url' => $this->callback]);
                exit;
            } else {
                redirect($this->callback);
                session_write_close();
                exit;
            }
        }
    }

    public function isAjaxRequest() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    protected function _var_dump($data){
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }

    protected function _print_r($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

}