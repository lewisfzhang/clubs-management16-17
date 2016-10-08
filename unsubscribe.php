<?php
	$servername = "localhost";
	$username = "clubs_u3er";
	$password = "tCpw6uTKZj3faqPT";
	$dbname = "clubs";
	$email = $_GET['email'];
	$clubid = $_GET['mid'];
	$hashedemail = crypt($email, "C5kf72Ka3yU0");
	if ($hashedemail === $_GET['hash']) {
		$con=mysqli_connect($servername, $username, $password, $dbname);
		if ($con->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 
		$id = NULL;
		$name = NULL;
		$sql = "SELECT `id`, `firstname`, `lastname` FROM `users` WHERE `EMAIL` = '$email'";
		$result = mysqli_query($con, $sql);
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				$id = $row['id'];
				$firstname = $row['firstname'];
				$lastname = $row['lastname'];
				$name = "$firstname $lastname";
				$checksql = "SELECT `isDeleted` FROM `memberships` WHERE `userid` = $id AND `clubid` = $clubid";
				$resultcheck = mysqli_query($con, $checksql);
				if (mysqli_num_rows($resultcheck) > 0) {
					while($row = mysqli_fetch_assoc($resultcheck)) {
						if ($row['isDeleted']) {
							echo "Great News! You've already been deleted, $name!";
						}
						else {
							$sql2 = "UPDATE `memberships` SET `isDeleted` = 1, `isLeader` = 0 WHERE `userid` = $id AND `clubid` = $clubid";
							if (mysqli_query($con, $sql2)) {
							    echo "$name was successfully removed from the club!";
							} else {
							    echo "Error removing you from the club: " . mysqli_error($con);
							}
						}
					}
				}
				$con->close();
			}
		}
		else {
			echo "Sorry, we couldn't find you. You may have been explicitly added as a recipient to this email by the original sender";
		}
	}
	else {
		echo "<h3>BRUH YOUR HASHED POTATOES ARE ALL OVER THE PLACE</h3>";
	}
?>