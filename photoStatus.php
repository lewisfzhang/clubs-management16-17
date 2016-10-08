<!doctype html>
<?php
    $newURL = 'http://times.bcp.org/clubs/congratulations.html';
    header('Location: '.$newURL);
    $studentid = 216266;
    $redirect = isset($_GET['clubid']);
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
                    
                    if (parseInt(value.id) == 111111 || parseInt(value.id) == 111112 || ((parseInt(value.id) > 888000) && (parseInt(value.id) < 999000))) {
                        return;
                    }
                    
                    $.post('faceTaggingData.php', {option: 'c', clubid: value.id, ptdata: ""}, function(data, status) {
                        var stringToAppend = '<tr><td class="clubname">' + value.name +'</td><td class="category">' + value.meetinginfo +'</td><td class="leaders">' + value.leaders + 
                        '</td><td class="clid hidden">' + (parseInt(value.id) + 5343) +'</td><td class="description">' + value.description + '</td>';
                        //"location.href = \'faceTaggingPublic.php?clubid='+value.id+'\'"
                        //"window.open(\'faceTaggingPublic.php?clubid='+value.id+'\', \'_blank\')"
                        if (data.substring(0,1) == 't') {
                            if (data.length > 1) {
                                var numTaggedString = data.substring(1, data.length)
                                if (numTaggedString.split("/")[0] == numTaggedString.split("/")[1]) {
                                    stringToAppend += '<td><button class = "btn btn-success btn-xs" onclick = "window.open(\'faceTaggingPublic.php?clubid='+value.id+'\', \'_blank\')">' + numTaggedString + ' Faces Tagged </button></td></tr>'
                                }
                                else {
                                    stringToAppend += '<td><button class = "btn btn-primary btn-xs" onclick = "window.open(\'faceTaggingPublic.php?clubid='+value.id+'\', \'_blank\')">' + numTaggedString + ' Faces Tagged</button></td></tr>'
                                }
                            }
                            else {
                                stringToAppend += '<td><button class = "btn btn-primary btn-xs" onclick = "window.open(\'faceTaggingPublic.php?clubid='+value.id+'\', \'_blank\')">No Marked Faces</button></td></tr>'
                            }
                        }
                        else {
                            stringToAppend += '<td><button disabled class = "btn btn-default btn-xs">No Photo Uploaded</button></td></tr>';
                        }
                        stringToAppend += ''
                        $("#clubList").append(stringToAppend);
                    });
                }
                var dataArr = null;
                var studentId = parseInt(<?php echo $studentid ?>);
                $.get("http://times.bcp.org/clubs/getClubsWithInfo.php", function(data) {
                    var dataArr = JSON.parse(data);
                    $("#clubList tr").remove();
                    $("#clubList").append("<tr><td><strong>Club Name</strong></td><td><strong>Meeting Info</strong></td><td><strong>Leaders</strong></td><td><strong>Description</strong></td><td><strong>Action</strong></td></tr>");
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
                <?php if($redirect) {echo 'openNav()';} ?>
            });

            function openNav() {
                document.getElementById("myNav").style.height = "100%";
            }

            function closeNav() {
                document.getElementById("myNav").style.height = "0%";
            }
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
                position: absolute; width: 100%; height: 100%; background: url('loafding.gif') no-repeat center center;
            }
            #special {
                position: absolute; width: 100%; height: 100%; background: url('BeafutifulChanan.png') no-repeat center center;
            }
            .overlay {
                height: 0%;
                width: 100%;
                position: fixed;
                z-index: 1;
                top: 0;
                left: 0;
                background-color: rgb(0,0,0);
                background-color: rgba(0,0,0, 0.9);
                overflow-y: hidden;
                transition: 0.5s;
            }

            .overlay-content {
                position: relative;
                top: 25%;
                width: 100%;
                text-align: center;
                margin-top: 30px;
            }

            .overlay a {
                padding: 8px;
                text-decoration: none;
                font-size: 36px;
                color: #818181;
                display: block;
                transition: 0.3s;
            }

            .overlay a:hover, .overlay a:focus {
                color: #f1f1f1;
            }

            .closebtn {
                position: absolute;
                top: 20px;
                right: 45px;
                font-size: 60px !important;
            }

            @media screen and (max-height: 450px) {
              .overlay {overflow-y: auto;}
              .overlay a {font-size: 20px}
              .closebtn {
                font-size: 40px !important;
                top: 15px;
                right: 35px;
              }
        </style>
    </head>

    <body>
        <div id="myNav" class="overlay">
          <!-- <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>-->
          <div class="overlay-content">
            <a style="margin:auto;border:1px solid gray;width:40%;"" onclick="<?php if($redirect) {echo 'closeNav();location.href=\'http://times.bcp.org/clubs/photoStatus.php\';window.open(\'faceTaggingPublic.php?clubid=' . $_GET['clubid'] . '\', \'_blank\')';} ?>">Start Tagging</a>
          </div>
        </div>
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
