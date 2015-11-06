<?php
namespace Home\Controller;
use Think\Controller;
class NewsController extends Controller {
    private $price = array(
                    '0'    => array('min' => 0, 'max' => 500, 'name' => '0~500'),
                    '1'    => array('min' => 500, 'max' => 1000, 'name' => '500~1000'),
                    '2'    => array('min' => 1500, 'max' => 2000, 'name' => '1500~2000'),
                    '3'    => array('min' => 2000, 'max' => 3000, 'name' => '2000~3000'),
                    '4'    => array('min' => 3000, 'max' => 0, 'name' => '3000以上'),
    );
    public function newsList(){
        $category = M('Category')->where(array('pid'=>'0'))->select();
        if(!is_null($_REQUEST['category']) && $_REQUEST['category'] !== '')
        {
            $map['category_id'] = $category[$_REQUEST['category']]['id'];
            $del_icon[] = array(
                    'rel'=>'category',
                    'key'=>$_REQUEST['category'],
                    'name' => $category[$_REQUEST['category']]['name']);
        }
        if(!is_null($_REQUEST['price']) && $_REQUEST['price'] !== '')
        {
            if(!$this->price[$_REQUEST['price']]['max'])
            {
                $map['price'] = array('gt',$this->price[$_REQUEST['price']]['min']);
            }
            else
            {
                $map['price'] = array('between',array($this->price[$_REQUEST['price']]['min'],$this->price[$_REQUEST['price']]['max']));
            }
            $del_icon[] = array(
                'rel'=>'price',
                'key'=>$_REQUEST['price'],
                'name' => $this->price[$_REQUEST['price']]['name']);
            
        }
        if(!is_null($_REQUEST['keyword']))
        {
            $map['title'] = array('like','%'.$_REQUEST['keyword'].'%');
        }
        $map['id_del'] = array('neq',1); 
    	$News = M('News'); // 实例化News对象
        $count      = $News->where($map)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $News->where($map)->order('is_top')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('price',$this->price);
        $this->assign('category',$category);
        $this->assign('del_icon',$del_icon);
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