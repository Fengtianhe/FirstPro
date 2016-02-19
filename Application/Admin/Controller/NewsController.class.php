<?php
namespace Admin\Controller;
use Think\Controller;
class NewsController extends CommonController {
    public $news_status = array(
        1 => array('id'=>1, 'name'=>'正常'),
        -1 => array('id'=>-1, 'name'=>'用户删除'),
        -2 => array('id'=>-2, 'name'=>'系统关闭'),
    );
	public function _initialize(){
        parent::_initialize();
    }
    public function lists(){
    	$where['report_count'] = 0;

 		$limit = 15;
        $pageNum        = I('pageNum', 1);
        $orderField     = I('orderField', 'id');
        $orderDirection = I('orderDirection', 'desc');
        $numPerPage     = I('numPerPage', $limit);
        
        $offset = ($pageNum -1) * $limit;

        if (I('request.title',0)) {
            $where['title'] = I('request.title');
        }
        if (I('request.category_id',0)) {
            $where['category_id'] = I('request.category_id');
        }
        if (I('request.status',0)) {
            $where['status'] = I('request.status');
        }
        if (I('request.start_time', 0) && I('request.end_time', 0)) {
            $where['created'] =  array(array('gt',strtotime(trim(I('request.start_time')))),array('lt',strtotime(trim(I('request.end_time')))));
        }
        $totalCount  = M('news')->where($where)->count('id');
        $newslist = M('news')->where($where)->order($orderField.' '.$orderDirection)->limit($offset.','.$limit)->select();
        $page = array('pageNum'=>$pageNum, 'orderField'=>$orderField, 'orderDirection'=>$orderDirection, 'numPerPage'=>$numPerPage, 'totalCount'=>$totalCount);
        $this->assign('page', $page);

        for ($i=0; $i < $totalCount; $i++) { 
        	$uid = $newslist[$i]['user_id'];
        	$userinfo = M('user')->where(array('id' => $uid))->find();
        	$newslist[$i]['email'] = $userinfo['email'];
            $cat_id = $newslist[$i]['category_id'];
            $category_info = M('category')->where(array('id'=>$cat_id))->find();
            $newslist[$i]['cat_name'] = $category_info['name'];
        }
        $category_tree = M('category')->select();
        $this->assign('category',$category_tree);
        $this->assign('newslist', $newslist);
 
        $this->assign('news_status',$this->news_status);
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
        $data['status'] = $st;
        
        if (M('news')->where(array('id'=>$id))->save($data)) {
            $result['statusCode'] = "200";
            $result['message']   = "修改成功";
            $result['navTabId'] = "news";
            $result['rel']   = "news";
            if(I('close_dialog') == 1){
                $result['callbackType'] = "closeCurrent";
            }
            $result['forwardUrl']   = "";
            $result['confirmMsg'] = "";
        }
        

        $this->ajaxReturn($result);
    }

    public function report(){
 		$limit = 15;
        $pageNum        = I('pageNum', 1);
        $orderField     = I('orderField', 'id');
        $orderDirection = I('orderDirection', 'desc');
        $numPerPage     = I('numPerPage', $limit);
        
        $offset = ($pageNum -1) * $limit;
        $where = array();
        if (I('request.news_id',0)) {
            $where['news_id'] = I('request.news_id');
        }
        if (I('request.user_id',0)) {
            $where['user_id'] = I('request.user_id');
        }
        if (I('request.status',0)) {
            $where['status'] = I('request.status');
        }
        if (I('request.start_time', 0) && I('request.end_time', 0)) {
            $where['create_time'] =  array(array('gt',strtotime(trim(I('request.start_time')))),array('lt',strtotime(trim(I('request.end_time')))));
        }

        $totalCount  = M('mark')->count('id');
        $marklist = M('mark')->where($where)->order($orderField.' '.$orderDirection)->limit($offset.','.$limit)->select();
        $page = array('pageNum'=>$pageNum, 'orderField'=>$orderField, 'orderDirection'=>$orderDirection, 'numPerPage'=>$numPerPage, 'totalCount'=>$totalCount);
        $this->assign('page', $page);
        $category_tree = M('category')->select();
        $this->assign('category',$category_tree);
        $this->assign('marklist', $marklist);
    	$this->display();
    }
}