<?php
namespace Admin\Controller;
//use Think\Controller;
use Admin\Controller;
class IndexController extends CommonController {
	public function __construct(){
		parent::__construct();
		echo "construct";
	}
    function test(){
    	echo "123q";
    	echo $_SESSION['me']['id'];
    	$_SESSION['me']['id'] = '';
    }
}