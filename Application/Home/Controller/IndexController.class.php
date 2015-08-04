<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
    	$this->wait = M('application')->where(array('admitted'=>2))->order('timestamp desc')->select();
    	$this->admit = M('application')->where(array('admitted'=>1))->order('timestamp desc')->select();
    	$this->refuse = M('application')->where(array('admitted'=>0))->order('timestamp desc')->select();
    	$this->display();
    }

    public function admit(){
    	$aid = I('aid');
    	M('application')->where(array('id'=>$aid))->save(array('admitted'=>1,'dealtime'=>time()));
    	$email = M('application')->where(array('id'=>$aid))->field('email')->select();
    	$email = $email[0]['email'];
    	# 发送邮件
    	SendMail($email, '测试', '测试内容');
    	$this->redirect('Index/index');
    }

    public function refuse(){
    	$aid = I('aid');
    	M('application')->where(array('id'=>$aid))->save(array('admitted'=>0,'dealtime'=>time()));
    	# 发送邮件
    	$this->redirect('Index/index');
    }

    public function changePwd(){
    	$password = I('password');
    	M('user')->where(array('username'=>'admin'))->save(array('password'=>md5($password)));
    	$this->redirect('Login/logout');
    }

    public function addApplication(){
    	$data = array('name'=>I('name'),'mobile'=>I('mobile'),'email'=>I('email'),'company'=>I('company'),'position'=>I('position'),'timestamp'=>time(),'dealtime'=>time(),'admitted'=>1);
    	M('application')->data($data)->add();
    	$this->redirect('Index/index');
    }

    public function test(){
    	echo 'test';
    	// SendMail('zhanghonglun@sjtu.edu.cn','测试','测试内容');

    	vendor("phpqrcode.phpqrcode");
    	$value="http://www.jb51.net";
    	$filename = 'Public/1111.png'; 
    	$errorCorrectionLevel = "L"; 
    	$matrixPointSize = "4"; 
    	\QRcode::png($value, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
    }
}