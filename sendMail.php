<?php
	$servername = "localhost";
	$username = "clubs_u3er";
	$password = "tCpw6uTKZj3faqPT";
	$dbname = "clubs";

	$con=mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (mysqli_connect_errno())
 	{
 		echo "Failed to connect to MySQL: " . mysqli_connect_error();
  	}
  	
	$clubid = $_COOKIE['clubid'];
	$clubname = $_COOKIE['clubname'];
	$studentname = $_COOKIE['studentname'];
	$studentid = $_COOKIE['studentid'];
	$ccset = 0;
	$cc = "";
	if(isset($_POST['CC']))
	{
		$cc = htmlspecialchars($_POST['CC']);
		//$cc = mysqli_real_escape_string($con, $cc);
		if($cc == "")
		{
			$ccset = 0;
		}
		else
		{
			$ccset = 1;
		}
	}
	$subject = htmlspecialchars($_POST['subject']);
	$message = nl2br(htmlspecialchars($_POST['message']));
	$replyAll = 0;
	if(isset($_POST['replyall']))
	{
		$replyAll = 1;
	}
	echo $replyAll;
	
	//$subject = mysqli_real_escape_string($con, $subject);
	//$message = mysqli_real_escape_string($con, $message);

  	$sql = "SELECT `userid`,`isLeader`,`isDeleted` FROM memberships WHERE `clubid`='$clubid'";
  	$result = mysqli_query($con,$sql);
  	
  	$leaderemail = "";
  	$leadername = "";  
  	
if($replyAll == 1)
{
  	require 'PHPMailer/PHPMailerAutoload.php';
	$mail = new PHPMailer(true);
	$mail->IsSMTP();
	$mail->SMTPAuth = true; // enable SMTP authentication
    $mail->SMTPSecure = "tls";//"ssl"; // sets the prefix to the servier
    $mail->Host = "smail.bcp.org"; // sets GMAIL as the SMTP server
    $mail->Port = 587; // set the SMTP port for the GMAIL server
    $mail->Username = "clubmailer@bcp.org"; // GMAIL username
    $mail->FromName = 'clubmailer';
    $mail->Password = "BCP3m@1l!"; // GMAIL password 
  	if (mysqli_num_rows($result) > 0) {
    	while($row = mysqli_fetch_assoc($result)) {
    		$studentidtemp = $row["userid"];
    		$isLeader = $row["isLeader"];
    		$isDeleted = $row["isDeleted"];
			$sql2 = "SELECT `email`,`firstname`,`lastname` FROM users WHERE `id`='$studentidtemp'";
			$result2 = mysqli_query($con,$sql2);
			if (mysqli_num_rows($result2) > 0) {
    			while($row2 = mysqli_fetch_assoc($result2)) {
    				if($isDeleted == 0)
    				{
    					$address = $row2["email"];
    					$mail->addAddress("$address");
    				}
    			}
    		}
    	}
    }
    $sql = "SELECT `email` FROM users WHERE `id`='$studentid'";
  	$result = mysqli_query($con,$sql);
  	$studentemail = "";
  	if (mysqli_num_rows($result) > 0) {
    	while($row = mysqli_fetch_assoc($result)) {
    		$studentemail = $row["email"];
    	}
    }
    $mail->AddReplyTo("$studentemail");
    //$mail->SetFrom("clubmailer");
	//$mail->SetFrom("$studentemail");
	$mail->From = 'clubmailer@bcp.org';
	$mail->FromName = 'clubmailer';
	$fromname = $studentname. " from ". $clubname;
	$mail->FromName = $fromname;
	$mail->Subject = $subject;
	$mail->Body = $message;
	if($ccset == 1)
	{
		$ccarray = explode(';', $cc);
		for($i = 0; $i < count($ccarray); $i++)
		{
			$ccaddress = $ccarray[$i];
			$mail->AddAddress("$ccaddress");
		}
	}
	$mail->isHTML(true); 
	if(!$mail->send()) {
		header("Location: http://times.bcp.org/clubs/email.php?state=2");
	} else {
		header("Location: http://times.bcp.org/clubs/email.php?state=1");
	}
}
else
{
	if (mysqli_num_rows($result) > 0) {
    	while($row = mysqli_fetch_assoc($result)) {
    		$studentidtemp = $row["userid"];
    		$isLeader = $row["isLeader"];
    		$isDeleted = $row["isDeleted"];
			$sql2 = "SELECT `email`,`firstname`,`lastname` FROM users WHERE `id`='$studentidtemp'";
			$result2 = mysqli_query($con,$sql2);
			if (mysqli_num_rows($result2) > 0) {
    			while($row2 = mysqli_fetch_assoc($result2)) {
    			if($isDeleted == 0)
    			{
    				$address = $row2["email"];
    				$sql2 = "SELECT `email` FROM users WHERE `id`='$studentid'";
  					$result2 = mysqli_query($con,$sql2);
  					$studentemail = "";
  					if (mysqli_num_rows($result2) > 0) {
    					while($row2 = mysqli_fetch_assoc($result2)) {
    						$studentemail = $row2["email"];
    					}
    				}
    				require 'PHPMailer/PHPMailerAutoload.php';
	$mail = new PHPMailer(true);
	$mail->IsSMTP();
	$mail->SMTPAuth = true; // enable SMTP authentication
    $mail->SMTPSecure = "tls";//"ssl"; // sets the prefix to the servier
    $mail->Host = "smail.bcp.org"; // sets GMAIL as the SMTP server
    $mail->Port = 587; // set the SMTP port for the GMAIL server
    $mail->Username = "clubmailer@bcp.org"; // GMAIL username
    $mail->FromName = 'clubmailer';

    $mail->Password = "BCP3m@1l!"; // GMAIL password  
    				$mail->AddReplyTo("$studentemail");
					$mail->SetFrom("$studentemail");
					$fromname = $studentname. " from ". $clubname;
					$mail->FromName = $fromname;
					$mail->Subject = $subject;
					$mail->Body = $message;
					$mail->addAddress("$address");
					$mail->isHTML(true); 
    				if(!$mail->send()) {
						header("Location: http://times.bcp.org/clubs/email.php?state=2");
					} else {
						header("Location: http://times.bcp.org/clubs/email.php?state=1");
					}
    			}
    			}
    		}
    	}
    }
    if($ccset == 1)
    {
    $ccarray = explode(';', $cc);
	foreach($ccarray as $ccaddress)
	{
		
    				if (mysqli_num_rows($result2) > 0) {
    					while($row2 = mysqli_fetch_assoc($result2)) {
    						$studentemail = $row2["email"];
    					}
    				}
    				require 'PHPMailer/PHPMailerAutoload.php';
	$mail = new PHPMailer(true);
	$mail->IsSMTP();
	$mail->SMTPAuth = true; // enable SMTP authentication
    $mail->SMTPSecure = "tls";//"ssl"; // sets the prefix to the servier
    $mail->Host = "smail.bcp.org"; // sets GMAIL as the SMTP server
    $mail->Port = 587; // set the SMTP port for the GMAIL server
    $mail->Username = "clubmailer@bcp.org"; // GMAIL username
    $mail->Password = "BCP3m@1l!"; // GMAIL password 
    				$mail->AddReplyTo("$studentemail");
					$mail->SetFrom("$studentemail");
					$fromname = $studentname. " from ". $clubname;
					//$mail->From = 'clubmailer@bcp.org';
					//$mail->FromName = 'clubmailer';
					$mail->FromName = $fromname;
					$mail->Subject = $subject;
					$mail->Body = $message;
					$mail->addAddress("$ccaddress");
					$mail->isHTML(true); 
    				if(!$mail->send()) {
						header("Location: http://times.bcp.org/clubs/email.php?state=2");
					} else {
						header("Location: http://times.bcp.org/clubs/email.php?state=1");
					}
	}
	}
}
?>