<?php
namespace Home\Controller;
use Think\Controller;
class NewsController extends Controller {
    public function newsList(){
      /*parse_str($_SERVER['QUERY_STRING'], $_GET);
      var_dump($_GET);*/
      echo $_SERVER['PHP_SELF'];
    	/*$News = M('News'); // 实例化News对象
	    $count      = $News->where('is_del != 1')->count();// 查询满足要求的总记录数
	    $Page       = new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
	    $show       = $Page->show();// 分页显示输出
	    // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
	    $list = $News->where('is_del != 1')->order('is_top')->limit($Page->firstRow.','.$Page->listRows)->select();
	    $this->assign('list',$list);// 赋值数据集
	    $this->assign('page',$show);// 赋值分页输出*/
    	$this->display();
    }

   	public function detail(){
   		$id = I('id','');
   		if(!$id) $this->error('参数错误');
   		$new_info = M('News')->where(array('id'=>$id))->find();
   		$new_content = M('Content')->where(array('news_is',$id))->find();
   		$nw_info['content'] = $new_content['content'];
   		$this->assign('new_info',$new_info);
   		$this->display();
   	}
}