<?php
namespace Home\Controller;
use Think\Controller;
class ContactController extends Controller {
    public function index()
    {
       
    	$this->display();
    }

    public function insert()
    {
    	$_POST['create_time'] = time();
    	$_SESSION['me']['id'] && $_POST['user_id'] = $_SESSION['me']['id'];
    	M('Contact')->create();
    	M('Contact')->add();
    	$this->success('发送成功');
    }

}