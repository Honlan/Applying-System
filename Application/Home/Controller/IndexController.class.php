<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
    	$this->wait = M('application')->where(array('admitted'=>2))->order('timestamp desc')->select();
    	$this->admit = M('application')->where(array('admitted'=>1))->order('timestamp desc')->select();
    	$this->refuse = M('application')->where(array('admitted'=>0))->order('timestamp desc')->select();
    	$this->emailSetting = M('email')->select()[0];
    	$this->display();
    }

    public function admit(){
    	$aid = I('aid');
    	$application = M('application')->where(array('id'=>$aid))->select()[0];
    	$email = $application['email'];
    	$info = M('email')->select()[0];
    	vendor("phpqrcode.phpqrcode");
    	$value = $application['id']."\n\n".$application['name']."\n\n".$application['mobile']."\n\n".$application['email']."\n\n".$application['company']."\n\n".$application['position'];
    	$key = '';
    	for ($i=0; $i < 10; $i++) { 
    		$key .= rand(0,9);
    	}
    	$picname = time().$key; 
    	$filename = 'Public/'.$picname.'.png'; 
    	$errorCorrectionLevel = "L"; 
    	$matrixPointSize = "6"; 
    	\QRcode::png($value, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
    	SendMail($email, $info['admitTitle'], $info['admitContent'].U('Index/qrcode',array('img'=>$picname),false,true));
    	M('application')->where(array('id'=>$aid))->save(array('admitted'=>1,'dealtime'=>time(),'qrcode'=>$picname));
    	$this->redirect('index');
    }

    public function refuse(){
    	$aid = I('aid');
    	M('application')->where(array('id'=>$aid))->save(array('admitted'=>0,'dealtime'=>time()));
    	$application = M('application')->where(array('id'=>$aid))->select()[0];
    	$info = M('email')->select()[0];
    	$email = $application['email'];
    	SendMail($email, $info['refuseTitle'], $refuse['refuseContent']);
    	$this->redirect('index');
    }

    public function resend(){
    	$aid = I('aid');
    	$application = M('application')->where(array('id'=>$aid))->select();
    	$application = $application[0];
    	$qrcode = $application['qrcode'];
    	$email = $application['email'];
    	$info = M('email')->select()[0];
    	SendMail($email, $info['admitTitle'], $info['admitContent'].U('Index/qrcode',array('img'=>$qrcode),false,true));
    	$this->redirect('index');
    }

    public function changePwd(){
    	$password = I('password');
    	M('user')->where(array('username'=>'admin'))->save(array('password'=>md5($password)));
    	$this->redirect('Login/logout');
    }

    public function addApplication(){
    	$data = array('name'=>I('name'),'mobile'=>I('mobile'),'email'=>I('email'),'company'=>I('company'),'position'=>I('position'),'timestamp'=>time(),'dealtime'=>time(),'admitted'=>1);
    	M('application')->data($data)->add();
    	$this->redirect('index');
    }

    public function editEmail(){
    	$data = array('admitTitle'=>I('admitTitle'), 'admitContent'=>I('admitContent'), 'refuseTitle'=>I('refuseTitle'), 'refuseContent'=>I('refuseContent'));
    	M('email')->where(array('id'=>1))->save($data);
    	$this->redirect('index');
    }

    public function qrcode(){
    	$this->img = I('img');
    	$this->display();
    }
}