<!doctype html>
<?php
  $studentid = NULL;
  $email = NULL;
  if (!isset($_COOKIE["studentid"]) && !isset($_GET['studentid'])) {
      echo "you ain't got the cookies for the job, son";
      header("Location: http://times.bcp.org/clubs/browseLogin.php?state=0") ;
  }
  else {
    if (isset($_COOKIE["studentid"])) {
        $studentid = $_COOKIE["studentid"];
        $email = $_COOKIE["studentemail"];
    }
    else {
        $studentid = $_GET["studentid"];
        $email = $_GET["email"];
    }
  }
  $data = (file_get_contents("http://times.bcp.org/clubs/getDataFromId.php?id=" . $studentid));
  $emailData = file_get_contents("http://times.bcp.org/clubs/getDataFromEmail.php?email=" . $email);
  if (!(($data) == ($emailData))) {
    header("Location: http://times.bcp.org/clubs/browseLogin.php?state=1") ;
  }
  else {
    $actualData = json_decode($emailData);
    $studentname = $actualData->{'firstname'} . " " . $actualData->{'lastname'};
    $studentemail = $actualData->{'email'};
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
            var joinClub = function(el) {
                var moddedClubId = $(el).parents("tr").children(".clid").text();
                var clubName = $(el).parents("tr").children(".clubname").text();
                var realClubId = parseInt(moddedClubId) - 5343;
                var studentId = parseInt(<?php echo $studentid ?>);
                var jsonObj = new Object();
                jsonObj.studentID = studentId;
                jsonObj.clubID = realClubId;
                $.post("addMemberships.php", {json: "["+JSON.stringify(jsonObj)+"]"}, function(data, status) {
                    if (status == "success") {
                        console.log(data);
                        orderRows();
                        $("#addedalert").html('<div class="alert alert-success" role="alert"> You were successfully added to the ' + clubName + '.</div>');
                        $("#addedalert").fadeIn();
                        $("#removedalert").fadeOut();
                    }
                });
            }

            var manageClub = function(el) {
                var moddedClubId = $(el).parents("tr").children(".clid").text();
                var realClubId = parseInt(moddedClubId) - 5343;
                window.location.href = "authenticateLogin.php?studentid=" + <?php echo $studentid; ?> + "&clubid=" + realClubId;
            }

            var removeFromClub = function(el) {
                var moddedClubId = $(el).parents("tr").children(".clid").text();
                var clubName = $(el).parents("tr").children(".clubname").text();
                var realClubId = parseInt(moddedClubId) - 5343;

                var email = (<?php echo json_encode($studentemail) ?>);
                $.get( "http://times.bcp.org/clubs/removeWithEmail.php?email=" + email + "&clubid=" + realClubId, function( data ) { 
                    if(data == "Record deleted successfully") {
                        console.log(data);
                        orderRows();
                        $("#removedalert").html('<div class="alert alert-danger" role="alert">You were successfully removed from ' + clubName + '.</div>');
                        console.log("APPLES GOT HERE");
                        $("#removedalert").fadeIn();
                        $("#addedalert").fadeOut();
                    }
                });
            }


            function orderRows() {  
                window.scrollTo(0,0);
                $("#loading").show();
                function addRow(value, joined) {
                    if (parseInt(value.id) == 111111) {
                        return;
                    }
                    var stringToAppend = '<tr><td class="clubname">' + value.name +'</td><td class="category">' + value.meetinginfo +'</td><td class="leaders">' + value.leaders + 
                    '</td><td class="clid hidden">' + (parseInt(value.id) + 5343) +'</td><td class="description">' + value.description + '</td>';
                    if (joined == 0) {
                        stringToAppend += '<td><button class = "btn btn-primary btn-xs" onclick="manageClub(this)">Manage Club</button></td></tr>';
                    }
                    else if (joined == 1) {
                        stringToAppend += '<td><button class = "btn btn-danger btn-xs" onclick="removeFromClub(this)">Leave Club</button></td></tr>';
                    }
                    else {
                        stringToAppend += '<td><button class = "btn btn-success btn-xs" onclick="joinClub(this)">Join Club</button></td></tr>';
                    }
                    stringToAppend += ''
                    $("#clubList").append(stringToAppend);
                }
                var dataArr = null;
                var studentId = parseInt(<?php echo $studentid ?>);
                $.get("http://times.bcp.org/clubs/getClubsWithInfo.php", function(data) {
                    var dataArr = JSON.parse(data);
                    var copy = dataArr.slice(0);
                    var joinedClubs = [];
                    var leaderClubs = [];
                    var others = [];
                    var indices = [];
                    var leaderIndices = [];
                    var i = 0;
                    $.each(dataArr, function(index, value) {
                        $.get("http://times.bcp.org/clubs/clubStatus.php?studentid=" + <?php echo $studentid ?> + "&clubid=" + value.id, function(data) {
                            if (data == "MEMBER") {
                                indices.push(index);
                            }
                            else if (data == "LEADER") {
                                leaderIndices.push(index);
                            }
                            if (index >= dataArr.length - 1) {
                                console.log(indices);
                                $.each(dataArr, function(index2, value2) {
                                    if (indices.indexOf(index2) > -1) {
                                        joinedClubs.push(dataArr[index2]);
                                    }
                                    else if (leaderIndices.indexOf(index2) > -1) {
                                        leaderClubs.push(dataArr[index2]);
                                    }
                                    else {
                                        others.push(dataArr[index2]);
                                    }
                                });
                                $("#clubList tr").remove();
                                $("#clubList").append("<tr><td><strong>Club Name</strong></td><td><strong>Meeting Info</strong></td><td><strong>Leaders</strong></td><td><strong>Description</strong></td><td><strong>Action</strong></td></tr>");
                                console.log(joinedClubs.length);
                                $.each(leaderClubs, function(index, value) {
                                    addRow(value, 0);
                                });
                                $.each(joinedClubs, function(index, value) {
                                    addRow(value, 1);
                                });
                                $.each(others, function(index, value) {
                                    addRow(value, 2);
                                });
                                $("#loading").hide();
                            }
                        });
                    });
                });
            }

            $(function() {
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
            }
            #loading {
                position: absolute; width: 100%; height: 100%; background: url('loading.gif') no-repeat center center;
            }
            #special {
                position: absolute; width: 100%; height: 100%; background: url('BeautifulChanan.png') no-repeat center center;
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
                <li class="active"><a href="index.php">Manage Club</a></li>
                <li><a href="help.php">Help</a></li>
              </ul>
              <p class="navbar-text navbar-right">Signed in as <?php echo $studentname;?> (<a href= <?php if (isset($_COOKIE["studentid"])){echo "logout.php";}else{echo "browse.php";}?> class="navbar-link">Sign Out</a>)</p>

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
