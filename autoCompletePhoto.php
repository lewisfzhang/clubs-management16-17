<?php
	$resultstring  = array();
	$servername = "localhost";
	$username = "clubs_u3er";
	$password = "tCpw6uTKZj3faqPT";
	$dbname = "clubs";
	$con=mysqli_connect($servername, $username, $password, $dbname);
	$searchquery = $_GET['q'];
	$sql = "SELECT * FROM `users` WHERE `lastname` LIKE '%$searchquery%' OR `firstname` LIKE '%$searchquery%'";
	$result = mysqli_query($con, $sql);
	$json = "http://times.bcp.org/clubs/getStudents.php";
	echo $json;
	$rows = json_decode($json);
	print_r($rows);
	$foundResults = false;
	$row = NULL;
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			$tempstring = mysqli_real_escape_string($con, $row['firstname']);
			$tempstring .= " ";
			$tempstring .= mysqli_real_escape_string($con, $row['lastname']);
			$gradeint = 28 - ((int)mysqli_real_escape_string($con, $row['grade']));
			$tempstring .=" '$gradeint";
			for($i = 0; $i < count($rows); $i++)
			{
				$map = $rows[$i];
				$firstname = $map["firstname"];
				$lastname = $map["lastname"];
				$grade = $map["grade"];
				if($firstname == $row['firstname'])
				{
					if($lastname == $row['lastname'])
					{
						if($grade == $row['grade'])
						{
							$resultstring[] = $tempstring;
							$foundResults = true;
						}
					}
				}
			}
	}
	/*if($foundResults == false)
	{
		$sql = "SELECT * FROM `users` WHERE `lastname` LIKE '%$searchquery%' OR `firstname` LIKE '%$searchquery%'";
		$result = mysqli_query($con, $sql);
		$row2 = NULL;
		while($row2 = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			$tempstring = mysqli_real_escape_string($con, $row2['firstname']);
			$tempstring .= " ";
			$tempstring .= mysqli_real_escape_string($con, $row2['lastname']);
			$gradeint = 28 - ((int)mysqli_real_escape_string($con, $row2['grade']));
			$tempstring .=" '$gradeint";
			$resultstring[] = $tempstring;
		}
	}*/
	echo json_encode($resultstring);
?> 