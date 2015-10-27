<?php
namespace Editor\Controller;
use Editor\Controller;
class IndexController extends CommonController {
	public function _initialize(){
		parent::_initialize();
	}
    public function info(){
    	echo "this is info";
        $this->display();
    }

    public function addNew(){
        $this->display();
    }
}