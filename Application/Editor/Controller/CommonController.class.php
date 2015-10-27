<?php
namespace Editor\Controller;
use Think\Controller;
class CommonController extends Controller {
	public function _initialize(){
		if(!$_SESSION['me']['id']){
			$this->error('请重新登录',U('editor/user/login'));
		}
	}
	public function father(){
		echo "father";
	}
}