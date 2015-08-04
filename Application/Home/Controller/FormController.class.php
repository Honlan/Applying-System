<?php
namespace Home\Controller;
use Think\Controller;
class FormController extends Controller {
    public function index(){
    	$this->display();
    }

    public function handle(){
    	if (IS_POST) {
    		$data = array('name'=>I('name'),'phone'=>I('mobile'),'email'=>I('email'),'company'=>I('company'),'position'=>I('position'));
    		print_r($data);
    		M('application')->data($data)->add();
    		echo "报名成功！";
    	} else {
    		$this->redirect('Form/index');
    	}
    }
}