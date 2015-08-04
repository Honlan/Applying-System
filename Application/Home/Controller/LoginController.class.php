<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
    	$this->display();
    }

    public  function handle(){
    	if (IS_POST) {
    		$username = $_POST['username'];
    		$password = $_POST['password'];
    		$count = M('user')->where(array('username'=>$username,'password'=>md5($password)))->count(); 
    		if ($count == 1) {
    			session('username', $username);
    			$this->redirect('Index/index');
    		} else {
    			$this->redirect('Login/index');
    		} 
    	} else {
    		$this->redirect('Login/index');
    	}
    }

    public function logout(){
    	session('username', null);
    	$this->redirect('Login/index');
    }
}