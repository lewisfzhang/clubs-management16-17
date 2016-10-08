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
        <li><a href="index.php">Information</a></li>
        <li><a href="roster.php">Roster</a></li>
        <li><a href="addStudents.php">Add Members</a></li>
        <li class="active"><a href="#">Emails</a></li>
        <li><a href="feedback.php">Feedback</a></li>
      </ul>


      <div id="alerts">

        <?php
            if (isset($_GET["state"])) {
                if ($_GET["state"] == 1) {
                  echo("<div class=\"alert alert-success\" role=\"alert\">Email sent successfully.</div>");
                }
                if ($_GET["state"] == 2) {
                  echo("<div class=\"alert alert-danger\" role=\"alert\">Email was not sent successfully.</div>");
                }
            }
        ?>

      </div>

      <!-- <div class="alert alert-danger" role="alert">Email is temporarily disabled while we switch to an updated Bellarmine server account. It will be available Wednesday, October 14 by 2:00pm. We're almost there, sorry for the delay!</div> -->


      <form id="emailform" class="form-horizontal" role="form" method="post">
        <div class="form-group">
            <label for="from" class="col-sm-2 control-label">From Field</label>
            <div class="col-sm-10">
                <input type="text" class="form-control disabled" id="from" name="from" placeholder="<?php echo $_COOKIE["studentname"]." from ".$_COOKIE["clubname"];?>" disabled>
            </div>
        </div>

        <div class="form-group">
            <label for="to" class="col-sm-2 control-label">To Field</label>
            <div class="col-sm-10">
                <input type="text" class="form-control disabled" id="to" name="to" placeholder="All Club Members" value="" disabled>
            </div>
        </div>

        <div class="form-group">
            <label for="CC" class="col-sm-2 control-label">Additional Recipients</label>
            <div class="col-sm-10">
                <input type="text" class="form-control editable" id="CC" name="CC" placeholder="Separate email addresses by semicolons (e.g. enter moderator emails)" value="">
            </div>
        </div>

        <div class="form-group">
            <label for="subject" class="col-sm-2 control-label">Subject Line</label>
            <div class="col-sm-10">
                <input type="text" class="form-control editable" id="subject" name="subject" placeholder="[Club Name] Some Subject" value="" required>
            </div>
        </div>

        <div class="form-group">
            <label for="message" class="col-sm-2 control-label">Message Body</label>
            <div class="col-sm-10">
                <textarea class="form-control" rows="10" name="message" required></textarea>
            </div>
        </div>

        <!--
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="replyall" value="true" class="editable"> Let recipients reply-all to email
                 </label>
              </div>
            </div>
        </div>
        -->

        <!-- <div class="form-group">
            <label for="attachment" class="col-sm-2 control-label">Attachment</label>
            <div class="col-sm-10">
                <input type="file" name="attachment" id="attachment">
            </div>
        </div> -->
        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
            </div>
        </div>
    </form>



    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>
        // Variable to hold request
        var request;

        // Bind to the submit event of the email form
        $("#emailform").submit(function(event){

            // Abort any pending request
            if (request) {
                request.abort();
            }
            
            // setup some local variables
            var $form = $(this);

            // Let's select and cache all the fields
            var $inputs = $form.find("input, textarea");

            // Serialize the data in the form
            var serializedData = $form.serialize();

            // Let's disable the inputs for the duration of the Ajax request.
            // Note: we disable elements AFTER the form data has been serialized.
            // Disabled form elements will not be serialized.
            $inputs.prop("disabled", true);

            // Fire off the request to /form.php
            request = $.ajax({
                url: "http://times.bcp.org/clubs/mailer.php",
                type: "post",
                data: serializedData
            });

            $("#alerts").html('<div class="alert alert-success" role="alert">Emails queued. You can close this page, or you way wait for confirmation that your email went through.</div>');

            // Callback handler that will be called on success
            request.done(function (response, textStatus, jqXHR){
                $("#alerts").html('<div class="alert alert-success" role="alert">Emails sent successfully.</div>');
                console.log(response);
            });

            // Callback handler that will be called on failure
            request.fail(function (jqXHR, textStatus, errorThrown){
                // Log the error to the console
                console.error(
                    "The following error occurred: "+
                    textStatus, errorThrown
                );
            });

            // Callback handler that will be called regardless
            // if the request failed or succeeded
            request.always(function () {
                // Reenable the inputs
                $inputs.prop("disabled", false);
                $("#from").prop("disabled", true);
                $("#to").prop("disabled", true);
                $("#cc").prop("disabled", true);
                document.getElementsByClassName("editable").reset();
                $("#CC").prop("placeholder","Separate email addresses by semicolons (e.g. enter moderator emails)");
                $("#subject").prop("placeholder","[Club Name] Some Subject");
            });

            // Prevent default posting of form
            event.preventDefault();
        });

    </script>

  </body>
</html>