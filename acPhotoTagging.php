<?php
	$resultstring  = array();
	$servername = "localhost";
	$username = "clubs_u3er";
	$password = "tCpw6uTKZj3faqPT";
	$dbname = "clubs";
	$con=mysqli_connect($servername, $username, $password, $dbname);
	$searchquery = $_GET['term'];
	$clubid = $_COOKIE['clubid'];
	$sql = "SELECT * FROM `users` WHERE `lastname` LIKE '%$searchquery%' OR `firstname` LIKE '%$searchquery%'";
	$result = mysqli_query($con, $sql);
	$row = NULL;
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		$id = $row['id'];
		$sql2 = "SELECT * FROM `memberships` WHERE `clubid` = $clubid AND `userid` = $id AND `isDeleted` = 0";
		$result2 = mysqli_query($con, $sql2);
		$row2 = NULL;
		while($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)){
			$studentid = $row2['userid'];
			$sql3 = "SELECT * FROM `users` WHERE `id` = $studentid";
			$result3 = mysqli_query($con, $sql3);
			$row3 = NULL;
			while($row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC)){
				$tempstring = mysqli_real_escape_string($con, $row3['firstname']);
				$tempstring .= " ";
				$tempstring .= mysqli_real_escape_string($con, $row3['lastname']);
				$gradeint = 28 - ((int)mysqli_real_escape_string($con, $row3['grade']));
				$tempstring .=" '$gradeint";
				$resultstring[] = $tempstring;
			}
		}
	}
	echo json_encode($resultstring);
?> 