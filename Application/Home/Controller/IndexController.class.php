<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type: text/html; charset=utf-8");
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
        $admitContent = $info['admitContent'];
        if(count(explode("\n", $admitContent)) == 1 ){
            $admitContent = explode("\r", $admitContent);
        } else {
            $admitContent = explode("\n", $admitContent);
        }
        $temp = '';
        foreach ($admitContent as $key => $value) {
            $temp .= $value."<br/>";
        }
        $admitContent = $temp;
    	vendor("phpqrcode.phpqrcode");
    	$value = $application['id']."\n\n".$application['name']."\n\n".$application['mobile']."\n\n".$application['email']."\n\n".$application['company']."\n\n".$application['position'];
    	$key = '';
    	for ($i=0; $i < 10; $i++) { 
    		$key .= rand(0,9);
    	}
    	$picname = time().$key; 
    	$filename = 'Public/img/'.$picname.'.png'; 
    	$errorCorrectionLevel = "L"; 
    	$matrixPointSize = "6"; 
    	\QRcode::png($value, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
        $admitContent .= U('Index/qrcode',array('img'=>$picname),false,true);
    	SendMail($email, $info['admitTitle'], $admitContent);
    	M('application')->where(array('id'=>$aid))->save(array('admitted'=>1,'dealtime'=>time(),'qrcode'=>$picname));
    	$this->redirect('index');
    }

    public function refuse(){
    	$aid = I('aid');
    	M('application')->where(array('id'=>$aid))->save(array('admitted'=>0,'dealtime'=>time()));
    	$application = M('application')->where(array('id'=>$aid))->select()[0];
    	$info = M('email')->select()[0];
        $refuseContent = $info['refuseContent'];
        if(count(explode("\n", $refuseContent)) == 1 ){
            $refuseContent = explode("\r", $refuseContent);
        } else {
            $refuseContent = explode("\n", $refuseContent);
        }
        $temp = '';
        foreach ($refuseContent as $key => $value) {
            $temp .= $value."<br/>";
        }
        $refuseContent = $temp;
    	$email = $application['email'];
    	SendMail($email, $info['refuseTitle'], $refuseContent);
    	$this->redirect('index');
    }

    public function resend(){
    	$aid = I('aid');
    	$application = M('application')->where(array('id'=>$aid))->select();
    	$application = $application[0];
    	$qrcode = $application['qrcode'];
    	$email = $application['email'];
    	$info = M('email')->select()[0];
        $admitContent = $info['admitContent'];
        if(count(explode("\n", $admitContent)) == 1 ){
            $admitContent = explode("\r", $admitContent);
        } else {
            $admitContent = explode("\n", $admitContent);
        }
        $temp = '';
        foreach ($admitContent as $key => $value) {
            $temp .= $value."<br/>";
        }
        $admitContent = $temp;
        $admitContent .= U('Index/qrcode',array('img'=>$qrcode),false,true);
    	SendMail($email, $info['admitTitle'], $admitContent);
    	$this->redirect('index');
    }

    public function changePwd(){
    	$password = I('password');
    	M('user')->where(array('username'=>'admin'))->save(array('password'=>md5($password)));
    	$this->redirect('Login/logout');
    }

    public function addApplication(){
        $timestamp = time();
    	$data = array('name'=>I('name'),'mobile'=>I('mobile'),'email'=>I('email'),'company'=>I('company'),'position'=>I('position'),'timestamp'=>$timestamp,'dealtime'=>$timestamp,'admitted'=>1);
    	M('application')->data($data)->add();
        $application = M('application')->where(array('name'=>I('name'),'mobile'=>I('mobile'),'email'=>I('email'),'company'=>I('company'),'position'=>I('position'),'timestamp'=>$timestamp,'dealtime'=>$timestamp,'admitted'=>1))->select()[0];
        $email = $application['email'];
        $info = M('email')->select()[0];
        $admitContent = $info['admitContent'];
        if(count(explode("\n", $admitContent)) == 1 ){
            $admitContent = explode("\r", $admitContent);
        } else {
            $admitContent = explode("\n", $admitContent);
        }
        $temp = '';
        foreach ($admitContent as $key => $value) {
            $temp .= $value."<br/>";
        }
        $admitContent = $temp;
        vendor("phpqrcode.phpqrcode");
        $value = $application['id']."\n\n".$application['name']."\n\n".$application['mobile']."\n\n".$application['email']."\n\n".$application['company']."\n\n".$application['position'];
        $key = '';
        for ($i=0; $i < 10; $i++) { 
            $key .= rand(0,9);
        }
        $picname = time().$key; 
        $filename = 'Public/img/'.$picname.'.png'; 
        $errorCorrectionLevel = "L"; 
        $matrixPointSize = "6"; 
        \QRcode::png($value, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
        $admitContent .= U('Index/qrcode',array('img'=>$picname),false,true);
        SendMail($email, $info['admitTitle'], $admitContent);
        M('application')->where(array('id'=>$application['id']))->save(array('qrcode'=>$picname));
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

    public function exportExcel(){
        $xlsName = "user";
        $xlsCell = array(
            array('id','序号'),
            array('name','姓名'),
            array('mobile','手机'),
            array('email','邮箱'),
            array('company','公司'),
            array('position','职位'),
            array('other','备注'),
            array('timestamp','申请时间')); 
        $xlsData = M('application')->where(array('admitted'=>1))->field('id,name,mobile,email,company,position,other,timestamp')->order('timestamp desc')->select();

        $xlsTitle = iconv('utf-8', 'gb2312', $xlsName);//文件名称
        $fileName = date('YmdHis').'_passed';//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($xlsCell);
        $dataNum = count($xlsData);
        vendor("PHPExcel.PHPExcel");
       
        $objPHPExcel = new \PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        
        for($i = 0; $i < $cellNum; $i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'1', $xlsCell[$i][1]); 
        } 
          // Miscellaneous glyphs, UTF-8   
        for($i = 0; $i < $dataNum; $i++){
            for($j = 0; $j < $cellNum; $j++){
                if ($j == 7) {
                    $xlsData[$i][$xlsCell[$j][0]] = date('Y-m-d H:i:s', $xlsData[$i][$xlsCell[$j][0]]);  
                }
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), $xlsData[$i][$xlsCell[$j][0]]);
            }             
        }  
        
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output'); 
        exit; 
    }

    public function exportExcelWait(){
        $xlsName = "user";
        $xlsCell = array(
            array('id','序号'),
            array('name','姓名'),
            array('mobile','手机'),
            array('email','邮箱'),
            array('company','公司'),
            array('position','职位'),
            array('other','备注'),
            array('timestamp','申请时间')); 
        $xlsData = M('application')->where(array('admitted'=>2))->field('id,name,mobile,email,company,position,other,timestamp')->order('timestamp desc')->select();

        $xlsTitle = iconv('utf-8', 'gb2312', $xlsName);//文件名称
        $fileName = date('YmdHis').'_waiting';//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($xlsCell);
        $dataNum = count($xlsData);
        vendor("PHPExcel.PHPExcel");
       
        $objPHPExcel = new \PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        
        for($i = 0; $i < $cellNum; $i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'1', $xlsCell[$i][1]); 
        } 
          // Miscellaneous glyphs, UTF-8   
        for($i = 0; $i < $dataNum; $i++){
            for($j = 0; $j < $cellNum; $j++){
                if ($j == 7) {
                    $xlsData[$i][$xlsCell[$j][0]] = date('Y-m-d H:i:s', $xlsData[$i][$xlsCell[$j][0]]);  
                }
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), $xlsData[$i][$xlsCell[$j][0]]);
            }             
        }  
        
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output'); 
        exit; 
    }

    public function exportCsv(){
        $data = M('application')->where(array('admitted'=>1))->field('id,name,mobile,email,company,position,other,timestamp')->order('timestamp desc')->select();
        $str = "序号,姓名,手机,邮箱,公司,职位,备注,申请时间\n";
        $str = iconv('utf-8', 'gb2312', $str);
        foreach ($data as $key => $value) {
            $str .= iconv('utf-8', 'gb2312', $value['id']).",".iconv('utf-8', 'gb2312', $value['name']).",".iconv('utf-8', 'gb2312', $value['mobile']).",".iconv('utf-8', 'gb2312', $value['email']).",".iconv('utf-8', 'gb2312', $value['company']).",".iconv('utf-8', 'gb2312', $value['position']).",".iconv('utf-8', 'gb2312', $value['other']).",".date('Y-m-d H:i:s',iconv('utf-8', 'gb2312', $value['timestamp']))."\n";
        }
        $filename = date('YmdHis').'_passed.csv';
        header("Content-type:text/csv");   
        header("Content-Disposition:attachment;filename=".$filename);   
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');   
        header('Expires:0');   
        header('Pragma:public');
        echo $str;
    }

    public function exportCsvWait(){
        $data = M('application')->where(array('admitted'=>2))->field('id,name,mobile,email,company,position,other,timestamp')->order('timestamp desc')->select();
        $str = "序号,姓名,手机,邮箱,公司,职位,备注,申请时间\n";
        $str = iconv('utf-8', 'gb2312', $str);
        foreach ($data as $key => $value) {
            $str .= iconv('utf-8', 'gb2312', $value['id']).",".iconv('utf-8', 'gb2312', $value['name']).",".iconv('utf-8', 'gb2312', $value['mobile']).",".iconv('utf-8', 'gb2312', $value['email']).",".iconv('utf-8', 'gb2312', $value['company']).",".iconv('utf-8', 'gb2312', $value['position']).",".iconv('utf-8', 'gb2312', $value['other']).",".date('Y-m-d H:i:s',iconv('utf-8', 'gb2312', $value['timestamp']))."\n";
        }
        $filename = date('YmdHis').'_waiting.csv';
        header("Content-type:text/csv");   
        header("Content-Disposition:attachment;filename=".$filename);   
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');   
        header('Expires:0');   
        header('Pragma:public');
        echo $str;
    }

    public function delete(){
        $id = I('aid');
        M('application')->where(array('id'=>$id))->delete();
        $this->redirect('index');
    }
}