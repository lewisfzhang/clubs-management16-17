<?php
	$servername = "localhost";
	$username = "clubs_u3er";
	$password = "tCpw6uTKZj3faqPT";
	$dbname = "clubs";

	$con=mysqli_connect($servername, $username, $password, $dbname);
	$clubid = NULL;
	if (!isset($_GET['clubid'])) {
		$clubid = $_COOKIE['clubid'];
	}
	else {
		$clubid = $_GET['clubid'];
	}

    $sql = "SELECT `isLeader`, `userid` FROM `memberships` WHERE `clubid` = '$clubid' AND `isDeleted` = 0";
	$result = mysqli_query($con,$sql);

	$leaders = array();
	$leadersString = "";

	if (mysqli_num_rows($result) > 0) {
    	while($row = mysqli_fetch_assoc($result)) {
    		$isLeader = $row["isLeader"];
    		if($isLeader == 1) {
    			$studentid = $row["userid"];
    			$sql2 = "SELECT `firstname`,`lastname` FROM `users` WHERE `id` = '$studentid'";
				$result2 = mysqli_query($con,$sql2);
				if (mysqli_num_rows($result2) > 0) {
    				while($row2 = mysqli_fetch_assoc($result2)) {
    					$firstname = $row2["firstname"];
    					$lastname = $row2["lastname"];
    					$studentname = $firstname. " ". $lastname;
    					array_push($leaders, $studentname);
					}
    			}
			}
		}
	}

	foreach ($leaders as $leader) {
		$leadersString = $leadersString . $leader . ", ";
	}

	$con->close();

	echo substr($leadersString, 0, -2);

?>