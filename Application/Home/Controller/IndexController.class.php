<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index()
    {  
        $offset = 0;
        $limit  = 4;
        $category = M('Category')->where(array('pid'=>'0'))->select();

        //获取推荐内容
        $map = array();
        $map['id_del'] = array('neq',1);
        $map['is_top'] = 1;
        $News = D('News');
        $top_list = $News->where($map)->order('id desc')->limit($offset.','.$limit)->select();

        $this->assign('category',$category);
        $this->assign('top_list',$top_list);
    	$this->display();
    }

    public function ajaxLoading()
    {
    	$offset = I('offset',0);
    	$limit = I('limit',10);
    	$category_id = I('category_id',0);
    	$map = array();
    	$map['id_del'] = array('neq',1);
    	if($category_id)
    	{
    		$map['category_id'] = $category_id;
    	}
    	$News = D('News');
    	$list = $News->where($map)->order('id desc')->limit($offset.','.$limit)->select();
    	$this->ajaxReturn($list);
    }

}