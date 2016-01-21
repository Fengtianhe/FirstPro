<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
	// public function __construct(){
	// 	if(!$_SESSION['me']['id']){
	// 		die('未登陆，或登陆失效');
	// 	}
	// }
	public function _initialize(){
		header("Content-type:text/html;charset=utf-8");
    }
}