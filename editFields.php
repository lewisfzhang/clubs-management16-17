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
  	
	$moderator = $_POST['moderator'];
	$meetinginfo = $_POST['meetinginfo'];
	$description = $_POST['description'];
	$clubid = $_COOKIE['clubid'];
	
	$moderator = mysqli_real_escape_string($con, $moderator);
	$meetinginfo = mysqli_real_escape_string($con, $meetinginfo);
	$description = mysqli_real_escape_string($con, $description);

  	$sql = "UPDATE clubs
	SET `moderator`='$moderator'
	WHERE `id`='$clubid'";
	
	$sql2 = "UPDATE clubs
	SET `meetinginfo`='$meetinginfo'
	WHERE `id`='$clubid'";
	
	$sql3 = "UPDATE clubs
	SET `description`='$description'
	WHERE `id`='$clubid'";
	
	if ($con->query($sql) === TRUE) {
		if ($con->query($sql2) === TRUE) {
			if ($con->query($sql3) === TRUE) {
 				header("Location: http://times.bcp.org/clubs/index.php?state=1");
 			}
 		}
	} else {
   		 echo "Error: " . $sql . "<br>" . $con->error;
	}
?>