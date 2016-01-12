<?php
namespace Editor\Controller;
use Think\Controller;
class AccountController extends CommonController{
	public function _initialize(){
		header("Content-type:text/html;charset=utf-8");
    }
    
	public function index(){
		$this->display();
	}
	public function ModifyPwd(){
		$this->display();
	}
	//重置密码
	public function Modify(){
		$oldpwd=md5($_POST['oldpassword']);
		$uid=$_SESSION['me']['id'];
		$userinfo=M('user')->where(array('id' => $uid ))->find();
		$correctpwd=$userinfo['password'];
		if ($oldpwd!==$correctpwd) {
			$this->error("原始密码输入错误");
		}
		elseif ($_POST['newpassword']!==$_POST['check_password']) {
    		$this->error("两次输入的密码不一致");
    	}
   		else{
   			$temp['password']=md5($_POST['newpassword']);
   			if (M('user')->where(array('id' => $uid ))->save($temp)) {
   				$_SESSION['me'] = '';
   				$this->success('修改成功,请重新登录',U('Editor/user/login'));
   			}
   			else{
   				var_dump(M('user')->getlastsql());
   				die();
   				$this->error('修改失败，请重试',U('editor/account/ModifyPwd'));
   			}
   		}

	}
	//忘记密码
	public function forget(){
		$this->assign('step','0');
		$this->display();
	}
	public function step_1(){
		$email=$_POST['email'];
		$user=M('user');
		$result=$user->where(array('eamil' => $email))->find();
		if ($result) {
			$uid = $result['id'];
			$question_id=$result['aid'];
			$question=M('answer')->where(array('aid' => $question_id))->find();
			$problem=$question['atitle'];
			$this->assign('uid',$uid);
			$this->assign('problem',$problem);
			$this->assign('step','1');
			$this->display('forget');
		}else{
			$this->error('该用户不存在');
		}
		
	}
	public function step_2(){
		$answer = md5($_POST['answer']);
		$uid = $_POST['uid'];
		$user=M('user');
		$result=$user->where(array('id' => $uid))->find();
		if ($answer==$result['answer']) {
			$this->assign('uid',$uid);
			$this->assign('step','2');
			$this->display('forget');
		}else{
			$this->error('你输入的答案有误！请重新输入。');
		}
	}
	public function step_3(){
		if ($_POST['password']==$_POST['check_password']) {
			$uid = $_POST['uid'];
			$data['password']=md5($_POST['password']);
			$user=M('user');
			$result=$user->where(array('id' => $uid))->save($data);
			if ($result) {
				$this->success('修改成功，请登录！',U('editor/user/login'));
			}
			else{
				$this->error('修改失败，或与原密码一样，请重试');
			}
		}else{
			$this->error('两次输入的密码不一致！');
		}
	}


}
?>