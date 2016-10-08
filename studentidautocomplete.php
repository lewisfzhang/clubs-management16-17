<?php
	$resultstring  = array();
	$servername = "localhost";
	$username = "clubs_u3er";
	$password = "tCpw6uTKZj3faqPT";
	$dbname = "clubs";
	$con=mysqli_connect($servername, $username, $password, $dbname);
	$searchquery = $_GET['term'];
	if (is_numeric($searchquery)) {
		$numericquery = (int)$searchquery;
		$sql = "SELECT * FROM `users` WHERE `id` LIKE '%$numericquery%'";
		$result = mysqli_query($con, $sql);
		$row = NULL;
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			$tempstring = mysqli_real_escape_string($con, $row['firstname']);
			$tempstring .= " ";
			$tempstring .= mysqli_real_escape_string($con, $row['lastname']);
			$gradeint = 28 - ((int)mysqli_real_escape_string($con, $row['grade']));
			$tempstring .=" '$gradeint";
			array_push($resultstring, array("value" => $tempstring));
		}
	}
	echo json_encode($resultstring);
?> 