<?php
	$resultstring  = array();
	$servername = "localhost";
	$username = "clubs_u3er";
	$password = "tCpw6uTKZj3faqPT";
	$dbname = "clubs";
	$con=mysqli_connect($servername, $username, $password, $dbname);
	$searchquery = $_GET['q'];
	$sql = NULL;
	if ($_GET['type'] == "name") {
		$sql = "SELECT * FROM `users` WHERE `lastname` LIKE '%$searchquery%' OR `firstname` LIKE '%$searchquery%'";
	}
	else {
		$sql = "SELECT * FROM `users`";
	}
	$result = mysqli_query($con, $sql);
	$row = NULL;
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		if ($_GET['type'] == "email") {
			$tempstring = mysqli_real_escape_string($con, $row['email']);
			$tempstring .= " (";
			$tempstring .= mysqli_real_escape_string($con, $row['firstname']);
			$tempstring .= " ";
			$tempstring .= mysqli_real_escape_string($con, $row['lastname']);
			$gradeint = 28 - ((int)mysqli_real_escape_string($con, $row['grade']));
			$tempstring .=" '$gradeint";
			$tempstring .= ")";
			$resultstring[] = $tempstring;
		}
		else if ($_GET['type'] == "name") {
			$tempstring = mysqli_real_escape_string($con, $row['firstname']);
			$tempstring .= " ";
			$tempstring .= mysqli_real_escape_string($con, $row['lastname']);
			$gradeint = 28 - ((int)mysqli_real_escape_string($con, $row['grade']));
			$tempstring .=" '$gradeint";
			$resultstring[] = $tempstring;
		}
		else if ($_GET['type'] == "studentid") {
			$tempstring = mysqli_real_escape_string($con, $row['id']);
			$tempstring .= " (";
			$tempstring .= mysqli_real_escape_string($con, $row['firstname']);
			$tempstring .= " ";
			$tempstring .= mysqli_real_escape_string($con, $row['lastname']);
			$gradeint = 28 - ((int)mysqli_real_escape_string($con, $row['grade']));
			$tempstring .=" '$gradeint";
			$tempstring .= ")";
			$resultstring[] = $tempstring;
		}
	}
	echo json_encode($resultstring);
?> 