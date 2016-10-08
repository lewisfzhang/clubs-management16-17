<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8">
		<title>Club Edit Page</title>
		<style type = "text/css">
			.error {
				font: normal 10px arial;
				padding: 3px;
				margin: 3px;
				background-color: #ffc;
				border: 1px solid #c00;
			}
		</style>
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>
		<script>
			$(document).ready(function(){
				$.validator.addMethod("NumbersOnly", function(value, element) {
        		return this.optional(element) || /^[0-9]+$/i.test(value);
    			}, "Student ID must contain only numbers.");
    			
    			$.validator.addMethod("username", function(value, element) {
        		return this.optional(element) || /^[a-z]+$/i.test(value);
    			}, "Name must contain only letters.");

				$("#registerForm").validate(); 
			});
		</script>
	</head>
	<body>
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
    				$clubname = $row["name"];
					$clubleaders = $row["leaders"];
    			}
  		  } else {
    			echo "0 results";
			}


			$con->close();
		?>
		<h1 style = "font-size: 40px;"><?php echo $clubname; ?></h1>
		<br />
		<p>Hello, <?php echo $clubleaders; ?>! Welcome to your club edit page. Here, you may add, delete, or send emails to the 
		members of your club. For addition or deletion, you can enter the student's BCP ID <b><u>OR</b></u> his name. </p>
		<h3>Adding New Members</h3>
		<form name="form" method="post" id="registerForm" action="http://times.bcp.org/clubs/autocompleteResult.php#pill1" >
			<table width="400" cellpadding="10" cellspacing="5"> 
			</table>
			<input type="submit">
		</form>
		<br />
		<h3>Deleting Members</h3>
		<form name="form" method="post" id="registerForm" action="http://times.bcp.org/clubs/deleteMembers.php" >
			<table width="400" cellpadding="10" cellspacing="5"> 
				<tr>
					<th scope="row"></th>
					<td><center>Student ID:</center></td>
					<td><center><input name="clubid" type="text" id="clubid" class="required NumbersOnly"></center></td>
				</tr> 
				<tr>
					<th scope="row"></th>
					<td><center>Student Name:</center></td>
					<td><center><input name="studentname" type="text" id="studentname" class="required username"></center></td>
				</tr> 
			</table>
			<input type="submit">
		</form>
		<br />
		<h3>Sending Email to Club</h3>
		<form name="form" method="post" id="registerForm" action="http://times.bcp.org/clubs/emailMembers.php" >
			<table width="400" cellpadding="10" cellspacing="5"> 
				<tr>
					<th scope="row"></th>
					<td><center>Text of Email:</center></td>
					<td><center><textarea name="email"></textarea></center></td>
				</tr> 
			</table>
			<input type="submit">
		</form>
	</body>	
</html>