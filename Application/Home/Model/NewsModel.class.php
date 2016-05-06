<?php
namespace Home\Model;
use Think\Model;
class NewsModel extends Model {

	//显示浏览量 暂时使用数据库存储 TODO 以后如需要可使用redis记录
	function showNum($new_id,$is_add=true)
	{
		if($is_add)
		{
			$this->where(array('id'=>$new_id))->setInc('show_count');
		}
		return $this->where(array('id'=>$new_id))->getField('show_count');
	}
}