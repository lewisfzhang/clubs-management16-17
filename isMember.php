<?php
	$servername = "localhost";
	$username = "clubs_u3er";
	$password = "tCpw6uTKZj3faqPT";
	$dbname = "clubs";
	$studentid = $_GET['studentid'];
	$clubid = $_GET['clubid'];
	$con=mysqli_connect($servername, $username, $password, $dbname);
	$row = NULL;
	$sql = "SELECT * FROM `memberships` WHERE `clubid` = '$clubid' AND `userid` =  '$studentid' AND `isDeleted` = 0";
	$result = mysqli_query($con, $sql);
	if (mysqli_num_rows($result) > 0) {
		echo "TRUE";
	}
	else {
		echo "FALSE";
	}
?>