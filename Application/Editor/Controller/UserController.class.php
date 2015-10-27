<?php
namespace Editor\Controller;
use Think\Controller;
class UserController extends Controller {

    public function login(){
    	$this->display();
    }

    public function handle_login(){
    	//var_dump($_POST);
    	$username = I('post.username');
    	$password = I('post.password');
    	if($username && $password){
    		if($res = D('user')->where(array('username'=>$username,'password'=>md5($password)))->find()){
    			$_SESSION['me'] = $res;
    			$this->success('登陆成功');
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
    	D('user')->create();
    	$_POST['id'] = D('user')->add();
    	$_SESSION['me'] = $_POST;
    	$this->success('注册成功','/editor/index/index');
    }

    public function logout(){
    	$_SESSION['me'] = '';
    }
}