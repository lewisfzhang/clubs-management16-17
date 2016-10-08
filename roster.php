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
        <li class="active"><a href="roster.php">Roster</a></li>
        <li><a href="addStudents.php">Add Members</a></li>
        <li><a href="email.php">Emails</a></li>
        <li><a href="feedback.php">Feedback</a></li>
      </ul>

      <div class="alert alert-danger" id = "deletedalert" role="alert">Student removed successfully.</div>
      <div class="alert alert-success" id = "leaderalert" role="alert">Leader added successfully.</div>


      <div id = "dvData">
        <table class="table table-hover table-striped" id = "studentlist">
          <?php
            $clubid = $_COOKIE["clubid"];
            $json = file_get_contents("http://times.bcp.org/clubs/getStudentList.php?clubid=". $clubid);
            $data = json_decode($json);
          ?>
          <tr>
            <td><strong>First Name</strong></td>
            <td><strong>Last Name</strong></td>
            <td><strong>Email</strong></td>
            <td><strong>Grade</strong></td>
            <td><strong>Actions</strong></td>
          </tr>
            <?php
              foreach($data as $object):
            ?>
              <tr>
                <td class="firstname"><?php echo $object->{'firstname'}?></td>
                <td class="lastname"><?php echo $object->{'lastname'}?></td>
                <td class = "email"><a href="mailto:<?php echo $object->{'email'}?>?Subject=<?php echo htmlentities(($_COOKIE["clubname"]));?>" target="_top"><?php echo $object->{'email'}?></a></td>
                <td><?php echo $object->{'grade'}?></td>
                <td>
                  <button class = "btn btn-default btn-xs" onclick="removeRow(this)">Remove Student</button>
                  <button class = "btn btn-default btn-xs" onclick="makeLeader(this)">Make Leader</button>
                </td>              
              </tr>
            <?php endforeach; ?>
        </table>
      </div>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    <script>

      $(function() {
        removeRow = function(el) {
          var email = $(el).parents("tr").children(".email").text();
          var firstname = $(el).parents("tr").children(".firstname").text();
          var lastname = $(el).parents("tr").children(".lastname").text();
          var confirmText = ("Are you sure you want to remove the following student from your club: ").concat(firstname, " ", lastname, "?");
          var confirmTrue = confirm(confirmText);
          if (confirmTrue) {
            $(el).parents("tr").remove();
            var clubid = (<?php echo $_COOKIE["clubid"];?>); 
            $.get( "removeWithEmail.php?clubid=" + <?php echo $_COOKIE["clubid"];?> + "&email=" + email, function( data ) { 
              console.log(data);
              $("#deletedalert").show();
            });
          }

          $("#deletedalert").show();
          
        };

        makeLeader = function(el) {
          var email = $(el).parents("tr").children(".email").text();
          var firstname = $(el).parents("tr").children(".firstname").text();
          var lastname = $(el).parents("tr").children(".lastname").text();
          var confirmText = ("Are you sure you want to make the following student a leader of your club: ").concat(firstname, " ", lastname, "?");
          var confirmTrue = confirm(confirmText);
          if (confirmTrue) {
            $.get( "makeLeaderWithEmail.php?clubid=" + <?php echo $_COOKIE["clubid"];?> + "&email=" + email, function( data ) { 
              console.log(data);
              $("#leaderalert").show();
            }); 
          }
          
        };

      });
      $(document).ready(function() {
          $("#deletedalert").hide();
          $("#leaderalert").hide();
          $("#btnExport").click(function(e) {
              //getting values of current time for generating the file name
              var dt = new Date();
              var day = dt.getDate();
              var month = dt.getMonth() + 1;
              var year = dt.getFullYear();
              var hour = dt.getHours();
              var mins = dt.getMinutes();
              var postfix = day + "." + month + "." + year + "_" + hour + "." + mins;
              //creating a temporary HTML link element (they support setting file names)
              var a = document.createElement('a');
              //getting data from our div that contains the HTML table
              var data_type = 'data:application/vnd.ms-excel';
              var table_div = document.getElementById('dvData');
              var table_html = table_div.outerHTML.replace(/ /g, '%20');
              a.href = data_type + ', ' + table_html;
              //setting the file name
              a.download = 'exported_table_' + postfix + '.xls';
              //triggering the function
              a.click();
              //just in case, prevent default behaviour
              e.preventDefault();
          });
      });
      
    </script>
  </body>
</html>