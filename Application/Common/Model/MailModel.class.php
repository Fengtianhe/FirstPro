<?php
namespace Common\Model;
use Think\Model;
class MailModel extends Model {

	protected $tableName = 'send_mail_log'; 

	/**
	 * 记录发送日志
	 * @param array 插入数据
	 */
	function addSendLog($data) {
		return $this->add($data);
	}

	/** 
	 * 发送邮件
	 * @param  string 收件人地址
	 * @param  string 主题
	 * @param  string 内容
	 * @param  string 标志
	 * @return bool
	 */
	function send($to, $subject, $body, $flag='login') {
		//引入类库
		Vendor('PHPMailer.PHPMailerAutoload');
		$mail = new \PHPMailer;
		
		//配置参数
		$mail->IsSMTP();
		$mail->CharSet  =C('EMAIL.EMAIL_CHARSET');
        $mail->SMTPAuth = true; //开启认证
        $mail->Port     = C('EMAIL.EMAIL_PORT');
        $mail->Host     = C('EMAIL.EMAIL_HOST');
        $mail->Username = C('EMAIL.EMAIL_USERNAME');
        $mail->Password = C('EMAIL.EMAIL_PASSWORD');
        $mail->AddReplyTo(C('EMAIL.EMAIL_REPLAYTO'),C('EMAIL.EMAIL_REPLAYNAME'));
        $mail->From     = C('EMAIL.EMAIL_FROM');
        $mail->FromName = C('EMAIL.EMAIL_FROMNAME');
		$mail->AddAddress($to);
		$mail->Subject  = $subject;
		$mail->Body     = $body;
		$mail->AltBody  = "To view the message, please use an HTML compatible email viewer!"; //当邮件不支持html时备用显示，可以省略
		$mail->WordWrap = 80; // 设置每行字符串的长度
		$mail->IsHTML(true);
		$status = $mail->Send();

		//记录发送log
		$time = time();
		$data['from']      = C('EMAIL.EMAIL_FROM');
		$data['from_name'] = C('EMAIL.EMAIL_FROMNAME');
		$data['subject']   = $subject;
		$data['to']        = $to;
		$data['status']    = -1;
		$data['flag']      = $flag;
		$data['created']   = $time;
		if ($status) {
			$data['send_time'] = $time;
			$data['status'] = 1;
		}
		$this->addSendLog($data);
		
		return $status;
	}

	/**
	 * 获取用户验证邮件内容
	 * @param  array 用户信息
	 * @return string html文本
 	 */
	function getUserRegistMailHtml ($user_info) {
		$html = '<h1>邮件测试</h1>这里是（<font color=red>www.kewai.online</font>）对phpmailer的测试内容';
		return $html;
	}

	/**
	 * 发送用户验证邮件
	 * @param  array 用户信息
	 * @return array array('status'=>'Ok','message'=>发送成功)
	 */
	function sendUserRegistVerifyMail ($user_info) {
		$subject = '课外Online验证邮件';
		$body    = $this->getUserRegistMailHtml($user_info);
		$status  = $this->send($user_info['email'], $subject, $body);
		if ($status) {
			$result['status'] = 'OK';
			$result['message'] = '发送成功';
		} else {
			$result['status'] = "ERROR";
			$result['message'] = '发送失败';
		}
		return $result;
	}
}