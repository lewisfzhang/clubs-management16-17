<?php
	$servername = "localhost";
	$username = "clubs_u3er";
	$password = "tCpw6uTKZj3faqPT";
	$dbname = "clubs";
	$email = $_GET['email'];
	$clubid = $_GET['clubid'];
	$con=mysqli_connect($servername, $username, $password, $dbname);
	if ($con->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	$id = NULL;
	$sql = "SELECT `id` FROM `users` WHERE `EMAIL` = '$email'";
	$result = mysqli_query($con, $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$id = $row['id'];
		}
	}
	$sql2 = "UPDATE `memberships` SET `isDeleted` = 1, `isLeader` = 0 WHERE `userid` = $id AND `clubid` = $clubid";
	if (mysqli_query($con, $sql2)) {
	    echo "Record deleted successfully";
	} else {
	    echo "Error deleting record: " . mysqli_error($con);
	}
	$con->close();
?>