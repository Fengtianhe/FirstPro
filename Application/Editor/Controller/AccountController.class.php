<?php
namespace Editor\Controller;
use Think\Controller;
class AccountController extends CommonController{

	public function _initialize(){
        parent::_initialize();
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


}
?>