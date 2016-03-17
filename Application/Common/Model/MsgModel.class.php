<?php
namespace Common\Model;
use Think\Model;
class MsgModel extends Model{
	function sendReportMsg($data_info){
		$news_id = $data_info['news_id'];
		$news_info = M('news')->where(array('id'=>$news_id))->find();
		$msg_info['title'] = $news_info['title'];
		$LCU_id = $news_info['user_id'];
		$msg_info['reason'] = $data_info['mark_result'];
		$msg_info['content'] = '亲，你上架的商品【'.$msg_info['title'].'】被举报，请立即处理。如有疑问请联客服<a href="tencent://message/?uin=1977905246&Site=QQ交谈&Menu=yes" target="blank"><img border="0" src="http://wpa.qq.com/pa?p=1:1977905246:7" alt="联系QQ：1977905246" width="71" height="24" /></a>';
		$msg_info['send_date'] = time();
		$msg_info['FCU'] = $data_info['email'];
		$LCU_user = M('user')->where(array('id'=>$LCU_id))->find();
		$msg_info['LCU'] = $LCU_user['email']; 
		$msg_info['msg_type'] = 1;
		M('msg')->add($msg_info);
	}
}
?>