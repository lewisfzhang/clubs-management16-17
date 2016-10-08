<?php
	function clean($string) {
	   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	   return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
	}
	$data = $_POST['imgData'];
	$name = $_POST['firstname'] . ' ' . $_POST['lastname'];
	$clubid = $_POST['clubid'];
	$clubname = $_POST['clubname'];
	$fullname = $_POST['fullname'];
	$senderAddress = 'carillon@bcp.org';//$_COOKIE['studentemail'];
	//$clubname = $_COOKIE['clubname'];
	$recipient = $_POST['email'];
	$uri =  substr($data,strpos($data,",")+1);
	require 'PHPMailer/PHPMailerAutoload.php';
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host = 'localhost';
	$mail->Port = 25;

	$mail->From = $senderAddress;
	$mail->FromName = 'Carillon';
	$mail->addAddress($recipient, $name);

	//$mail->addAttachment('photos/tempFile.png');
	$resource = base64_decode($uri);
	$mail->addStringAttachment($resource, clean($name) . "_" . clean($clubname) . ".png", "base64", "image/png");

	$mail->isHTML(true);

	$array = array('studname'=>$fullname, 'clubid'=>$clubid, 'clubname'=>$clubname);
	$removeurl = 'http://times.bcp.org/clubs/faceTaggingData.php?' . http_build_query($array);
	$tagurl = 'http://times.bcp.org/clubs/photoStatus.php?clubid=' . $clubid;
	$mail->Subject = 'Tagged in club photo for '.$clubname;
	$mail->Body = "Dear ".$name.",<br><br>You've been tagged in the official club photo for " . $clubname . "! If you are not the person in the attached photo, please click " . 
	'<a href = "'.$removeurl.'">here</a> to remove the incorrect tags from the club photo.<br>Click' . 
	' <a href = "'.$tagurl.'">here</a> to see your club photo and tag your friends.';
	$mail->AltBody = "Is this you? Please check the photo attached";
	if(!$mail->send()) {
	    echo "Mailer Error: " . $mail->ErrorInfo;
	} 
	else {
	    echo "Message has been sent successfully";
	}
?>