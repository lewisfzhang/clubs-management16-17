<?php
	$resultstring  = array();
	$servername = "localhost";
	$username = "clubs_u3er";
	$password = "tCpw6uTKZj3faqPT";
	$dbname = "clubs";
	$con=mysqli_connect($servername, $username, $password, $dbname);
	$searchquery = $_GET['term'];
	$sql = "SELECT * FROM `users` WHERE CONCAT(`firstname`, ' ', `lastname`) LIKE '%$searchquery%'";
	$result = mysqli_query($con, $sql);
	//die(mysqli_error($con));
	$row = NULL;
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		$tempstring = mysqli_real_escape_string($con, $row['firstname']);
		$tempstring .= " ";
		$tempstring .= mysqli_real_escape_string($con, $row['lastname']);
		if (((int)mysqli_real_escape_string($con, $row['grade'])) == 0) {
			$gradeint = 0;
		}
		else {
			$gradeint = 28 - ((int)mysqli_real_escape_string($con, $row['grade']));
			$tempstring .=" '$gradeint";
		}
		
		array_push($resultstring, array("value" => $tempstring));
	}
	echo json_encode($resultstring);
?> 