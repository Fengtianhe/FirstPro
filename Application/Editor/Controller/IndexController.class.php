<?php
namespace Editor\Controller;
use Editor\Controller;
class IndexController extends CommonController {
	public function _initialize(){
		parent::_initialize();
	}
    public function info(){
        $id=$_SESSION['me']['id'];
        $News=M('news');
        $temps=$News->where(array('user_id' => $id))->field('id,title,price,img,show_count,is_top,status,created')->select();
        foreach ($temps as $key=>$value) {
            $temps[$key]['img'] = '<img width="100px" height="100px" src="/Public/uploads/'.$value['img'].'">';
            $temps[$key]['created'] = date('Y.m.d',$temps[$key]['created']);
            $temps[$key]['handle'] = $this->getHandleHtml($value);
        }
        $this->assign('datas',$temps);
        $this->display();
    }

    public function addNew(){
        $this->display();
    }

    //用户发表列表
    public function myList(){
        $id=$_SESSION['me']['id'];
        $News=M('news');
        $temps=$News->where(array('user_id' => $id))->field('id,title,price,img,show_count,is_top,status,created')->select();
        foreach ($temps as $key=>$value) {
            $temps[$key]['img'] = '<img width="100px" height="100px" src="/Public/uploads/'.$value['img'].'">';
        	$temps[$key]['handle'] = $this->getHandleHtml($value);
        }
        $this->ajaxReturn($temps);
    }

    public function getHandleHtml($info){
    	if ($info['status'] == -1) {
    		$html = "<a class='btn recover' href='javascript:;' rel='".$info['id']."'><div class='butthree'>恢复</div></a>";
    	} elseif ($info['status'] == 1) {
    		$html = "<a class='btn edit' href='javascript:;' rel='".$info['id']."'><div class='butthree'>编辑</div></a>";
    		$html .= "<a class='btn top' href='javascript:;' rel='".$info['id']."'><div class='butthree'>置顶</div></a>";
    		$html .= "<a class='btn del' href='javascript:;' rel='".$info['id']."'><div class='butthree'>删除</div></a>";
    	}
    	return $html;
    }

    public function ajaxHandle(){
    	$id  = I('id');
    	$user_id = $_SESSION['me']['id'];
    	$act = I('act');
    	
    	if(in_array($act, array('del','top','recover'))) {
    		if ($act == 'del') {
    			$data['status'] = -1;
    		} elseif ($act == 'recover') {
    			$data['status'] = 1;
    		} elseif ($act == 'top') {
                //判断是否符合置顶条件 置顶需要金币 
                $user_info  = M('user')->where(array('id'=>$user_id))->find();
                if ($user_info['account'] > 0 ) {
                    M('User')->where(array('id'=>$user_id))->setDec('account');
                    $data['is_top'] = 1;
                    $data['top_expire'] = time() + 18000;  #有效期5小时
                } else {
                    $return_data['status'] = 'ERROR';
                    $return_data['info']   = '您的余额不足，不能完成置顶操作。';
                    $return_data['data']   = '';
                    $this->ajaxReturn($return_data);
                }
    		}
    		$data['updated'] = time();
    		$flag = M('news')->where(array('id'=>$id,'user_id'=>$user_id))->save($data);
    	}

    	if ($flag) {
    		if ($act == 'del') {
    			$html = "<a class='btn recover' href='javascript:;' rel='".$id."'>恢复</a>";
    			$info = "回收成功";
	    	} elseif ($act == 'recover' || $act == 'top') {
	    		$html = "<a class='btn edit' href='javascript:;' rel='".$id."'>编辑</a>";
    			$html .= "<a class='btn top' href='javascript:;' rel='".$id."'>置顶</a>";
    			$html .= "<a class='btn del' href='javascript:;' rel='".$id."'>删除</a>";
    			if ($act == 'recover') {
    				$do = "恢复";
    			} else {
    				$do = "置顶";
    			}
    			$info = $do."成功";
	    	}

	    	$return_data['status'] = 'OK';
	    	$return_data['info']   = $info;
	    	$return_data['data']['html']   = $html;
    	} else {
    		$return_data['status'] = 'ERROR';
    		$return_data['info']   = '服务器请求错误。';
	    	$return_data['data']   = '';
    	}
    	
    	$this->ajaxReturn($return_data);
    }

    function massage(){
        if(I('get.type',0)>0){
          $where['msg_type']=I('get.type');  
        }
        $where['delete_tag'] = 1;
        $user = $_SESSION['me']['email'];
        $where['LCU']=$user;
        $msg_list = M('msg')->where($where)->select();
        foreach ($msg_list as &$v) {
            if ($v['msg_type'] == 1) {
                $v['msg_types'] = '举报';
            }elseif ($v['msg_type'] == 2) {
                $v['msg_types'] = '收藏';
            }else{
                $v['msg_types'] = '管理员通知';
            }
        }
        $this->assign('msg_list',$msg_list);
        $this->display();
    }
}