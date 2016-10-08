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
            <li class="active"><a href="index.php">Manage Club</a></li>
            <li><a href="help.php">Help</a></li>
          </ul>
          <p class="navbar-text navbar-right">Signed in as <?php echo($_COOKIE["studentname"]);?> / <?php echo($_COOKIE["clubname"]);?> (<a href="logout.php" class="navbar-link">Sign Out</a>)</p>

        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" id="top">

      <h1><?php echo($_COOKIE["clubname"]);?></h1>

      <ul class="nav nav-tabs">
        <li class="active"><a href="">Information</a></li>
        <li><a href="roster.php">Roster</a></li>
        <li><a href="addStudents.php">Add Members</a></li>
        <li><a href="email.php">Emails</a></li>
        <li><a href="feedback.php">Feedback</a></lia>
      </ul>

      <?php 
          if (isset($_GET["state"])) {
            if ($_GET["state"] == 1) {
              echo("<div class=\"alert alert-success\" role=\"alert\">Club Information Edited Successfully.</div>");
            }
          }
          if (isset($_GET["state"])) {
            if ($_GET["state"] == 4) {
              echo("<div class=\"alert alert-success\" role=\"alert\">Club leader added successfully.</div>");
            }
          }
      ?>
      
      <div class="row"> 

        <?php

          ob_start();
          include ("getClubInformation.php");
          $json = ob_get_clean();
          $clubInfo = json_decode($json)[0];

          ob_start();
          include ("getLeaders.php");
          $leaders = ob_get_clean();

        ?>

        <div class="col-sm-9">

          <form class="form-horizontal" method="POST" action="editFields.php">
            <div class="form-group">
            <label class="col-sm-3 control-label">Club Name</label>
              <div class="col-sm-9">
                <p class="form-control-static editable-default" ><?php echo($clubInfo->{"name"});?></p>
                <input disabled type="text" class="form-control editable-field disabled" <?php echo "value=\"".htmlspecialchars($clubInfo->{"name"})."\"";?>>                
              </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 control-label">Club ID</label>
              <div class="col-sm-9">
                <p class="form-control-static editable-default"><?php echo($clubInfo->{"id"});?></p>
                <input disabled type="text" class="form-control editable-field disabled" <?php echo "value=\"".htmlspecialchars($clubInfo->{"id"})."\"";?>>                
              </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 control-label">Leaders</label>
              <div class="col-sm-9">
                <p class="form-control-static editable-default"><?php echo($leaders);?></p>
                <input disabled type="text" class="form-control editable-field disabled" <?php echo "value=\"".htmlspecialchars($leaders)."\"";?>>                
              </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 control-label">Number of Members</label>
              <div class="col-sm-9">
                <p class="form-control-static editable-default"><?php echo($clubInfo->{"count"});?></p>
                <input disabled type="text" class="form-control editable-field disabled" <?php echo "value=\"".htmlspecialchars($clubInfo->{"count"})."\"";?>>                
              </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 control-label">Club Category</label>
              <div class="col-sm-9">
                <p class="form-control-static editable-default"><?php echo($clubInfo->{"category"});?></p>
                <input disabled type="text" class="form-control editable-field disabled" <?php echo "value=\"".htmlspecialchars($clubInfo->{"category"})."\"";?>>                                
              </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 control-label">Club Description</label>
              <div class="col-sm-9">
                <p class="form-control-static editable-default"><?php echo($clubInfo->{"description"});?></p>
                <textarea name="description" class="form-control editable-field" rows="2"><?php echo htmlspecialchars($clubInfo->{"description"});?></textarea>
              </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 control-label">Club Moderator</label>
              <div class="col-sm-9">
                <p class="form-control-static editable-default"><?php echo($clubInfo->{"moderator"});?></p>
               <input type="text" name="moderator" class="form-control editable-field" <?php echo "value=\"".htmlspecialchars($clubInfo->{"moderator"})."\"";?>>
              </div>
            </div>
            <div class="form-group">
            <label class="col-sm-3 control-label">Meeting Information</label>
              <div class="col-sm-9">
                <p class="form-control-static editable-default"><?php echo($clubInfo->{"meetinginfo"});?></p>
                <input type="text" name="meetinginfo" class="form-control editable-field" <?php echo "value=\"".htmlspecialchars($clubInfo->{"meetinginfo"})."\"";?>>
              </div>
            </div>

        </div>

        <div class="col-sm-3">
          <button id="edit-button" type="button" class="btn btn-default" aria-label="Edit Club Information">
              <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit Club Information
          </button>

          <button id="cancel-button" type="button" class="btn btn-default" aria-label="Cancel Editing">
              <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Cancel Editing
          </button>

          <br>

          <button type="submit" style="margin-top: 10px" id="submit-edit-button" type="button" class="btn btn-success" aria-label="Submit Edits">
              <span class="glyphicon glyphicon-check" aria-hidden="true"></span> Submit Edits
          </button>
        </div>

        </form>
        
      </div>

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