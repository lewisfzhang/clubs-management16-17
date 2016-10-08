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
		
		$sql3 = "SELECT `isDeleted` FROM memberships WHERE `clubid`='$currentclub' AND `userid`='$currentstudent'";
		$result=mysqli_query($conn,$sql3);
		
		if (mysqli_num_rows($result) > 0) {
			$sql2 = "UPDATE memberships
			SET `isDeleted`=0
			WHERE `clubid`='$currentclub' AND `userid`='$currentstudent'";
			if ($conn->query($sql2) === TRUE) {
 		   		echo "Membership added successfully: $currentclub:$currentstudent<br>";
			} else {
   		 		echo "Error: " . $sql2 . "<br>" . $conn->error;
			}
		}
		else
		{
			$sql = "INSERT IGNORE INTO memberships (clubid, userid)
			VALUES ($currentclub, $currentstudent)";

			if ($conn->query($sql) === TRUE) {
 		   		echo "Membership added successfully: $currentclub:$currentstudent<br>";
			} else {
   		 		echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
	}

	$conn->close();
?>