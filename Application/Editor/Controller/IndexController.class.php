<?php
namespace Editor\Controller;
use Editor\Controller;
class IndexController extends CommonController {
	public function _initialize(){
		parent::_initialize();
	}
    public function index(){
    	var_dump($_SESSION);
        echo "23";
        $this->assign('a','123');
        echo $_SESSION['me']['id'];
        $this->display('');
    }
}