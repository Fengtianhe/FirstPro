<?php
namespace Editor\Controller;
use Think\Controller;
class CommonController extends Controller {
	public function _initialize(){
		if(!$_SESSION['me']['id']){
			die('未登陆，或登陆失效');
		}
	}
	public function father(){
		echo "father";
	}
}