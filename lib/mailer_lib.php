<?

require_once('class.phpmailer.php');
require_once('configuration.inc');


function calendar_item_mail($what,$section,$subsection,$item,$destination_email) {

	# if no emails want to be sent return quietkly
	if (empty($mail_conf['send_emails'])) {
		return  "Configuration asks not to send emails";
	}

	# before sending emails .. did i send emails today?
	# i need to store this information on the database
	

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

	# now i update the template with the information i want
	$message = file_get_contents("lib/mail_templates/calendar_reminder.html");
	$message = str_replace('%what%', $what, $message);

	$mail->MsgHTML($message);
	#$mail->AltBody(strip_tags($message));
	
	//Send the message, check for errors
	if(!$mail->Send()) {
		return "Mailer Error: " . $mail->ErrorInfo;
	} else {
		return;
	}

}

?>
