<?php
	$servername = "localhost";
	$username = "clubs_u3er";
	$password = "tCpw6uTKZj3faqPT";
	$dbname = "clubs";
	$con=mysqli_connect($servername, $username, $password, $dbname);
	if ($con->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	//for removing students from tag - relies only on GET parameters, so no option check necessary
	if (isset($_GET['clubid']) && isset($_GET['studname'])) {
		$name = $_GET['studname'];
		$clubid = $_GET['clubid'];
		$clubname = $_GET['clubname'];
		$rdata = NULL;
		$sql = "SELECT `photo_tag` FROM `clubs` WHERE `id` = $clubid";
		$result = (mysqli_query($con, $sql));
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				$rdata = ($row);
			}
			$count = 0;
			$arr = json_decode($rdata['photo_tag']);
			foreach ($arr as $key=>$tag) {
				if ($tag->name == $name) {
					$tag->name = "";
				}
				$count++;
			}
			$final = json_encode($arr);
			
			$sql2 = "UPDATE `clubs` SET `photo_tag` = '$final' WHERE `id` = $clubid";
			if (mysqli_query($con, $sql2)) {
			    echo "<html><head><title>BCP Clubs</title>
			    <link href=\"css/bootstrap.min.css\" rel=\"stylesheet\">
			    <link href=\"css/style.css\" rel=\"stylesheet\">
			    <style>
			    	#main {text-align:center;}
			    	.mbutton {padding:200px; padding-top:40px;}
			    </style>
			    <script>
					var redirect = function() {
						window.open('http://times.bcp.org/clubs/faceTaggingPublic.php?clubid=".$clubid."', '_blank');
					}
			    </script>
			    </head>
			    <body>
			      <nav class=\"navbar navbar-inverse navbar-fixed-top\">
			      <div class=\"container\">
			        <div class=\"navbar-header\">
			          <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#navbar\" aria-expanded=\"false\" aria-controls=\"navbar\">
			            <span class=\"sr-only\">Toggle navigation</span>
			            <span class=\"icon-bar\"></span>
			            <span class=\"icon-bar\"></span>
			            <span class=\"icon-bar\"></span>
			          </button>
			          <a class=\"navbar-brand\" href=\"\">Bellarmine Clubs</a>
			        </div>
			        <div id=\"navbar\" class=\"collapse navbar-collapse\">
			          <ul class=\"nav navbar-nav\">
			            <li><a href=\"photoStatus.php\">Club List</a></li>
			          </ul>
			          <p class=\"navbar-text navbar-right\"></p>

			        </div><!--/.nav-collapse -->
			      </div>
			    </nav>
			    <br><br><br><div id = \"main\"><p style=\"font-family:verdana;text-align:center\">You've been successfully removed from all photo tags for ".$clubname."</p>
			    <div class = \"mbutton\"><button class = \"btn btn-primary btn-block\" onclick=\"redirect()\">Go to Club Photo for ".$clubname."</button></div></div>
			    </body></html>";
			} else {
			    echo "failure: " . mysqli_error($con);
			}
						
		}
		die();	
	}
	$option = $_POST['option'];
	$clubid = $_POST['clubid'];
	$data = $_POST['ptdata'];
	//for checking how many faces are tagged and if a photo has been uploaded
	if ($option == 'c') {
		if (file_exists(getcwd() . '/photos/' . $clubid . '.jpg')) {
			echo ('t');
			$rdata = NULL;
			$sql = "SELECT `photo_tag` FROM `clubs` WHERE `id` = $clubid";
			$result = (mysqli_query($con, $sql));
			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {
					$rdata = ($row);
				}
				 $numfaces = (count(json_decode($rdata['photo_tag'])));
				 if ($numfaces > 0) {
					 $numtagged = 0;
					 foreach (json_decode($rdata['photo_tag']) as $tag) {
					 	if ($tag->name !== "") {
					 		$numtagged++;
					 	}
					 }
					 echo $numtagged . '/' . $numfaces;
				 }
			}
		} else {echo('f');}
		die();
	}
	//for saving
	if ($option == 's') {
		$sql2 = "UPDATE `clubs` SET `photo_tag` = '$data' WHERE `id` = $clubid";
		if (mysqli_query($con, $sql2)) {
		    echo "success";
		} else {
		    echo "failure: " . mysqli_error($con);
		}
	}
	// for retrieving photo tag information
	if ($option == 'g') {
		$sql = "SELECT `photo_tag` FROM `clubs` WHERE `id` = $clubid";
		$result = (mysqli_query($con, $sql));
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				echo json_encode($row);
			}
		}
	}
	$con->close();
?>