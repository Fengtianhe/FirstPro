<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
	public function _initialize(){
		header("Content-type:text/html;charset=utf-8");
		if(!$_SESSION['admin']['me']['id']){
			$this->error('未登陆，或登陆失效', '/admin/admin/login');
		}
	}
}