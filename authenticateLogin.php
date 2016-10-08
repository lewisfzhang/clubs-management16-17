<?php
	$servername = "localhost";
	$username = "clubs_u3er";
	$password = "tCpw6uTKZj3faqPT";
	$dbname = "clubs";

	$con=mysqli_connect($servername, $username, $password, $dbname);

	$clubid = $_GET['clubid'];
	$studentid = $_GET['studentid'];
	
	$clubid = mysqli_real_escape_string($con, $clubid);
	$studentid = mysqli_real_escape_string($con, $studentid);
	
	if($studentid == 216259 OR $studentid == 216397 OR $studentid == 216266)
	{
		$sql2 = "SELECT `name`,`leaders`,`moderator`,`meetinginfo`,`description` FROM `clubs` WHERE `id` = '$clubid'";
				$result2 = mysqli_query($con,$sql2);
				if (mysqli_num_rows($result2) > 0) {
    				while($row2 = mysqli_fetch_assoc($result2)) {
    					$clubname = $row2["name"];
    					$clubleaders = $row2["leaders"];
    					$clubmoderator = $row2["moderator"];
    					$clubmeetinginfo = $row2["meetinginfo"];
    					$clubdescription = $row2["description"];
    				}
    			}
    			$sql2 = "SELECT `firstname`,`lastname`,`email` FROM `users` WHERE `id` = '$studentid'";
				$result2 = mysqli_query($con,$sql2);
				if (mysqli_num_rows($result2) > 0) {
    				while($row2 = mysqli_fetch_assoc($result2)) {
    					$firstname = $row2["firstname"];
    					$lastname = $row2["lastname"];
    					$studentname = $firstname. " ". $lastname;
    					$email = $row2["email"];
    				}
    			}
    			setCookie("clubid", $clubid, time() + 86400);
    			setCookie("clubname", $clubname, time() + 86400);
    			setCookie("clubleaders", $clubleaders, time() + 86400);
    			setCookie("clubmoderator", $clubmoderator, time() + 86400);
    			setCookie("clubmeetinginfo", $clubmeetinginfo, time() + 86400);
    			setCookie("clubdescription", $clubdescription, time() + 86400);
    			setCookie("studentname", $studentname, time() + 86400);
    			setCookie("studentid", $studentid, time() + 86400);
    			setCookie("studentemail", $email, time() + 86400);
    			header("Location: http://times.bcp.org/clubs/index.php");
    			die();
    }

  	$sql = "SELECT `isLeader`,`isDeleted` FROM `memberships` WHERE `clubid` = '$clubid' AND `userid` = '$studentid'";
	$result = mysqli_query($con,$sql);

	if (mysqli_num_rows($result) > 0) {
    	while($row = mysqli_fetch_assoc($result)) {
    		$isLeader = $row["isLeader"];
    		$isDeleted = $row["isDeleted"];
    		if($isLeader == 1 AND $isDeleted == 0) {
    			$sql2 = "SELECT `name`,`leaders`,`moderator`,`meetinginfo`,`description` FROM `clubs` WHERE `id` = '$clubid'";
				$result2 = mysqli_query($con,$sql2);
				if (mysqli_num_rows($result2) > 0) {
    				while($row2 = mysqli_fetch_assoc($result2)) {
    					$clubname = $row2["name"];
    					$clubleaders = $row2["leaders"];
    					$clubmoderator = $row2["moderator"];
    					$clubmeetinginfo = $row2["meetinginfo"];
    					$clubdescription = $row2["description"];
    				}
    			}
    			$sql2 = "SELECT `firstname`,`lastname`,`email` FROM `users` WHERE `id` = '$studentid'";
				$result2 = mysqli_query($con,$sql2);
				if (mysqli_num_rows($result2) > 0) {
    				while($row2 = mysqli_fetch_assoc($result2)) {
    					$firstname = $row2["firstname"];
    					$lastname = $row2["lastname"];
    					$studentname = $firstname. " ". $lastname;
    					$email = $row2["email"];
    				}
    			}
    			setCookie("clubid", $clubid, time() + 86400);
    			setCookie("clubname", $clubname, time() + 86400);
    			setCookie("clubleaders", $clubleaders, time() + 86400);
    			setCookie("clubmoderator", $clubmoderator, time() + 86400);
    			setCookie("clubmeetinginfo", $clubmeetinginfo, time() + 86400);
    			setCookie("clubdescription", $clubdescription, time() + 86400);
    			setCookie("studentname", $studentname, time() + 86400);
    			setCookie("studentid", $studentid, time() + 86400);
    			setCookie("studentemail", $email, time() + 86400);
    			header("Location: http://times.bcp.org/clubs/index.php");
    			die();
    		}
    		else {
    			header("Location: http://times.bcp.org/clubs/login.php?failed=true");
    			die();
    		}
    	}
    } else {
    	header("Location: http://times.bcp.org/clubs/login.php?failed=true");
    	die();
	}

	$con->close();
	
?>