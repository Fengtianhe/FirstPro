<?php
namespace Admin\Controller;
use Think\Controller;
class AdminuserController extends CommonController {
	public function _initialize(){
		parent::_initialize();
    }

    public $admin_user_status = array(
            1 => array('id'=>1, 'name'=>'正常'),
            -1 => array('id'=>-1, 'name'=>'删除'),
        );
    
    public function lists(){
        $limit = 20;
        $pageNum        = I('pageNum', 1);
        $orderField     = I('orderField', 'id');
        $orderDirection = I('orderDirection', 'desc');
        $numPerPage     = I('numPerPage', $limit);
        
        $offset = ($pageNum -1) * $numPerPage;
        if (I('request.name', 0)) {
            $where['name'] = trim(I('request.name'));
        }
        if (I('request.email', 0)) {
            $where['query'] = trim(I('request.email'));
        }
        if (I('request.status', 0)) {
            $where['status'] = trim(I('request.status'));
        }
        $totalCount  = M('Admin_user')->where($where)->count('id');
        $admin_user_list = M('Admin_user')->where($where)->order($orderField.' '.$orderDirection)->limit($offset.','.$numPerPage)->select();
        $page = array('pageNum'=>$pageNum, 'orderField'=>$orderField, 'orderDirection'=>$orderDirection, 'numPerPage'=>$numPerPage, 'totalCount'=>$totalCount);
        $this->assign('page', $page);
        $this->assign('admin_user_status', $this->admin_user_status);
        $this->assign('admin_user_list', $admin_user_list);
        $this->display();
    }

    public function editor_admin_user(){
        $id = I('id', 0);
        if ($id) {
            $admin_user_info = M('Admin_user')->where(array('id'=>$id))->find();
            $this->assign('admin_user_info', $admin_user_info);
        }
        $this->display();
    }

    public function save_admin_user(){
        $id = I('request.id', 0);
        
        $data['name']         = I('name','');
        $data['email']        = I('email',0);
        $data['department']   = I('department',0);
        if (I('request.password',0)) {
            $data['password']     = md5(I('request.password',0));
        }
        
        $data['status']       = I('request.status',1); 
        foreach ($data as $key=>$value) {
            if (!$value) {
                unset($data[$key]);
            }
        }
        if ($id) {
            $data['updated'] = time();
            M('Admin_user')->where(array('id'=>$id))->save($data);
        } else {
            $data['created'] = time();
            M('Admin_user')->add($data);
        }

        $result['statusCode'] = "200";
        $result['message']   = "修改成功";
        $result['navTabId'] = "admin_user";
        $result['rel']   = "admin_user";
        if (I('close_dialog') == 1) {
            $result['callbackType'] = "closeCurrent";
        }
        $result['forwardUrl']   = "";
        $result['confirmMsg'] = "";
        $this->ajaxReturn($result);
    }
}