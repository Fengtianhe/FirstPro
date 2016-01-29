<?php
namespace Common\Model;
use Think\Model;
class MailModel extends Model {

	protected $tableName = 'send_mail_log'; 

	function addSendLog($data) {
		$this->insert($data);
	}

	//function send($to, $subject, $body) {
	function send($to='215677230@qq.com') {
		/*import('Vendor.Phpmailer.Phpmailer');*/
		//include "/ThinkPHP/Library/Vendor/PHPMailer/class.phpmailer.php";
		$mail = new PHPMailer();
		var_dump($mail);
		/*$mail = new \Org\Util\PHPMailer;
		$mail->IsSMTP();
		$mail->CharSet='UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
		$mail->SMTPAuth = true; //开启认证
		$mail->Port = 25;
		$mail->Host = "smtp.qq.com";
		$mail->Username = "1977905246@qq.com";
		$mail->Password = "maying123";
		$mail->AddReplyTo("1977905246@qq.com","maying");//回复地址
		$mail->From = "1977905246@qq.com";
		$mail->FromName = "课外Online";
		$mail->AddAddress($to);
		$mail->Subject = "邮件测试";
		$mail->Body = "<h1>邮件测试</h1>这里是（<font color=red>www.kewai.online</font>）对phpmailer的测试内容";
		$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; //当邮件不支持html时备用显示，可以省略
		$mail->WordWrap = 80; // 设置每行字符串的长度
		$mail->IsHTML(true);
		$status = $mail->Send();
		var_dump($status);*/
	}
}