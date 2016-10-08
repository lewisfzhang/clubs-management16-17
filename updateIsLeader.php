<?php
	$servername = "localhost";
	$username = "clubs_u3er";
	$password = "tCpw6uTKZj3faqPT";
	$dbname = "clubs";

	$con=mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
	if (mysqli_connect_errno())
 	{
 		echo "Failed to connect to MySQL: " . mysqli_connect_error();
  	}

  	$sql = "SELECT `id`,`email1`,`email2`,`email3` FROM `clubs`";
	$result = mysqli_query($con,$sql);

	$rows = array();

	if (mysqli_num_rows($result) > 0) {
    	while($row = mysqli_fetch_assoc($result)) {
    		$clubid = $row["id"];
    		$email1 = $row["email1"];
    		$email2 = $row["email2"];
    		$email3 = $row["email3"];
    		$rows[] = $row;
    		
    		$sql2 = "SELECT `id` FROM `users` WHERE `email`='$email1' OR `email`='$email2' OR `email`='$email3'";
			$result2 = mysqli_query($con, $sql2);
			if (mysqli_num_rows($result2) > 0) {
    			while($row2 = mysqli_fetch_assoc($result2)) {
    				$studentid = $row2["id"];
    				echo "Club Id: $clubid, Student ID: $studentid<br />";
    				
    				$sql3 = "INSERT IGNORE INTO memberships (clubid, userid)
					VALUES ($clubid, $studentid)";

					if ($con->query($sql3) === TRUE) {
 		   				echo "Membership added successfully: $clubid:$studentid<br>";
					} else {
   		 				echo "Error: " . $sql3 . "<br>" . $con->error;
					}
					
					$sql4 = "UPDATE memberships
					SET `isLeader`=1
					WHERE `clubid`=$clubid AND `userid`=$studentid";
					
					if ($con->query($sql4) === TRUE) {
 		   				echo "Leader updated successfully: $clubid:$studentid<br>";
					} else {
   		 				echo "Error: " . $sql4 . "<br>" . $con->error;
					}
    			}
    		}
    	}
    }
    
    print_r($rows);
    
    /*for($i = 0; $i < count($rows); $i++)
    {
    	$map = $rows[$i];
    	$email1 = $map["email1"];
    	echo $email1;
    	$email2 = $map["email2"];
    	echo $email2;
    	$email3 = $map["email3"];
    	echo $email3;
    	$sql = "SELECT `id` FROM `users` WHERE `email`='$email1' OR `email`='$email2' OR `email`='$email3'";
		$result = mysqli_query($con, $sql);
		if (mysqli_num_rows($result) > 0) {
    		while($row = mysqli_fetch_assoc($result)) {
    			$studentid = $row["id"];
    			echo "Club Id: $clubid, Student ID: $studentid<br />";
    		}
    	}
    }*/
    
    
	/*		$sql2 = "SELECT `id` FROM `users` WHERE `email`=$email1 OR `email`=$email2 OR `email`=$email3";
			$result2 = mysqli_query($con,$sql);
			echo mysqli_num_rows($result2);
			if (mysqli_num_rows($result2) > 0) {
    			while($row2 = mysqli_fetch_assoc($result2)) {
					$studentid = $row2["id"];
					$rows[] = $row2;
					/*echo "<br />";
					echo $clubid;
					echo " ";
					echo $studentid;
					$sql3 = "INSERT IGNORE INTO memberships (clubid, userid)
					VALUES ($clubid, $studentid)";

					if ($con->query($sql3) === TRUE) {
 		   				echo "Membership added successfully: $clubid:$studentid<br>";
					} else {
   		 				echo "Error: " . $sql3 . "<br>" . $con->error;
					}
					
					$sql4 = "UPDATE memberships
					SET `isLeader`=1
					WHERE `clubid`=$clubid AND `userid`=$studentid";
					
					if ($con->query($sql4) === TRUE) {
 		   				echo "Leader updated successfully: $clubid:$studentid<br>";
					} else {
   		 				echo "Error: " . $sql4 . "<br>" . $con->error;
					}
				}
			}
	for($i = 0; $i < count($array); $i++)
	{
		$map = $array[$i];
		$currentclub = $map["id"];
		$currentstudent = $map["studentID"];
	}
	
	print_r($rows);*/

	$con->close();
	
?>