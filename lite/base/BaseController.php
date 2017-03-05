<?php
namespace base;
use comment\smtp;
use core\Controller;

/**
 * 父类控制器
 * Created by PhpStorm.
 * User: rihuizhang
 * Date: 17-2-11
 * Time: 下午10:13
 */
class BaseController extends Controller  {
    /**
     * 控制器默认的方法
     */
    public function IndexAction(){
        echo "这里是父类控制器BaseController的index方法。\r\n";
        echo "如果你看到了这句话，请检查你的控制器代码是否没有重写index方法且命令行没有输入actionName\r\n";
        die;
    }

    /**
     *发送邮件
     *@param string $title 邮件主题
     *@param string $content 邮件内容
     *@param string $addressee 收件人
     *@return bool 是否成功发送
     */
    public function sendEmail($title,$content,$addressee='845830229@qq.com'){
        $smtpserver = "smtp.qq.com";		//邮箱服务器
        $smtpserverport = 465;				//邮箱服务器端口
        $smtpusermail = "845830229@qq.com";//你的服务器邮箱账号
        $smtpuser = "845830229@qq.com";			//SMTP服务器的用户帐号
        $smtppass = "drwmzea12345"; 		//SMTP服务器的用户密码
        $mailtype = "HTML";					//邮件格式（HTML/TXT）,TXT为文本邮件
        //这里面的一个true是表示使用身份验证,否则不使用身份验证.
        $smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);
        //是否显示发送的调试信息
        $smtp->debug = true;
        //发送邮件
        return $smtp->sendmail($addressee, $smtpusermail, $title, $content, $mailtype);
    }
}