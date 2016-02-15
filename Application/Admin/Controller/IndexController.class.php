<?php
namespace Admin\Controller;
//use Think\Controller;
use Admin\Controller;
class IndexController extends CommonController {
	public function _initialize(){
        parent::_initialize();
    }
    public function index(){
    	$url['xml_url'] = __ROOT__."/Public/admin/dwz.frag.xml";
    	$url['login'] = U('Admin/admin/login');
    	$this->assign('url',$url);
    	$this->display();
    }
    public function main(){
    	$this->display();
    }

}