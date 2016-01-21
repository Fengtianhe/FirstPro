<?php
namespace Admin\Controller;
//use Think\Controller;
use Admin\Controller;
class IndexController extends CommonController {
	// public function __construct(){
	// 	parent::__construct();
	// 	echo "construct";
	// }
	public function _initialize(){
		header("Content-type:text/html;charset=utf-8");
    }
    public function index(){
    	$url['xml_url'] = __ROOT__."/Public/admin/dwz.frag.xml";
    	$url['login'] = U('Admin/User/login');
    	$this->assign('url',$url);
    	$this->display();
    }
    public function main(){
    	$this->display();
    }

}