<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends CommonController {
	public function _initialize(){
		header("Content-type:text/html;charset=utf-8");
    }
    public function lists(){
    	$userlist = M('user')->select();
    	$school_list = M('University_all')->select();
    	$usercount = count($userlist);

    	$this->assign('totalCount',$usercount);
    	$this->assign('userinfo',$userlist);
    	$this->assign('date',$dateweek);
    	$this->display();
    }
    public function editor_user(){
    	$user_id = $_GET['id'];
    	if($user_id){
    		$user_info = M('user')->where(array('id' => $user_id))->find();
    		$school_id = $user_info['school_id'];
    		$province_id =  $user_info['province_id'];
    		$city_id =  $user_info['city_id'];
    		$province = M('province')->where(array('provinceid' => $province_id))->find();
    		$user_info['province'] = $province['province'];
    		$city = M('city') -> where(array('cityid' => $city_id ))->find();
    		$user_info['city'] = $city['city'];
    		$school = M('University_all')->where(array('id' => $school_id))->find();
    		$user_info['school'] = $school['s_name'];
    		$this->assign('user_info',$user_info);
    	}else{
    		$this->error('获取id失败');
    	} 
    	$area_tree = gatAreaData();
    	$school_list = M('University_all')->select();
    	$this->assign('school_list',$school_list);
    	$this->assign('area_tree', $area_tree);
    	$this->display();
    }
    public function saveUser(){
    	$uid = I('post.id',0);
    	$data['nickname'] = I('post.nickname',0);
    	$data['email'] = I('post.email',0);
    	$data['phone'] = I('post.phone',0);
    	$data['school_id'] = I('post.school_id',0);
    	$data['province_id'] = I('post.province_id',0);
    	$data['city_id'] = I('post.city_id',0);
    	if (I('password')) {
    		$data['password'] = md5(I('password'));
    	}
    	if ($uid) {
    		$re = M('user') ->where(array('id'=>$uid))->save($data);
    	
            $result['statusCode'] = "200";
            $result['message']   = "修改成功";
            $result['navTabId'] = "user";
            $result['rel']   = "user";
            $result['callbackType'] = "closeCurrent";
            $result['forwardUrl']   = "";
            $result['confirmMsg'] = "";

            $this->ajaxReturn($result);
    	}
    }

    public function ajaxChangeStatus(){
    	$id = I('get.id', 0);
    	$st = I('get.status',0);
        if ($st == 0) {
        	$data['status'] = -1;
            M('user')->where(array('id'=>$id))->save($data);
        } else {
        	$data['status'] = 0;
            M('user')->where(array('id'=>$id))->save($data);
        }

        $result['statusCode'] = "200";
        $result['message']   = "修改成功";
        $result['navTabId'] = "user";
        $result['rel']   = "user";
        if(I('close_dialog') == 1){
        	$result['callbackType'] = "closeCurrent";
        }
        $result['forwardUrl']   = "";
        $result['confirmMsg'] = "";

        $this->ajaxReturn($result);
    }
}