<?php
namespace Admin\Controller;
use Think\Controller;
class StartController extends Controller {
	public function _initialize(){
		header("Content-type:text/html;charset=utf-8");
    }
    
    public function login(){
        $this->display();
    }
    public function handleLogin(){
        $email    = I('email');
        $password = I('password');
        if ($email && $password) {
            $where['email'] = $email;
            $where['password'] = md5($password);
            $user = D('admin_user')->where($where)->find();
            if ($user['status'] == 1)  {
                D('admin_user')->where($where)->save(array('last_login_time'=>time()));
                $_SESSION['admin']['me'] = $user;
                $this->redirect('/admin');
            }
        }
        $this->error('登录不正确', '/admin/start/login');
    }
}