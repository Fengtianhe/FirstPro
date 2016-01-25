<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends CommonController {
	public function _initialize(){
		header("Content-type:text/html;charset=utf-8");
    }
    public function lists(){
    	$userlist = M('user')->select();
    	$usercount = count($userlist);
    	$this->assign('usercount',$usercount);
    	$this->assign('userinfo',$userlist);
    	$this->assign('date',$dateweek);
    	$this->display();
    }
}