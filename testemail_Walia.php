


<?php

/*    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "chanan.walia16@bcp.org";
    $to = "chanan.walia16@bcp.org";
    $subject = "PHP Mail Test script";
    $message = "This is a test to check the PHP Mail functionality";
    $headers = "From:" . $from;
    mail($to,$subject,$message, $headers);
    echo "Test email sent";*/

	require 'PHPMailer/PHPMailerAutoload.php';
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host = 'localhost';
	//$mail->Host = 'smail.bcp.org';
	//$mail->SMTPAuth = true;                               // Enable SMTP authentication
	//$mail->Username = 'clubmailer@bcp.org';                 // SMTP username
	//$mail->Password = 'BCP3m@1l!';                           // SMTP password
	//$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 25;                                    // TCP port to connect to
	//$mail->Port = 587;                                    // TCP port to connect to
	$mail->From = 'clubmailer@bcp.org';
	$mail->FromName = 'Rohan Menezes from Test Club';
	$mail->addAddress("chanan.walia16@bcp.org");
	$mail->AddBCC("clubmailer@bcp.org");
	$mail->Subject = 'Your Carillon Senior Quotation was Approved!';
	$mail->Body = 'Hi Dorian Chan,<br><br>
	Good news, your senior quotation has been approved! Your final quotation is below. If something looks wrong, please reply directly to this email:<br><br>
	Your quotation: <br><br>
	Thanks again,<br>
	The Carillon Staff';
	$mail->isHTML(true);     
	if(!$mail->send()) {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		echo 'Message has been sent';
	}
?>