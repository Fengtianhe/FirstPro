<?php
namespace Editor\Model;
use Think\Model;
class NewsModel extends Model {

	public function checkEnableAdd($user_info){
		$result = array('status'=>'OK', 'error_type'=>'0');
		if (!$user_info['school_id']) {
			$result = array('status'=>'ERROR', 'error_type'=>'1');
		}

		//异常用户
		if ($user_info['status'] < 0) {
			$result = array('status'=>'ERROR', 'error_type'=>'2');
		}
		return $result;
	}
}