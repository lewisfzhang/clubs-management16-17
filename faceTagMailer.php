<?php

	set_time_limit(120); //Set script execution time limit to 2 minutes
	$key = 'C5kf72Ka3yU0'; //Encryption key for unsubscribe link hashing

	//PHPMailer using local PHP SMTP server
	include'PHPMailer/PHPMailerAutoload.php';
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host = 'localhost';
	$mail->Port = 25;

	//Get user data from cookies
	$clubid = $_POST['clubid'];
	$clubname = $_POST['clubname'];

	//MYSQL connection
	$servername = 'localhost';
	$username = 'clubs_u3er';
	$password = 'tCpw6uTKZj3faqPT';
	$dbname = 'clubs';
	$con=mysqli_connect($servername, $username, $password, $dbname);
	if (mysqli_connect_errno()) { exit('Failed to connect to MySQL database: ' . mysqli_connect_error()); }

	//Get data from form
	$subject = 'Photo for ' . $clubname;
	//$body = htmlspecialchars($_POST['message']);
	$link = 'http://times.bcp.org/clubs/photoStatus.php?clubid=' . $clubid;
	$body = 'Dear ' . $clubname . ' members, <br><br>Your club photo has been uploaded! Please click the link 
	below to view the photo and tag yourself and your fellow members. The tags are necessary in order for the 
	photo to make it to the yearbook! <br><br>' . '<a href="'.$link.'">Click to start tagging</a>';
	$replyall = false;

	//Handle additional recipients
	$ccset = 0;
	if(isset($_POST['CC'])) {
		$cc = trim(htmlspecialchars($_POST['CC']));
		if($cc == "") {
			$ccset = 0;
		} else {
			$ccset = 1;
			$ccarray = explode(';', $cc);
		}
	}

	//Set initial mail headers
	$mail->From = 'carillon@bcp.org';
	$mail->FromName = 'The Carillon Yearbook';
	$mail->AddBCC('clubmailer@bcp.org');
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->IsHTML(true);

/*	
	$sql = "SELECT `users.email`
			FROM `users`
			INNER JOIN `memberships`
			ON `memberships.userid`=`users.id`
			WHERE `memberships.clubid`='$clubid' AND `memberships.isDeleted`='0'";*/

	//Get list of emails from club id
	$sql = "SELECT `userid` FROM `memberships` WHERE `clubid`='$clubid' AND `isDeleted`=0";
	$result = mysqli_query($con,$sql);
	$recipientarray = array();
	while($row = mysqli_fetch_assoc($result)) {
		$tempuserid = $row["userid"];
		$sql2 = "SELECT `email` from `users` WHERE `id`='$tempuserid'";	
		$result2 = mysqli_query($con,$sql2);		
    	$recipientarray[] = mysqli_fetch_assoc($result2)["email"];
	}

	//Send mail in reply-all mode, in one big email
	if ($replyall) {
		foreach ($recipientarray as $recipient) {
			$mail->AddAddress($recipient);
		}
		if ($ccset) {
			foreach ($ccarray as $cecipient) {
				$mail->AddCC($recipient);
			}
		}

		//$unsubscribe = "http://times.bcp.org/clubs/unsubscribe.php&mid=$clubid";
		//$mail->Body = $body . "<br><br>Click <a href=\"$unsubscribe\">here</a> to remove yourself from the $clubname.";
		
		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo . '<br>';
		} else {
			echo 'All messages have been sent.';
			//$mail->Body = $body; //Remove unsubscribe link
		}
	//Send mail in individualized mode, where all recipients get their own email
	} else {
		foreach ($recipientarray as $recipient) {
			$mail->AddAddress($recipient);
			echo($recipient);
			$hash = crypt($recipient, $key);
			$unsubscribe = "http://times.bcp.org/clubs/unsubscribe.php?email=$recipient&hash=$hash&mid=$clubid";
			$mail->Body = $body . "<br><br>This email was sent to all members of: $clubname, from the official Bellarmine Clubs Web Application. Click <a href=\"$unsubscribe\">here</a> to remove yourself from this club. Please <a href=\"mailto:blindemann@bcp.org?cc=clubmailer@bcp.org,chanan.walia16@bcp.org,rohan.menezes16@bcp.org,amit.mondal16@bcp.org&Subject=Club%20Concern\">email Brad Lindemann</a> if you have any issues, concerns, or suggestions.";
			if(!$mail->send()) {
				echo "Message could not be sent to $recipient<br>";
				echo 'Mailer Error: ' . $mail->ErrorInfo . '<br>';
			} else {
				echo "Message has been sent to $recipient<br>";
			}
			$mail->ClearAddresses(); //Remove addresses
			$mail->Body = $body; //Remove unsubscribe link
		}
		if ($ccset) {
			foreach ($ccarray as $recipient) {
				$mail->AddAddress($recipient);
				if(!$mail->send()) {
					echo "Message could not be sent to $recipient<br>";
					echo 'Mailer Error: ' . $mail->ErrorInfo . '<br>';
				} else {
					echo "Message has been sent to $recipient<br>";
				}
				$mail->ClearAddresses();
			}
		}
	}

?>