<?php
namespace Editor\Controller;
use Think\Controller;
class UserController extends Controller {

    public function login(){
    	$this->display();
    }

    public function handle_login(){
    	$email = I('post.email');
    	$password = I('post.password');
    	if($email && $password){
    		if($res = D('user')->where(array('email'=>$email,'password'=>md5($password)))->find()){
    			$_SESSION['me'] = $res;
    			$this->success('登陆成功',U('/editor/index/info'));
    		}else{
    			$this->error('登陆失败');
    		}
    	}else{
    		$this->success('请正确输入用户名、密码');
    	}
    }

    public function reg(){
    	$this->display();
    }

    public function handle_reg(){
        $_POST['password'] = md5($_POST['password']);
        $_POST['created'] = time();
    	D('user')->create();
    	$_POST['id'] = D('user')->add();
    	$_SESSION['me'] = $_POST;
    	$this->success('注册成功',U('/editor/index/info'));
    }

    public function logout(){
    	$_SESSION['me'] = '';
    }
}