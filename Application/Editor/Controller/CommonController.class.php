<?php
namespace Editor\Controller;
use Think\Controller;
class CommonController extends Controller {
	public function _initialize(){
		if(!$_SESSION['me']['id']){
			$this->error('登录失效',U('home/index/index'));
		}
	}
	public function father(){
		echo "father";
	}
}