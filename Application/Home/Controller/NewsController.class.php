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
        $limit = 20;
        $category = M('Category')->where(array('pid'=>'0'))->select();
        if(!is_null($_REQUEST['category']) && $_REQUEST['category'] !== '')
        {
            $map['category_id'] = $category[$_REQUEST['category']]['id'];
            $del_icon[] = array(
                    'rel'=>'category',
                    'key'=>$_REQUEST['category'],
                    'name' => $category[$_REQUEST['category']]['name']);
        }
        
        if($_REQUEST['category'])
        {
            $map['category_id'] = (int) $_REQUEST['category'];
        }
        if(!is_null($_REQUEST['keyword']))
        {
            $map['title'] = array('like','%'.$_REQUEST['keyword'].'%');
        }
        $map['id_del'] = array('neq',1); 
    	$News = M('News'); // 实例化News对象
        $count      = $News->where($map)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,$limit);// 实例化分页类 传入总记录数和每页显示的记录数(25)
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
        $new_info['show_count'] = D('News')->showNum($id);
   		$new_content = M('Content')->where(array('news_id',$id))->find();
   		$new_info['content'] = $new_content['content'];
   		$this->assign('new_info',$new_info);
   		$this->display();
   	}

    //ajax处理 举报信息 方便后台管理员根据举报信息及时删除不良信息
    public function ajaxHandleMark()
    {
        $data['news_id']     = I('id');
        $data['user_id']     = $_SESSION['me']['id'];
        $data['email']       = I('email');
        $data['mark_result'] = I('mark_result');
        $data['create_time'] = time();
        $result = M('Mark')->add($data);
        $arr = array('status'=>'OK','info'=>'标记成功','data'=>$result);
        echo json_encode($arr);
    }

    //ajax处理 收藏信息
    public function ajaxHandleCollect()
    {
        $data['news_id']     = I('id');
        $data['user_id']     = I('user_id',0);
        $data['create_time'] = time();

        //避免重复收藏
        if(!M('Collect')->where(array('news_id'=>$data['news_id'],'user_id'=>$data['user_id']))->find())
        {
            $result = M('Collect')->add($data);
            $arr = array('status'=>'OK','info'=>'收藏成功','data'=>$result);
            
        }
        else 
        {
            $arr = array('status'=>'OK','info'=>'您已经收藏过本信息','data'=>0);
        }
        echo json_encode($arr);
    }

    public function test()
    {
        var_dump($_REQUEST);
    }


}