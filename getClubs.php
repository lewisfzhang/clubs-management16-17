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

  	$sql = "SELECT `id`,`name` FROM `clubs`";
	$result=mysqli_query($con,$sql);
	$rowcount=mysqli_num_rows($result);

	if (mysqli_num_rows($result) > 0) {
    	while($row = mysqli_fetch_assoc($result)) {
        	echo $row["id"]. ":" . $row["name"]. ",";
    	}
    } else {
    	echo "0 results";
	}

	$con->close();
	
?>