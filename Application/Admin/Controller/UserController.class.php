<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends CommonController {
	public function _initialize(){
		header("Content-type:text/html;charset=utf-8");
    }
    public function lists(){
    	$date = date(m月d日,time());
    	$weekarray=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
    	$week = $weekarray[date(w,time())];
    	$dateweek = $date.'，'.$week ;
    	$userlist = M('user')->select();
    	$usercount = count($userlist);
    	$this->assign('usercount',$usercount);
    	$this->assign('userinfo',$userlist);
    	$this->assign('date',$dateweek);
    	$this->display();
    }
}