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

    //用户注册方法
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
            $data['created'] = time();
            M('user')->add($data);
            $_SESSION['me'] = $data;
            $this->success('注册成功',U('/editor/index/info'));
        }
        
    }

    //注册页面
    public function reg(){
        $this->display();
    }

    //登录页面
    public function login(){
        $this->display();
    }

    //邮箱登陆
    public function handle_email_login(){
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

    //手机登陆
    public function handle_phone_login(){
        $phone = I('post.phone');
        $password = I('post.password');
        if($phone && $password){
            if($res = D('user')->where(array('phone'=>$phone,'password'=>md5($password)))->find()){
                $_SESSION['me'] = $res;
                $this->success('登陆成功',U('/editor/index/info'));
            }else{
                $this->error('登陆失败');
            }
        }else{
            $this->success('请正确输入用户名、密码');
        }
    }

    //用户个人中心页面
    public function center(){
        $this->display();
    }

    //用户发表列表
    public function myList(){
        //var_dump($_SESSION);
        $id=$_SESSION['me']['id'];
        $News=M('news');
        $temps=$News->where(array('user_id' => $id))->select();
        $count=count($temps);
        for ($i=0; $i < $count; $i++) { 
            $newsid[$i]=$temps[$i]['id'];
        }
        $content=M('content');
        for ($i=0; $i < $count; $i++) { 
            $id=$newsid[$i];
            //var_dump($id);
            $con[$i]=$content->where(array('news_id' => $id))->find();
            $temps[$i]['content']=$con[$i]['content'];
        }
        echo "<pre>";
        var_dump($temps);
        echo "</pre>";
    }
    //以上为已编辑函数
    ////////////////////////////////////////////////////////////////////////////////////////////
    /***************************************华丽的分割线***************************************/
    ////////////////////////////////////////////////////////////////////////////////////////////

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

    public function logout(){
    	$_SESSION['me'] = '';
    }
}