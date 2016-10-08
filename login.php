
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Club Sign In</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">

    <script src="js/ie-emulation-modes-warning.js"></script>

  </head>

  <body>

    <div class="container">

        <form class="form-signin" action="authenticateLogin.php" method="get">
          <h2 class="form-signin-heading">Club Sign In</h2>
          <?php 
          if (isset($_GET["state"])) {
            if ($_GET["state"] == 2) {
              echo("<div class=\"alert alert-danger\" role=\"alert\">Failed to authenticate. Either student ID is invalid, club ID is invalid, or you are not a leader of this club.</div>");
            }
            if ($_GET["state"] == 3) {
              echo("<div class=\"alert alert-info\" role=\"alert\">Successfully logged out.</div>");
            }
          }
          ?>
          <label for="studentid" class="sr-only">Club Leader Student ID</label>
          <input type="text" name="studentid" id="studentid" class="form-control" placeholder="Club Leader Student ID" required autofocus>
          <label for="clubid" class="sr-only">Club ID</label>
          <input type="text" style="margin-top: 10px;" name="clubid" id="clubid" class="form-control" placeholder="Club ID" required>
          <!--<div class="checkbox">
            <label>
              <input type="checkbox" value="remember-me"> Remember me
            </label>
          </div> -->
          <button style="margin-top: 20px;"class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </form>

      </div>

    </div>

    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
