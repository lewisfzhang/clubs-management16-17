<!DOCTYPE html>

<?php

  if (!isset($_COOKIE["studentname"])) {
      header("Location: http://times.bcp.org/clubs/login.php") ;
  }

?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="favicon.ico">

    <title>BCP Clubs</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    
    <script>
      $(document).ready(function(){

        $(".editable-field").hide();
        $("#cancel-button").hide();
        $("#submit-edit-button").hide();

        $("#edit-button").click(function(){
          $(".editable-default").hide();
          $(".editable-field").show();
          $("#edit-button").hide();
          $("#cancel-button").show();
          $("#submit-edit-button").show();
        });


        $("#cancel-button").click(function(){
          $(".editable-default").show();
          $(".editable-field").hide();
          $("#edit-button").show();
          $("#cancel-button").hide();
          $("#submit-edit-button").hide();
        });

    });
</script>
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Bellarmine Clubs</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Manage Club</a></li>
            <li class="active"><a href="help.php">Help</a></li>
          </ul>
          <p class="navbar-text navbar-right">Signed in as <?php echo($_COOKIE["studentname"]);?> / <?php echo($_COOKIE["clubname"]);?> (<a href="logout.php" class="navbar-link">Sign Out</a>)</p>

        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" id="top">

    <h1>Frequently Asked Questions</h1><br />
    <h3>For All Students</h3>
    <p><b>Q: How do I use this web application?</b><br />A: This portal allows you to edit 
    the clubs that you are a part of. We have provided a list of clubs that you can join (green 
    button), leave (red button), or manage (blue button) if you are a club leader. Using this 
    sign-up system, you will only get emails and reminders from your specific clubs.</p>
    <p><b>Q: What if I have another question or issue that hasn't been answered here?</b><br />A: 
	Email <a href = "mailto:blindemann@bcp.org?cc=clubmailer@bcp.org,chanan.walia16@bcp.org,rohan.menezes16@bcp.org,amit.mondal16@bcp.org&Subject=Club%20Concern">Mr. Lindemann</a>
	 and he would be happy to help you with any issues or concerns you might have.</p><br />
    <h3>For Club Leaders</h3>
    <p><b>Q: How do I manage my clubs?</b><br />A: Simply click the blue "Manage Club" button 
    next to your club's name.</p>
	<p><b>Q: How can I change my club information?</b><br />A: Go to the "Information" tab of 
	your club portal and click the "Edit Club Information" button. You will be able to edit 
	"Club Description", "Club Moderator", and "Meeting Information".</p>
	<p><b>Q: How can I edit my club roster?</b><br />A: You can delete members directly 
	from the "Roster" tab by clicking the "Remove Student" button. You can add students by 
	entering their name, email, or student id in the "Add Members" tab.</p>
	<p><b>Q: The Add Students tab isn't working. What am I doing wrong?</b><br />A: The 
	Add Students tab uses autocomplete to select students. Type in the first few characters 
	of the student's name, email, or student id and then select their option on the dropdown 
	menu.</p>
	<p><b>Q: What does the "Make Leader" button do on the "Roster" tab?</b><br />A: This button 
	adds that member as a leader. If you click that button, the student chosen can also log in 
	to the web portal, edit rosters, and send emails as long as they have the club id.</p>
	<p><b>Q: What if I have another question or issue that hasn't been answered here?</b><br />A: 
	Email <a href = "mailto:blindemann@bcp.org?cc=clubmailer@bcp.org,chanan.walia16@bcp.org,rohan.menezes16@bcp.org,amit.mondal16@bcp.org&Subject=Club%20Concern">Mr. Lindemann</a>
	 and he would be happy to help you with any issues or concerns you might have.</p>
	<br />
	<p><b>Go Bells!<br />Rohan Menezes, Chanan Walia, and Amit Mondal</b></p>
	</div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>

    <script type="text/j"
  </body>
</html>