<?php
	$servername = "localhost";
	$username = "clubs_u3er";
	$password = "tCpw6uTKZj3faqPT";
	$dbname = "clubs";
	$con=mysqli_connect($servername, $username, $password, $dbname);
	$row = NULL;
	$sql = "SELECT * FROM `clubs`";
	$result = mysqli_query($con, $sql);
	$row = NULL;
	$resultArr = array();
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		$row["leaders"] = file_get_contents("http://times.bcp.org/clubs/getLeaders.php?clubid=" . $row["id"]);
		$resultArr[] = $row;
	}
	echo json_encode($resultArr);
?>