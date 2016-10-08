<?php
	$id = $_GET['id'];
	$servername = "localhost";
	$username = "clubs_u3er";
	$password = "tCpw6uTKZj3faqPT";
	$dbname = "clubs";
	$con=mysqli_connect($servername, $username, $password, $dbname);
	$row = NULL;
	$sql = "SELECT `firstname`, `lastname`, `email`,`id` FROM `users` WHERE `id` = $id";
	$result = mysqli_query($con, $sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			echo json_encode($row);
		}
	}
	else {
		echo "FAIL";
	}
?>