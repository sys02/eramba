<?

require_once('class.phpmailer.php');
require_once('configuration.inc');


function calendar_item_mail($destination_email) {

	global $mail_conf;

	$mail = new PHPMailer();

	if ($mail_conf['smtp_server']) {
		# echo "Debug: sending emails using smtp";
		$mail->IsSMTP();
		$mail->Host = $mail_conf['smtp_server'];
		$mail->Port= $mail_conf['smtp_server'];

		if ($mail_conf['smtp_username'] && $mail_conf['smtp_password']) {
			$mail->SMTPAuth = "true";
			$mail->Username = $mail_conf['smtp_username'];
			$mail->Password = $mail_conf['smtp_password'];
		} else {
			$mail->SMTPAuth = NULL;
		}
	} else {	
		# echo "Debug: sending emails using sendmail";
		$mail->IsSendmail();
	} 

	if (!$mail_conf['mail_source_address']) {
		return "error no source mail defined in the configuration";
	}
	$mail->SetFrom($mail_conf['mail_source_address'], $mail_conf['mail_source_name']);
	$mail->AddReplyTo($mail_conf['mail_source_address'],$mail_conf['mail_source_name']);

	if (!$destination_email){
		return "error no destination mail defined in the configuration";
	}
	$mail->AddAddress($destination_email);
	$mail->Subject = 'An item in the calendar needs your attention';

	echo "".dirname(__FILE__)."";

	$mail->MsgHTML(file_get_contents('calendar_reminder.html'),dirname(__FILE__));
	#$mail->AltBody = 'This is a plain-text message body';
	
	//Send the message, check for errors
	if(!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Message sent!";
	}

}

?>
