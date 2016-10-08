<?php
	$servername = "localhost";
	$username = "clubs_u3er";
	$password = "tCpw6uTKZj3faqPT";
	$dbname = "clubs";
	$studentid = $_GET['studentid'];
	$clubid = $_GET['clubid'];
	$con=mysqli_connect($servername, $username, $password, $dbname);
	$row = NULL;
	$sql = "SELECT * FROM `memberships` WHERE `clubid` = '$clubid' AND `userid` =  '$studentid' AND `isDeleted` = 0 AND `isLeader` = 1";
	$leaderResult = mysqli_query($con, $sql);
	if (mysqli_num_rows($leaderResult) > 0) {
		echo "LEADER";
	}
	else {
		$sql2 = "SELECT * FROM `memberships` WHERE `clubid` = '$clubid' AND `userid` =  '$studentid' AND `isDeleted` = 0";
		$memberResult = mysqli_query($con, $sql2);
		if (mysqli_num_rows($memberResult) > 0) {
			echo "MEMBER";
		}
		else {
			echo "NONE";
		}
	}
?>