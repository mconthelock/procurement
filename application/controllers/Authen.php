<?php
use GuzzleHttp\Client;
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/api/direclogin.php';
class Authen extends MY_Controller {
    use direclogin;
    function __construct(){
        parent::__construct();
        $this->client = new Client(['verify' => false]);
    }

    public function move(){
        $this->views('layout/move');
    }

    public function directlogin($empMd5){
        try {
            $auth = $this->direclogin(strtoupper($empMd5));
            $group = $auth['appgroup'];
            $info = $auth['appuser'];
            $menu = $auth['auth'];
            $submenu = array_merge(...array_map(function($m) {
                return isset($m['submenu']) && count($m['submenu']) > 0 ? $m['submenu'] : [];
            }, $menu));
            $_SESSION['user']  = (object)$info;
            $_SESSION['GROUP'] = (object)$group;
            $_SESSION['menu'] = $menu;
            $this->setMenu('menuitem', $menu);
            $this->setMenu('submenuitem', $submenu);
            $_SESSION['profile-img'] = $info['image'];
            if($_SESSION['GROUP'] != null && $_SESSION['GROUP']->GROUP_HOME != null){
                $redir = $_SESSION['GROUP']->GROUP_HOME;
            }else{
                $redir = 'welcome';
            }
            redirect($_ENV['APP_ENV'].'/'.$redir);
         } catch (Exception $e) {
            show_error($e->getMessage());
        }
    }

    public function setSession(){
        $_SESSION['user']  = (object)$_POST['info'];
        $_SESSION['GROUP'] = (object)$_POST['group'];
        $_SESSION['menu'] = $_POST['menu'];
        $this->setMenu('menuitem', $_POST['mainmenu']);
		$this->setMenu('submenuitem', $_POST['submenu']);
		$_SESSION['profile-img'] = $_POST['info']['image'];
        if($_SESSION['GROUP'] != null && $_SESSION['GROUP']->GROUP_HOME != null){
            $redir = $_SESSION['GROUP']->GROUP_HOME;
        }else{
            $redir = 'welcome';
        }
        // $this->_var_dump($_SESSION);
        echo json_encode(['url' => $redir]);
    }

     public function logout(){
        unset($_SESSION['user']);
        unset($_SESSION['GROUP']);
        unset($_SESSION['menu']);
        unset($_SESSION['profile-img']);
        unset($_SESSION['menuitem']);
		unset($_SESSION['submenuitem']);
        setcookie($_ENV['APP_NAME'], "", time() - 3600, "/");
        setcookie('dailyids', "", time() - 3600, "/");
		redirect($_ENV['APP_HOST'].'/form/authen/index/'.$_ENV['APP_ID']);
    }

    public function goOut($url = 'https://portal.mitsubishielevatorasia.co.th/sites/GP/ST/Pages/default.aspx'){
        redirect($url);
    }

    private function setMenu($type, $menu) {
        $_SESSION[$type] = [];
        $i = isset($_SESSION[$type]) ? count($_SESSION[$type]) : 0;
		foreach ($menu as $value) {
            $value = (object)$value;
			$_SESSION[$type][$i] = array(
				'menu_id'			=> $value->menu_id,
				'menu_name'			=> $value->menu_name,
                'menu_class'		=> $value->menu_class,
                'menu_top'		    => $value->menu_top,
				'menu_link'			=> $value->menu_link
			);
			$i++;
        }
    }


}