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

  	$clubid = $_COOKIE['clubid'];

  	$sql = "SELECT *
  	FROM `clubs`
  	WHERE `id` = '$clubid'";

  	$result = mysqli_query($con,$sql);

  	$rows = array();
	while($r = mysqli_fetch_assoc($result)) {
    	$rows[] = $r;
	}

	$sql = "SELECT `id`
	FROM `memberships`
	WHERE `clubid` = '$clubid'
	AND `isDeleted` = '0'";	
	$result = mysqli_query($con,$sql);
	$num = mysqli_num_rows($result);

	$rows[0]['count'] = "$num";

	echo json_encode($rows);

	$con->close();

?>