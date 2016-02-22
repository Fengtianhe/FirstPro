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

        //获取推荐内容 todo 临时策略按照 查看次数倒叙 避免首页出现空位
        $map = array();
        $map['status'] = 1;
        /*$map['is_top'] = 1;
        $map['top_expire'] = array('gt', time());*/
        $News = D('News');
        $top_list = $News->where($map)->order('show_count desc')->limit($offset.','.$limit)->select();

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

    public function changeArea()
    {
        $where['status'] = 1;
        $school_list = M('university_all')->where($where)->select();
        
        $this->assign('school_list', $school_list);
        //获取页面内容 ajax返回 弹窗显示
        $html = $this->fetch('Index/changeArea');
        $data['data'] = $html;
        $data['status'] = 'OK';
        $this->ajaxReturn($data);
    }

    public function handleChangeArea()
    {
        $school_id = I('school_id',0);
        $school_info = M('university_all')->where(array('id'=>$school_id))->find();
        $_SESSION['area']['school'] = $school_info;
        $this->ajaxReturn(array('status'=>'OK','info'=>'设置成功'));
    }
}