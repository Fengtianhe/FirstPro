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
        //用户收藏数据 应缓存  提高效率 TODO 以后最好采用memcache做缓存
        $collect_arr = array();
        $collect  = M('Collect')->where(array('user_id'=>$_SESSION['me']['id'], 'status'=>0))->field('id, news_id')->select();
        if (is_array($collect) && !empty($collect)) {
            foreach ($collect as $key=>$value) {
                $collect_arr[$value['news_id']] = 1;
            }
        }
        
        if($_REQUEST['category'])
        {
            $map['category_id'] = (int) $_REQUEST['category'];
        }
        if(!is_null($_REQUEST['keyword']))
        {
            $map['title'] = array('like','%'.$_REQUEST['keyword'].'%');
        }
        if ($_SESSION['area']['school']['id'] > 0) {
            $map['school_id'] = (int) $_SESSION['area']['school']['id'];
        }
        $map['status'] = 1; 
        $map['_string'] = 'is_top=0 OR (is_top =1 && top_expire < '.time().')';

        $top_map['status'] = 1;
        $top_map['is_top'] = 1;
        $top_map['top_expire'] = array('gt', time());

    	$News = M('News'); // 实例化News对象
        $count      = $News->where($map)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,$limit);// 实例化分页类 
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $top_list = $News->where($top_map)->order('top_expire desc')->select();
        $list = $News->where($map)->order('updated desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('top_list',$top_list);// 赋值数据集
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('category',$category);
        $this->assign('collect_arr',$collect_arr);// 收藏信息
    	$this->display();
    }

    //获取数据
    public function getNewsListData(){
        $offset = I('offset');
        $limit = 20;
        if ($_SESSION['area']['school']['id'] > 0) {
            $map['school_id'] = (int) $_SESSION['area']['school']['id'];
        }
        $map['status'] = 1; 
        $map['_string'] = 'is_top=0 OR (is_top =1 && top_expire < '.time().')';
        $News = M('News'); // 实例化News对象
        $lists = $News->where($map)->order('updated desc')->limit($offset.','.$limit)->select();
        $result['status'] = 'OK';
        $result['lists'] = $lists;
        $this->ajaxReturn($result);
    }

   	public function detail(){
   		$id = I('id','');
   		if(!$id) $this->error('参数错误');
        
   		$new_info = M('News')->where(array('id'=>$id))->find();
        $new_info['show_count'] = D('News')->showNum($id);
   		$new_content = M('Content')->where(array('news_id'=>$id))->find();
        //$new_info['images'] = json_decode($new_content['images'], true);

        $is_collect = 0;
        $collect  = M('Collect')->where(array('user_id'=>$_SESSION['me']['id'], 'news_id'=>$id, 'status'=>0))->field('id, news_id')->find();
   		if (is_array($collect) && !empty($collect)) {
            $is_collect = 1;
        }
        $new_info['content'] = $new_content['content'];
   		$this->assign('new_info',$new_info);
        $this->assign('is_collect',$is_collect);
        $this->assign('new_images',json_decode($new_content['images'], true));
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
        $data['status']      = $collect_type = I('collect_type',0);
        $data['create_time'] = time();

        //避免重复收藏
        if($collect_info = M('Collect')->where(array('news_id'=>$data['news_id'],'user_id'=>$data['user_id']))->find())
        {
            if ($collect_type != $collect_info['status']) {
                $result = M('Collect')->where(array('news_id'=>$data['news_id'],'user_id'=>$data['user_id']))->save(array('status'=>$collect_type));
                if ($collect_type < 0 ) {
                    $info = "收藏已取消"; 
                } else {
                    $info = "收藏成功"; 
                }
                
            } else {
                $info = "服务器出错啦"; 
            }
        }
        else 
        {
            $result = M('Collect')->add($data);
            $info = "收藏成功";        
        }
        $arr = array('status'=>'OK','info'=>$info,'data'=>$result);
        $arr['collect_type'] = $collect_type <0 ? 0 : -1;
        echo json_encode($arr);
    }
}