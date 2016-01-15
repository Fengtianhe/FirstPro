<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    Public $area = array(
       // '1' => array('name'=>'吉林市','school'=>array('1'=>'北华','2'=>'东电')),
        '1' => array('name'=>'吉林市','school'=>array('1'=>array('name'=>'北华大学'),'2'=>array('name'=>'东北电力'))),
        '2' => array('name'=>'长春市','school'=>array('3'=>array('name'=>'吉林大学'),'4'=>array('name'=>'长春大学'))),
    );
    public function _initialize(){
        header("Content-type:text/html;charset=utf-8");
    }
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

        $this->assign('checked', 1);              
        $this->assign('area', $this->area);
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

    public function ajaxGetArea()
    {
        $id   = I('id',0);
        $type = I('type','');
        $area = $this->area;

        if ($type == 'area') {
            $data['status'] = 'OK';
            $data['data'] = $area;
            $data['default_id'] = $_SESSION['location']['area_id'];
        } elseif ($type == 'school') {
            $data['status'] = 'OK';
            $_SESSION['location']['area_id'] = $id;
            $_SESSION['location']['school_id'] = key($area[$id]['school']);
            $data['default_id'] = $_SESSION['location']['school_id'];
            $data['data'] = $area[$id]['school'];
        } elseif ($type == 'finish') {
            $data['status'] = 'ERROR';
            $_SESSION['location']['school_id'] = $id;
            $data['data'] = array();
        } else {
            $data['status'] = 'ERROR';
            $data['data'] = array();
        }
    
        $this->ajaxReturn($data);
    }

}