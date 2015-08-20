<?php
namespace Home\Controller;
use Think\Controller;
class FormController extends Controller {
    public function index(){
    	$this->display();
    }

    public function handle(){
    	if (IS_POST) {
    		$data = array('name'=>I('name'),'mobile'=>I('mobile'),'email'=>I('email'),'company'=>I('company'),'position'=>I('position'), 'other'=>I('other'), 'timestamp'=>time());
    		M('application')->data($data)->add();
            echo json_encode(array("ok" => "1"));
    	} else {
            echo json_encode(array("ok" => "0"));
    	}
    }
}