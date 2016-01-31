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
		$html = '
		<div style="margin:0 auto; width:710px; border:1px solid #e4e3e3; background:#fff; padding:25px 35px 25px 35px;">
		    <h3 style="font-size:14px; font-weight:bold; margin:0; padding:0; padding-top:20px">亲爱的'.$user_info['email'].'用户，您好！</h3>
		    <p style="margin:0; padding:0; font-size:12px; margin-top:10px">感谢您注册课外Online，请验证邮箱以更好地使用我们的产品,若不是您本人操作请直接忽略本条邮件。</p>
		    <div style=" background:#eef8ff; border:1px solid #cee4f6; padding:25px; margin-top:25px;word-break:break-all;width: 650px;">
		        <h3 style="font-size:14px; font-weight:bold; margin:0; padding:0; color:#333; margin-bottom:10px">请在48小时内点击下面的链接以完成验证：</h3>
		        <a target="_blank" href="'.$user_info['verify_url'].'" style="font-size:12px; line-height:18px; color:#4b85b5;">'.$user_info['verify_url'].'</a>
		        <p style="margin:0; padding:0; font-size:12px; color:#666; margin-top:5px">如果您无法点击，请将链接复制到浏览器地址栏访问。</p>
		    </div>
		</div>';
		return $html;
	}

	/**
	 * 发送用户验证邮件
	 * @param  array 用户信息
	 * @return array array('status'=>'Ok','message'=>发送成功)
	 */
	function sendUserRegistVerifyMail ($user_info) {
		$code = 'email='.$user_info['email'].'&id='.$user_info['id'].'&token='.$user_info['token'];
		$user_info['verify_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/editor/user/email_verify?code='.base64_encode($code);
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