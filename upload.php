
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
    <style>
    </style>
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
            <li class="active"><a href="photoMaster.php">Photo Master List</a></li>
            <li><a href="help.php">Help</a></li>
          </ul>
          <p class="navbar-text navbar-right"></p>

        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" id="top">

      <?php
         error_reporting(E_ALL ^ E_STRICT);
         var_dump($_FILES);
         if ($_FILES['image']['name'] != '') {
            $errors= array();
            $file_name = $_FILES['image']['name'];
            $former_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_type = $_FILES['image']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
            $file_name = $_POST['id'];
            $expensions= array("jpg");
            
            if(in_array($file_ext,$expensions)=== false){
               $errors[]="extension not allowed, please choose a JPEG or PNG file.";
            }
            
            if($file_size > 10097152) {
               $errors[]='File too large';
            }
            
            if(empty($errors)==true) {
               echo '<h3>Your file, ' . $former_name .', was uploaded successfully!<h3>';
               move_uploaded_file($file_tmp,"photos/".$file_name . "." . $file_ext);
               
            }else{
               echo '<h2>Uh-oh, there were some problems uploading the file. Here are the details: ' . print_r($errors) . '</h2>';
            }
         }
         else {
            echo "<br>uh oh, there was no file sent";
         }
      ?>
      <a href="/clubs/photoUpload.php" class = "btn btn-primary btn-block "role="button">Upload More Photos</a>
      <br>
      <a href="/clubs/faceTagging.php?clubid=<?php echo $file_name?>" class = "btn btn-primary btn-block" role = "button">Go to Face Tagging for This Club</a>
    </div><!-- /.container -->
   </body>
</html>