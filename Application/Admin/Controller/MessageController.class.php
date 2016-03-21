<?php
namespace Admin\Controller;
use Think\Controller;
class MessageController extends CommonController {
	function lists(){
 		$limit = 15;
        $pageNum        = I('pageNum', 1);
        $orderField     = I('orderField', 'id');
        $orderDirection = I('orderDirection', 'desc');
        $numPerPage     = I('numPerPage', $limit);
        
        $offset = ($pageNum -1) * $limit;

		$totalCount  = M('msg')->where($where)->count('id');
        $message = M('msg')->where($where)->order($orderField.' '.$orderDirection)->limit($offset.','.$limit)->select();
        $page = array('pageNum'=>$pageNum, 'orderField'=>$orderField, 'orderDirection'=>$orderDirection, 'numPerPage'=>$numPerPage, 'totalCount'=>$totalCount);
        $this->assign('page', $page);

		
		foreach ($message as &$value) {
			if($value['delete_tag'] == 1){
				$value['delete_tag'] = "未删除";
			}elseif($value['delete_tag'] == -1){
				$value['delete_tag'] = "已删除";
			}
			if($value['read_status'] == 1){
				$value['read_status'] = "已读";
			}elseif($value['read_status'] == -1){
				$value['read_status'] = "未读";
			}
			if($value['msg_type'] == 1){
				$value['msg_type'] = "举报";
			}elseif($value['msg_type'] == 2){
				$value['msg_type'] = "收藏";
			}
			elseif($value['msg_type'] == 3){
				$value['msg_type'] = "管理员操作";
			}
		}
		$this->assign('msg_list',$message);
		$this->display();
	}
}
?>