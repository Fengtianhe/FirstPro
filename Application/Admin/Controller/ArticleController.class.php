<?php
namespace Admin\Controller;
use Think\Controller;
class ArticleController extends CommonController {
    public $article_status = array(
            0 => array('id'=>0, 'name'=>'正常'),
            1 => array('id'=>1, 'name'=>'发布'),
            -1 => array('id'=>-1, 'name'=>'删除'),
        );
	public function _initialize(){
		header("Content-type:text/html;charset=utf-8");
    }
    public function lists(){
        $limit = 20;
        $pageNum        = I('pageNum', 1);
        $orderField     = I('orderField', 'id');
        $orderDirection = I('orderDirection', 'desc');
        $numPerPage     = I('numPerPage', $limit);
        
        $offset = ($pageNum -1) * $numPerPage;
        if (I('request.s_name', 0)) {
            $where['s_name'] = trim(I('request.s_name'));
        }
        if (I('request.province_id', 0)) {
            $where['province_id'] = trim(I('request.province_id'));
        }
        if (I('request.city_id', 0)) {
            $where['city_id'] = trim(I('request.city_id'));
        }
        if (I('request.status', 0)) {
            $where['status'] = trim(I('request.status'));
        }
        if (I('request.start_time', 0) && I('request.end_time', 0)) {
            $where['created'] =  array(array('gt',strtotime(trim(I('request.start_time')))),array('lt',strtotime(trim(I('request.end_time')))));
        }
        $totalCount  = M('Article')->where($where)->count('id');
        $article_list = M('Article')->where($where)->order($orderField.' '.$orderDirection)->limit($offset.','.$numPerPage)->select();
        $page = array('pageNum'=>$pageNum, 'orderField'=>$orderField, 'orderDirection'=>$orderDirection, 'numPerPage'=>$numPerPage, 'totalCount'=>$totalCount);
        $this->assign('page', $page);
        $this->assign('article_status', $this->article_status);
        $this->assign('article_list', $article_list);
    	$this->display();
    }

    public function editor_article(){
        $id = I('id', 0);
        if ($id) {
            $article_info = M('Article')->where(array('id'=>$id))->find();
            $this->assign('article_info', $article_info);
        }
        $this->display();
    }

    public function saveArticle(){
        $id = I('request.id', 0);
        
        $data['title']      = I('title','');
        $data['sort']       = I('sort',0);
        $data['query']      = I('query',0);
        $data['status']     = I('request.status',0);
        $data['content']    = I('request.content',0);
        foreach ($data as $key=>$value) {
            if (!$value) {
                unset($data[$key]);
            }
        }
        if ($id) {
            $data['updated'] = time();
            M('Article')->where(array('id'=>$id))->save($data);
        } else {
            $data['created'] = time();
            M('Article')->add($data);
        }

        $result['statusCode'] = "200";
        $result['message']   = "修改成功";
        $result['navTabId'] = "article";
        $result['rel']   = "article";
        if (I('close_dialog') == 1) {
            $result['callbackType'] = "closeCurrent";
        }
        $result['forwardUrl']   = "";
        $result['confirmMsg'] = "";
        $this->ajaxReturn($result);
    }
}