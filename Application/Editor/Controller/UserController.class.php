<?php
namespace Editor\Controller;
use Think\Controller;
class UserController extends Controller {
    //判断是否登录
    public function _initialize(){
    	header("Content-type:text/html;charset=utf-8");
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
    	if ($_POST['password']!==$_POST['check_password']) {
    		$this->error("两次输入的密码不一致");
    	}
        $data = $_POST;
        $_POST['password'] = md5($_POST['password']);
        $data['aid']=$_POST['answer'];
        $data['password']=$_POST['password'];
        $data['answer']=md5($_POST['a_ans']);
        $data['university_id']=$_POST['sid'];
        $e=$this->is_verify($data['email']);
        $p=$this->is_verify($data['phone']);
        $email=$data['email'];
        $phone=$data['phone'];
        $User=M('user');
        $va=$User->where(array('email' => $email))->select();
        $vb=$User->where(array('phone' => $phone))->select();
        if (!$e) {
            $this->error("邮箱格式错误");
        }
        elseif (!$p) {
            $this->error("手机格式错误");
        }
        elseif($va||$vb){
        	$this->error("账号已存在");
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
        $list=M('university_all')->order('s_name asc')->select();
        foreach ($list as $value => $k) {
            $lists[$value]['id']=$k['id'];
            $lists[$value]['s_name']=$k['s_name'];
        }
        $answer=M('answer')->select();
        $this->assign('s_answer',$answer);
        $this->assign('s_list',$lists);
        ////获取页面内容 ajax返回 弹窗显示
        $html = $this->fetch('User/reg');
        $data['data'] = $html;
        $data['status'] = 'OK';
        $this->ajaxReturn($data);
    }

    //登录页面
    public function login(){
        //获取页面内容 ajax返回 弹窗显示
        $html = $this->fetch('User/login');
        $data['data'] = $html;
        $data['status'] = 'OK';
        $this->ajaxReturn($data);
    }

    //邮箱登陆
    public function handle_email_login(){
        $email = I('post.email');
        $password = I('post.password');
        if($email && $password){
            if($res = D('user')->where(array('email'=>$email,'password'=>md5($password)))->find()){
                $data['lastlogintime'] = time();
                M('user')->where(array('email' => $email))->save($data);
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
                $data['lastlogintime'] = time();
                M('user')->where(array('phone' => $phone))->save($data);
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

    //注销函数
	public function logout(){
    	$_SESSION['me'] = '';
    	$this->redirect('home/index/index');
    }
}