<?php
namespace Admin\Controller;
use Think\Controller;
class ContactController extends CommonController {
	public function _initialize(){
		parent::_initialize();
    }

    public $contact_status = array(
            0 => array('id'=>0, 'name'=>'正常'),
            1 => array('id'=>1, 'name'=>'已回复'),
            2 => array('id'=>2, 'name'=>'标记异常'),
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
        $totalCount  = M('contact')->where($where)->count('id');
        $contact_list = M('contact')->where($where)->order($orderField.' '.$orderDirection)->limit($offset.','.$numPerPage)->select();
        $page = array('pageNum'=>$pageNum, 'orderField'=>$orderField, 'orderDirection'=>$orderDirection, 'numPerPage'=>$numPerPage, 'totalCount'=>$totalCount);
        $this->assign('page', $page);
        $this->assign('contact_status', $this->contact_status);
        $this->assign('contact_list', $contact_list);
        $this->display();
    }

    public function info(){
        $id = I('id', 0);
        if ($id) { 
            $contact_info = M('contact')->where(array('id'=>$id))->find();
            $this->assign('contact_info', $contact_info);
        }
        $this->display();
    }

    public function save_contact(){
        $id = I('request.id', 0);    
        $data['status']       = I('request.status',0); 
        //留言记录 只改不增
        if ($id) {
            $data['updated'] = time();
            M('contact')->where(array('id'=>$id))->save($data);
        }
        $result['statusCode'] = "200";
        $result['message']   = "修改成功";
        $result['navTabId'] = "contact";
        $result['rel']   = "contact";
        if (I('close_dialog') == 1) {
            $result['callbackType'] = "closeCurrent";
        }
        $result['forwardUrl']   = "";
        $result['confirmMsg'] = "";
        $this->ajaxReturn($result);
    }
}