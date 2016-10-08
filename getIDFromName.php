<?php
	$input = $_GET['input'];
	$servername = "localhost";
	$username = "clubs_u3er";
	$password = "tCpw6uTKZj3faqPT";
	$dbname = "clubs";
	$con=mysqli_connect($servername, $username, $password, $dbname);
	$row = NULL;
	if (strpos($input, '(') != false) {
		$shards = explode("(", $input);
		$refinedshard = substr(($shards[1]), 0, -1);
		$newsplit = explode(" ", $refinedshard);
		$grade = NULL;
		$firstname = NULL;
		$lastname = NULL;
		if (count($newsplit) > 3) {
			$grade = (28 - (int)ltrim($newsplit[3], "'"));
			$lastname = $newsplit[1];
			$lastname .= " $newsplit[2]";
			$lastname = "'$lastname'";
			$firstname = "'$newsplit[0]'";
		}
		else {
			$grade = (28 - (int)ltrim($newsplit[2], "'"));
			$firstname = "'$newsplit[0]'";
			$lastname = "'$newsplit[1]'";
		}
		$sql = "SELECT `firstname`, `lastname`, `email`,`id` FROM `users` WHERE `firstname` = $firstname AND `lastname` = $lastname AND `grade` = $grade";
		$result = mysqli_query($con, $sql);
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				echo json_encode($row);
			}
		}
		else {
			echo "empty result";
		}
	}

	else {
		$newsplit = explode(" ", $input);
		$grade = NULL;
		$firstname = NULL;
		$lastname = NULL;
		if (count($newsplit) > 3) {
			$grade = (28 - (int)ltrim($newsplit[3], "'"));
			$lastname = $newsplit[1];
			$lastname .= " $newsplit[2]";
			$lastname = "'$lastname'";
			$firstname = "'$newsplit[0]'";
		}
		else {
			$grade = (28 - (int)ltrim($newsplit[2], "'"));
			$firstname = "'$newsplit[0]'";
			$lastname = "'$newsplit[1]'";
		}
		$sql = "SELECT `firstname`, `lastname`, `email`,`id` FROM `users` WHERE `firstname` = $firstname AND `lastname` = $lastname AND `grade` = $grade";
		$result = mysqli_query($con, $sql);
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				echo json_encode($row);
			}
		}
		else {
			echo "empty result";
		}
	}
?>