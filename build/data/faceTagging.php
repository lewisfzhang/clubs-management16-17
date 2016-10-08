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
  <style>
  #photo:hover .rect {
    opacity: .75;
    transition: opacity .75s ease-out;
  }

  .rect:hover * {
    opacity: 1;
  }

  .rect {
    border-radius: 2px;
    border: 3px solid white;
    box-shadow: 0 16px 28px 0 rgba(0, 0, 0, 0.3);
    cursor: pointer;
    left: -1000px;
    opacity: 0;
    position: absolute;
    top: -1000px;
  }

  .arrow {
    border-bottom: 10px solid white;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    height: 0;
    width: 0;
    position: absolute;
    left: 50%;
    margin-left: -5px;
    bottom: -12px;
    opacity: 0;
  }

  input {
    border: 0px;
    bottom: -42px;
    color: #a64ceb;
    font-size: 15px;
    height: 30px;
    left: 50%;
    margin-left: -90px;
    opacity: 0;
    outline: none;
    position: absolute;
    text-align: center;
    width: 180px;
    transition: opacity .35s ease-out;
  }

  #img {
    position: absolute;
    top: 50%;
    left: 50%;
    margin: -173px 0 0 -300px;
  }
  </style>
    <title>BCP Clubs</title>
    <link rel="stylesheet" href="assets/demo.css">

    <script src="/build/tracking-min.js"></script>
    <script src="/build/data/face-min.js"></script>
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
      <div class = "picture-container">
        <span id="photo"><img id="img" src="SmilingFaces.jpg" /></span>
      </div>
    </div>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css"><!-- /.container -->
    <script>
      window.onload = function() {
        var img = document.getElementById('img');

        var tracker = new tracking.ObjectTracker('face');

        tracking.track(img, tracker);

        tracker.on('track', function(event) {
          event.data.forEach(function(rect) {
            plotRectangle(rect.x, rect.y, rect.width, rect.height);
          });
        });

        var friends = [ 'Thomas Middleditch', 'Martin Starr', 'Zach Woods' ];
        var evenMoreFriends = ["William Williamditch", "Rohan Menenzes", "James Woods", "Chanan Walia", "Kevin Bacon", "Robert Jim"];

        var plotRectangle = function(x, y, w, h) {
          var rect = document.createElement('div');
          var arrow = document.createElement('div');
          var input = document.createElement('input');

          $(input).autocomplete({
             source: evenMoreFriends,
             minLength: 3
          });

          rect.onclick = function name() {
            input.select();
          };

          arrow.classList.add('arrow');
          rect.classList.add('rect');

          rect.appendChild(input);
          rect.appendChild(arrow);
          document.getElementById('photo').appendChild(rect);

          rect.style.width = w + 'px';
          rect.style.height = h + 'px';
          rect.style.left = (img.offsetLeft + x) + 'px';
          rect.style.top = (img.offsetTop + y) + 'px';
        };
      };
    </script>
  </body>
</html>