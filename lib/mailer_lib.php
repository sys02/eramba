<?

require_once 'class.phpmailer.php';

function calendar_item_mail() {

	$mail = new PHPMailer();
	$mail->IsSendmail();
	$mail->SetFrom('test@eramba.com', 'Esteban Ribicic');
	$mail->AddReplyTo('replyto@example.com','First Last');
	$mail->AddAddress('kisero@gmail.com', 'Esteban Ribicic');
	$mail->Subject = 'PHPMailer sendmail test';
	$mail->MsgHTML(file_get_contents('contents.html'), dirname(__FILE__));
	$mail->AltBody = 'This is a plain-text message body';
	
	//Send the message, check for errors
	if(!$mail->Send()) {
		echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
		echo "Message sent!";
	}

}

?>
