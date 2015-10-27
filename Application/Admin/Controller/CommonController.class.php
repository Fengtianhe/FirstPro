<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
	public function __construct(){
		if(!$_SESSION['me']['id']){
			die('未登陆，或登陆失效');
		}
	}
}