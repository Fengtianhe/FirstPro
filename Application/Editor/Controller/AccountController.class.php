<?php
namespace Editor\Controller;
use Think\Controller;
class AccountController extends CommonController{

	public function _initialize(){
        parent::_initialize();
    }
    
	public function index(){
		$this->display();
	}


}
?>