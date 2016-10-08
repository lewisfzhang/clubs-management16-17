<?php
	$servername = "localhost";
	$username = "clubs_u3er";
	$password = "tCpw6uTKZj3faqPT";
	$dbname = "clubs";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	
	$json = $_POST['json'];
	
	$array = json_decode($json, true);
	for($i = 0; $i < count($array); $i++)
	{
		$map = $array[$i];
		$currentclub = $map["clubID"];
		$currentstudent = $map["studentID"];
		$fieldname = 'Roll 03/08/16';

		$sql = "INSERT IGNORE INTO roll (studentid, clubid, fieldname)
			VALUES ($currentstudent, $currentclub, '$fieldname')";

			if ($conn->query($sql) === TRUE) {
 		   		echo "Attendance record added successfully: $currentclub:$currentstudent:$fieldname<br>";
			} else {
   		 		echo "Error: " . $sql . "<br>" . $conn->error;
			}
	}

	$conn->close();
?>