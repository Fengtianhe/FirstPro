<?php
namespace Editor\Controller;
use Think\Controller;
class UserController extends Controller {
    //判断是否登录
    private function  is_login(){
        header("Content-type: text/html; charset=utf-8"); 
        if(!isset($_SESSION['dami_uid']) && $_SESSION['dami_uid'] == ''){
            $lasturl = urlencode(htmlspecialchars('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));
            $this->assign('jumpUrl',__ROOT__.'/index.php?m=user&a=login&lasturl='.$lasturl);
            $this->success('未登陆或登陆超时，请重新登陆,页面跳转中~');        
        }
    }

    //邮箱手机验证
    private function is_verify($pattern){
        $phone_match="/13\d{9}|15\d{9}|17\d{9}|18\d{9}/";
        $email_match="/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
        if (preg_match($email_match,$pattern) || preg_match($phone_match,$pattern)) {
            return 1;    
        }
        else{
            return 0;
        }
    }
    //用户注册界面
    public function handle_reg(){
        $data = $_POST;
        $_POST['password'] = md5($_POST['password']);
        $data[password]=$_POST['password'];
        $e=$this->is_verify($data['email']);
        $p=$this->is_verify($data['phone']);
        if (!$e) {
            $this->error("邮箱格式错误");
        }
        elseif (!$p) {
            $this->error("手机格式错误");
        }
        else{
            die();
            $_POST['created'] = time();
            D('user')->create();
            $_POST['id'] = D('user')->add();
            $_SESSION['me'] = $_POST;
            $this->success('注册成功',U('/editor/index/info'));
        }
        
    }

    //以上为已编辑函数
    ////////////////////////////////////////////////////////////////////////////////////////////
    /***************************************华丽的分割线***************************************/
    ////////////////////////////////////////////////////////////////////////////////////////////


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
    

    public function logout(){
    	$_SESSION['me'] = '';
    }
}