<?php
	$servername = "localhost";
	$username = "clubs_u3er";
	$password = "tCpw6uTKZj3faqPT";
	$dbname = "clubs";
	$clubid = $_POST['clubid'];
	$data = $_POST['ptdata'];
	$con=mysqli_connect($servername, $username, $password, $dbname);
	if ($con->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	$sql2 = "UPDATE `clubs` SET `photo_tag` = '$data' WHERE `id` = $clubid";
	if (mysqli_query($con, $sql2)) {
	    echo "success";
	} else {
	    echo "failure: " . mysqli_error($con);
	}
	$con->close();
?>