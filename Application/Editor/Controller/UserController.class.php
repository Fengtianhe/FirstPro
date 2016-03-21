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
    	/*if ($_POST['password']!==$_POST['check_password']) {
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
            $this->success('注册成功',U('/home/index/index'));
        }*/
        if (!I('post.agree')) {
            $this->error("请认真阅读并同意《课外Online用户协议》");
        }
        $email = I('post.email');
        $password = I('post.password');
        $sid = I('sid');
        $school_info = M('university_all')->where(array('id'=>$sid))->find();
        $e=$this->is_verify($email);
        if (!$email || !$password || !$sid) {
            $this->error("请认真填写注册数据，均为必填项");
        }
        if (!$e) {
            $this->error("邮箱格式错误");
        }
        if (!is_array($school_info) || empty($school_info)) {
            $this->error("学校信息出错");
        }
        $data['email'] = $email;
        $data['password'] = md5($password);
        $data['token']    = mb_substr(md5($password.time().'kewaionline'), 0, 15);
        $data['created'] = $data['send_verify_email_time'] = time();
        $data['status'] = 0;
        $data['school_id'] = $school_info['id'];
        $data['province_id'] = $school_info['province_id'];
        $data['city_id'] = $school_info['city_id'];

        $User=M('user');
        $where['email'] = $email;
        $user_exist=$User->where($where)->find();
        if (is_array($user_exist)) {
            if ($user_exist['is_verify_email'] == 1) {
                $this->error("邮箱账号已经存在，若有问题请联系管理员");
            } elseif ($user_exist['send_verify_email_time'] > time()-172800) {
                $this->error("您已注册请查收你的邮箱验证账号，或48小时候重试");
            } else {
                $User->where(array('id'=>$user_exist['id']))->save($data);
                $id = $user_exist['id'];
            }
        } else {
            $id = $User->add($data);
        }
        $user_info = $User->where(array('id'=>$id))->find(); 
        D('Common/Mail')->sendUserRegistVerifyMail($user_info);
        $this->success('注册成功',U('/home/index/index'));
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
        $list=M('university_all')->order('s_name asc')->select();
        $this->assign('s_list',$list);
        $this->assign('callback', I('get.callback',''));
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
        $callback = I('post.callback');
        if ($callback) {
            $callback = base64_decode($callback);
        } else {
            $callback = U('/home/index/index');
        }
        
        if($email && $password){
            if($res = D('user')->where(array('email'=>$email,'password'=>md5($password),'status'=>1))->find()){
                $data['lastlogintime'] = time();
                M('user')->where(array('email' => $email))->save($data);
                $_SESSION['me'] = $res;
                $this->success('登陆成功',$callback);
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
                $this->success('登陆成功',U('/home/index/index'));
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

    //验证邮箱
    public function email_verify() {
        $code = I('get.code','');
        $code = base64_decode($code);
        parse_str($code, $param);
        if (is_array($param) && count($param) == 3 && $param['id'] && $param['email'] && $param['token']) {
            $data['status'] = 1;
            $data['is_verify_email'] = 1;
            $data['verify_email_time'] = time();
            $param['send_verify_email_time'] = array('gt',time()-172800);
            $status = D('user')->where($param)->save($data);
        }

        if ($status) {
            $this->success('验证成功', U('/home/index/index'));
        } else {
            $this->error('验证失败', U('/editor/index/info'));
        }
    }
}