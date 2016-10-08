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

	$clubid = $_GET['clubid'];

  	$sql = "SELECT `name`,`leaders` FROM `clubs` WHERE `id` = $clubid";
	$result = mysqli_query($con,$sql);

	if (mysqli_num_rows($result) > 0) {
    	while($row = mysqli_fetch_assoc($result)) {
    		$name = $row["name"];
    		echo $name;
			$leaders = $row["leaders"];
			echo $leaders;
    	}
    } else {
    	echo "0 results";
	}


	$con->close();
	
?>