<!DOCTYPE html>

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
/*Copied from bootstrap */
       .btn {
          display: inline-block;
          padding: 6px 12px;
          margin-bottom: 0;
          font-size: 14px;
          font-weight: normal;
          line-height: 1.42857143;
          text-align: center;
          white-space: nowrap;
          vertical-align: middle;
          cursor: pointer;
          -webkit-user-select: none;
          -moz-user-select: none;
          -ms-user-select: none;
          user-select: none;
          background-image: none;
          border: 1px solid transparent;
          border-radius: 4px;
      }
      /*Also */
       .btn-success {
          color: #fff;
          background-color: #5cb85c;
          border-color: #4cae4c;
      }
      /* This is copied from https://github.com/blueimp/jQuery-File-Upload/blob/master/css/jquery.fileupload.css */
       .fileinput-button {
          position: relative;
          overflow: hidden;
      }
      /*Also*/
       .fileinput-button input {
          position: absolute;
          top: 0;
          right: 0;
          margin: 0;
          opacity: 0;
          -ms-filter:'alpha(opacity=0)';
          font-size: 200px;
          direction: ltr;
          cursor: pointer;
      }
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
          <p class="navbar-text navbar-right"></p>f

        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" id="top">
      <br><br><br>
      <label for="basic-url">Enter the Club's ID</label>
      <form action = "upload.php" id = 'uploadForm' method="post" enctype='multipart/form-data'>
        <div class="input-group">
          <span class="input-group-addon">times.bcp.org/clubs/photos/</span>
          <input name = 'id' id = "idinput" type="text"  maxlength = "6" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control" id="basic-url" aria-describedby="basic-addon3">
          <span class="input-group-addon" id="idinput">.jpg</span>
        </div>
          <br>
          Select image to upload:
          <span class="btn btn-success fileinput-button">
          <span style = 'font-family: verdana;'>Select file</span>
          <input type="file" id = "fileToUpload" name = "image">
          </span><br><br>
          <button disabled type = "submit" id = "upload" class = "btn btn-primary btn-block ">No Club Selected</button>
      </form>
      <br><br>
      <img id="img" src="#" alt="your image" />
      
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    <script>
      var isValid = false;
      var clubName = "";
      var fileSelected = false;
     function readURL() {
        var input = document.getElementById('fileToUpload');
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#img')
                  .attr('src', e.target.result)
                  .width($('#upload').width());
                  //.height(200);
          };
          reader.readAsDataURL(input.files[0]);
          $('#img').show();
        }
      }
      function checkButton() {
        if (isValid) {
          if (!fileSelected) {
            document.getElementById('upload').disabled = true;
            $('#upload').html('Choose Photo to Upload for ' + clubName);
          }
          else {
            var fileName = document.getElementById('fileToUpload').value
            if (fileName.substring(fileName.length - 3, fileName.length).toLowerCase() != "jpg") {
              document.getElementById('upload').disabled = true;
              $('#upload').html('The File Must be a JPG');             
            }
            else {
              $('#upload').html('Upload Photo for ' + clubName);
              document.getElementById('upload').disabled = false;  
            }          
          }
        }
        else {
          document.getElementById('upload').disabled = true
          $('#upload').html('No Valid Club ID Entered');         
        }
      }
      function setButton() {
        var text = $('#idinput').val();
        if (text.length == 6 ) {
          console.log('/clubs/getDataFromId.php?id=' + text);
          $.get( "getDataFromClubID.php?id=" + parseInt(text), function( data, status ) { 
            if (status == 'success' && data != 'FAIL') {
              var name = JSON.parse(data)['name'];
              clubName = name;
              isValid = true;
              checkButton();
              //document.getElementById('fileToUpload').action = 'times.bcp.org/clubs/upload.php?id=' + text;
              console.log(document.getElementById('fileToUpload').action);
            }
            else {
              isValid = false;
              checkButton();
            }
          });
        }
      }
      $(function() {
        $('#img').hide();
        $('#fileToUpload').change(function() {
          if (document.getElementById('fileToUpload').value != "") {
            fileSelected = true;
            readURL();
          }
          checkButton();
        })
        $('#idinput').on('input', function() {
          setButton();
        });
        var clubid = '<?php if(isset($_GET['clubid'])){echo($_GET['clubid']);} ?>';
        if (clubid.length > 0) {
          $("#idinput").val(clubid);
          setButton();
        }
      });
    </script>
  </body>
</html>