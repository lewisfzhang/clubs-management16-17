<!doctype html>
<?php
    $studentid = 216266;
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="favicon.ico">

        <title>BCP Clubs</title>
        <style>
            .uploadbutton {
                padding-top: 10px;
            }
        </style>
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>
            $(function() {
                $("#addedalert").hide();
                $("td[colspan=3]").find("p").hide();
                $("table").click(function(event) {
                    event.stopPropagation();
                    var $target = $(event.target);
                    if ( $target.closest("td").attr("colspan") > 1 ) {
                        $target.slideUp();
                    } else {
                        $target.closest("tr").next().find("p").slideToggle();
                    }                    
                });
            });

            function orderRows() {  
                window.scrollTo(0,0);
                $("#loading").show();
                function addRow(value, joined) {
                    /*
                    if (parseInt(value.id) == 111111) {
                        return;
                    }
                    */
                    $.post('faceTaggingData.php', {option: 'c', clubid: value.id, ptdata: ""}, function(data, status) {
                        var stringToAppend = '<tr><td class="clubname">' + value.name +'</td><td class="category">' + value.meetinginfo +'</td><td class="leaders">' + value.leaders + 
                        '</td><td class="clid hidden">' + (parseInt(value.id) + 5343) +'</td><td class="description">' + value.description + '</td>';
                        if (data.substring(0,1) == 't') {
                            if (data.length > 1) {
                                var numTaggedString = data.substring(1, data.length)
                                if (numTaggedString.split("/")[0] == numTaggedString.split("/")[1]) {
                                    stringToAppend += '<td><button class = "btn btn-success btn-xs" onclick = "location.href = \'faceTagging.php?clubid='+value.id+'\'">' + numTaggedString + ' Faces Tagged </button>';
                                }
                                else {
                                    stringToAppend += '<td><button class = "btn btn-warning btn-xs" onclick = "location.href = \'faceTagging.php?clubid='+value.id+'\'">' + numTaggedString + ' Faces Tagged</button>';
                                }
                            }
                            else {
                                stringToAppend += '<td><button class = "btn btn-warning btn-xs" onclick = "location.href = \'faceTagging.php?clubid='+value.id+'\'">No Marked Faces</button>';
                            }
                            stringToAppend += '<div class = "uploadbutton"><button class = "btn btn-info btn-xs" onclick = "location.href = \'photoUpload.php?clubid='+value.id+'\'">Upload New Photo</button></div></td></tr>';
                        }
                        else {
                            stringToAppend += '<td><button class = "btn btn-primary btn-xs" onclick = "location.href = \'photoUpload.php?clubid='+value.id+'\'">No Photo Uploaded </button></td></tr>';
                        }
                        stringToAppend += ''
                        $("#clubList").append(stringToAppend);
                    });
                }
                var dataArr = null;
                var studentId = parseInt(<?php echo $studentid ?>);
                $.get("http://times.bcp.org/clubs/getClubsWithInfo.php", function(data) {
                    var dataArr = JSON.parse(data);
                    $.each(dataArr, function(index, value) {
                        addRow(value, 0);
                    });
                });
            }

            $(function() {
                console.log(<?php file_exists('/photos/111111.jpg'); ?>);
                $("#special").hide();
                $("#loading").hide();
                $("#removedalert").hide();
                orderRows();
            });
        </script>
        <style>
            #clubList {
                width:100%;
                overflow:hidden;
                text-overflow:ellipsis;
            }
            #description {
                max-width:10px;
                overflow:hidden;
                text-overflow:ellipsis;
            }f
            #loading {
                position: absolute; width: 100%; height: 100%; background: url('loading.gif') no-repeat center center;
            }
            #special {
                position: absolute; width: 100%; height: 100%; background: url('BeafutifulChanan.png') no-repeat center center;
            }
        </style>
    </head>

    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="cofllapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
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
              

            </div><!--/.nav-collapse -->
          </div>
        </nav>
        <div id = "addedalert" role="alert"></div>
        <div id = "removedalert" role="alert"></div>
        <div id="loading"></div>
        <div id = "clubz" class = "container">
            <table class="table table-hover table-striped" id = "clubList">
            </table>
        </div>
        <div id = "special"></div>
    </body>
</html>
