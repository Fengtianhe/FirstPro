<?php
function gatAreaData()
{
	$province = M('Province')->select();
    $city     = M('city')->select();
	foreach ($province as $key=>$value) {
		$area_tree[$value['provinceid']] = $value;
	}

	foreach ($city as $key => $value) {
		$area_tree[$value['fatherid']]['child'][$value['cityid']] = $value; 
	}

	return $area_tree;
}

function gatA()
{
	$province = M('Province')->select();
	return $province;
}

?>