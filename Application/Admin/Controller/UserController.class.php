<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends CommonController {
    public $user_status = array(
        0 => array('id'=>0, 'name'=>'未生效'),
        1 => array('id'=>1, 'name'=>'正常'),
        -1 => array('id'=>-1, 'name'=>'关闭'),
    );
     public $email_verify_status = array(
        0 => array('id'=>0, 'name'=>'未验证'),
        1 => array('id'=>1, 'name'=>'已验证'),
    );
	public function _initialize(){
        parent::_initialize();
    }
    public function lists(){
        $limit = 15;
        $pageNum        = I('pageNum', 1);
        $orderField     = I('orderField', 'id');
        $orderDirection = I('orderDirection', 'desc');
        $numPerPage     = I('numPerPage', $limit);
        
        $offset = ($pageNum -1) * $limit;
        
        if (I('request.id', 0)) {
            $where['id'] = trim(I('request.id'));
        }
        if (I('request.email', 0)) {
            $where['email'] = trim(I('request.email'));
        }
        if (I('request.nickname', 0)) {
            $where['nickname'] = trim(I('request.nickname'));
        }
        if (I('request.status', 0)) {
            $where['status'] = trim(I('request.status'));
        }
        if (I('request.is_verify_email', 0)) {
            $where['is_verify_email'] = trim(I('request.is_verify_email'));
        }
        if (I('request.school_id', 0)) {
            $where['school_id'] = trim(I('request.school_id'));
        }
        if (I('request.start_time', 0) && I('request.end_time', 0)) {
            $where['created'] =  array(array('gt',strtotime(trim(I('request.start_time')))),array('lt',strtotime(trim(I('request.end_time')))));
        }
        
        $totalCount  = M('user')->where($where)->count('id');
        $userlist = M('user')->where($where)->order($orderField.' '.$orderDirection)->limit($offset.','.$limit)->select();
        $page = array('pageNum'=>$pageNum, 'orderField'=>$orderField, 'orderDirection'=>$orderDirection, 'numPerPage'=>$numPerPage, 'totalCount'=>$totalCount);
        $this->assign('page', $page);
    	
        for ($i= 0; $i < $totalCount; $i++) { 
            $school_id = $userlist[$i]['school_id'];
            $school = M('University_all')->where(array('id' => $school_id))->find();
            $userlist[$i]['school'] = $school['s_name'];
        }

        $school_list = M('University_all')->select();
        $this->assign('school_list',$school_list);

    	$this->assign('totalCount',$totalCount);
    	$this->assign('userinfo',$userlist);
    	$this->assign('date',$dateweek);
        $this->assign('email_verify_status', $this->email_verify_status);
        $this->assign('user_status', $this->user_status);
    	$this->display();
    }
    public function editor_user(){
    	$user_id = $_GET['id'];
    	if($user_id){
    		$user_info = M('user')->where(array('id' => $user_id))->find();
    		$school_id = $user_info['school_id'];
    		$school = M('University_all')->where(array('id' => $school_id))->find();
    		$user_info['school'] = $school['s_name'];
    		$this->assign('user_info',$user_info);
    	}else{
    		$this->error('获取id失败');
    	} 
    
    	$school_list = M('University_all')->select();
    	$this->assign('school_list',$school_list);

    	$this->display();
    }
    public function saveUser(){
    	$uid = I('post.id',0);
    	$data['nickname'] = I('post.nickname',0);
    	$data['email'] = I('post.email',0);
    	$data['phone'] = I('post.phone',0);
    	$data['school_id'] = I('post.school_id',0);
        $school_id = $data['school_id'];
        $school = M('University_all')->where(array('id' => $school_id))->find();
        $data['province_id'] = $school['province_id'];
        $data['city_id'] = $school['city_id'];
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
        if ($st == 1) {
        	$data['status'] = -1;
            M('user')->where(array('id'=>$id))->save($data);
        } else {
        	$data['status'] = 1;
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