<?php
namespace Admin\Controller;
use Think\Controller;
class NewsController extends CommonController {
	public function _initialize(){
		header("Content-type:text/html;charset=utf-8");
    }
    public function lists(){
    	$where['is_del'] = 0; 
    	$where['report_count'] = 0;

 		$limit = 15;
        $pageNum        = I('pageNum', 1);
        $orderField     = I('orderField', 'id');
        $orderDirection = I('orderDirection', 'desc');
        $numPerPage     = I('numPerPage', $limit);
        
        $offset = ($pageNum -1) * $limit;


        $totalCount  = M('news')->where($where)->count('id');
        $newslist = M('news')->where($where)->order($orderField.' '.$orderDirection)->limit($offset.','.$limit)->select();
        $page = array('pageNum'=>$pageNum, 'orderField'=>$orderField, 'orderDirection'=>$orderDirection, 'numPerPage'=>$numPerPage, 'totalCount'=>$totalCount);
        $this->assign('page', $page);

        for ($i=0; $i < $totalCount; $i++) { 
        	$uid = $newslist[$i]['user_id'];
        	$userinfo = M('user')->where(array('id' => $uid))->find();
        	$newslist[$i]['u_nickname'] = $userinfo['nickname'];
        }
        $this->assign('newslist', $newslist);

    	$this->display();
    }

    public function ajaxChangeStatus(){
    	$id = I('get.id', 0);
    	$st = I('get.status',0);
        if ($st == 0) {
        	$data['is_top'] = 1;
            M('news')->where(array('id'=>$id))->save($data);
        } else {
        	$data['is_top'] = 0;
            M('news')->where(array('id'=>$id))->save($data);
        }

        $result['statusCode'] = "200";
        $result['message']   = "修改成功";
        $result['navTabId'] = "news";
        $result['rel']   = "news";
        if(I('close_dialog') == 1){
        	$result['callbackType'] = "closeCurrent";
        }
        $result['forwardUrl']   = "";
        $result['confirmMsg'] = "";

        $this->ajaxReturn($result);
    }

    public function ajaxChangeDel(){
    	$id = I('get.id', 0);
    	$st = I('get.status',0);
        if ($st == 0) {
        	$data['is_del'] = -1;
            M('news')->where(array('id'=>$id))->save($data);
        } else {
        	$data['is_del'] = 0;
            M('news')->where(array('id'=>$id))->save($data);
        }

        $result['statusCode'] = "200";
        $result['message']   = "修改成功";
        $result['navTabId'] = "news";
        $result['rel']   = "news";
        if(I('close_dialog') == 1){
        	$result['callbackType'] = "closeCurrent";
        }
        $result['forwardUrl']   = "";
        $result['confirmMsg'] = "";

        $this->ajaxReturn($result);
    }

    public function report(){
    	$where['is_del'] = -1; 

 		$limit = 15;
        $pageNum        = I('pageNum', 1);
        $orderField     = I('orderField', 'id');
        $orderDirection = I('orderDirection', 'desc');
        $numPerPage     = I('numPerPage', $limit);
        
        $offset = ($pageNum -1) * $limit;


        $totalCount  = M('news')->where($where)->count('id');
        $newslist = M('news')->where($where)->order($orderField.' '.$orderDirection)->limit($offset.','.$limit)->select();
        $page = array('pageNum'=>$pageNum, 'orderField'=>$orderField, 'orderDirection'=>$orderDirection, 'numPerPage'=>$numPerPage, 'totalCount'=>$totalCount);
        $this->assign('page', $page);

        for ($i=0; $i < $totalCount; $i++) { 
        	$uid = $newslist[$i]['user_id'];
        	$userinfo = M('user')->where(array('id' => $uid))->find();
        	$newslist[$i]['u_nickname'] = $userinfo['nickname'];
        }
        $this->assign('newslist', $newslist);

    	$this->display();
    }
}