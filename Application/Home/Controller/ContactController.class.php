<?php
namespace Home\Controller;
use Think\Controller;
class ContactController extends CommonController {
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

    /**
     * 发送邮件 demo
     */
    public function sendMail()
    {
        $email = I('get.email');
        $status = D('Common/Mail')->sendUserRegistVerifyMail(array('email'=>$email));
        var_dump($status);
    }

}