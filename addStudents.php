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

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css">
    
    <style>
      body {
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif !important;
        font-size: 14px;
      }
      .special {color:#FFFFFF;}
      #special {color:#FFFFFF;}
      #errormessage {color:#FF0000;}
      a img { display:none;}
      a:hover img { display:block; }
      .ui-autocomplete-loading {
          background: white url("loading-gif.gif") right center no-repeat;
      }

      .nav-pill {
        background-color: gray;
      }
    </style>

    <script>
            var currentTab = "name";
            var searchType = "single";
            var bulkType = "email";
            var globalDataStore = "";
            var studentIDList = [];
            var bulkMailStudentIDList = [];
            var bulkIDStudentList = [];
            var finalBulkList = [];
            $(function() {
                $( "#tags" ).autocomplete({
                    source: "nameautocomplete.php",
                    minLength: 3
                });
            });
            $(document).ready(function() {
                $(".nav-pills a").click(function() {
                    $("#errormessage").hide();
                    $(this).tab('show');
                    var $typetab = $('#searchType'), $typeactive = $typetab.find('.tab-pane.active'), typetext = $typeactive.find('#search').text();
                    console.log(typetext);
                    
                    if (typetext=="single") {
                        searchType = "single";
                        var $tab = $('#myTabContent'), $active = $tab.find('.tab-pane.active'), text = $active.find("#singletype").text();
                        if (text != "" && text != " ") {
                            currentTab = text;
                        }
                        else {
                            currentTab = "name";
                        }
                        console.log(currentTab);
                        makeRequest(currentTab);
                    }
                    else {
                        console.log("made it");
                        var $bulktab = $('#myTabContentBulk'), $bulkactive = $bulktab.find('.tab-pane.active'), bulktype = $bulkactive.find('#bulktype').text();
                        console.log(bulktype);
                        if (bulktype != "" && bulktype != " ") {
                            bulkType = bulktype;
                        }
                        if (bulkType == "studentid") {
                            $("#errormessage").text("Invalid Student ID Detected");
                        }
                        console.log(bulkType);
                    }
                });
            });
            function sendToServer() {

            }
            function makeRequest(type) {
                var availableTags = [];
                var minLength = 3;
                var sourceURL = ""
                if (type == "email") {
                     sourceURL = "emailautocomplete.php";
                }
                else if (type == "name") {
                     sourceURL = "nameautocomplete.php";
                }
                else if (type == "studentid") {
                     sourceURL = "studentidautocomplete.php";
                     minLength = 6;
                }
                $( "#tags" ).autocomplete({
                    source: sourceURL,
                    minLength: minLength
                });
            }

            function checkEmail(email) {
                return (email.indexOf("@bcp.org") > -1 && email.indexOf(".") > -1 && email.indexOf("1") > -1);
            }

            function checkID(id) {
                return (id.length == 6 && id.substring(0,2) == "21" && parseInt(id.substring(2,3)) > 5 && parseInt(id.substring(2,3)) < 10);
            }


            $(function() {
                var url = window.location.href;
                var lastPart = url.substr(url.lastIndexOf('?') + 1);
                if (lastPart === "suc") {
                    $("#addedalert").show();
                }
                else {
                    $("#addedalert").hide();
                }
                function showWarning(boolean) {
                    if (boolean == false) {
                        $("#errormessage").show();
                    }
                    else {
                        $("#errormessage").hide();
                    }
                }
                function extractEmails (text){
                    return text.match(/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/gi);
                }
                $("#textarea").on('change keyup paste', function() {
                    if (bulkType == "email") {
                        console.log("Made it into email if");
                        var tempMailList = [];
                        var text = $("textarea").val();
                        bulkMailStudentIDList = extractEmails(text);
                        
                    }
                    else {
                        var tempIDList = [];
                        var text = $("textarea").val();
                        text = text.replace(/[\n\r]/g, ',');
                        var bool = true;
                        text.split(",").forEach(function(entry) {
                            if (entry.length > 0) {
                                if (!checkID(entry)) {
                                    bool = false;
                                }
                                else {
                                    tempIDList.push(entry);
                                }
                            }
                        }); 
                        showWarning(bool);
                        bulkIDStudentList = tempIDList;
                        console.log(tempIDList);
                    }
                });


                $('#checkBulk').on('click', function(event) {
                    console.log(bulktype);
                    var errorCount = 0;
                    if (bulkType == "email") {
                        bulkMailStudentIDList.forEach(function(term, index) {
                            $.get( "getDataFromEmail.php?email=" + term, function( data ) { 
                                if (data != "FAIL") {
                                    var result = JSON.parse(data);
                                    var id = result["id"];
                                    var firstname = result["firstname"];
                                    var lastname = result["lastname"];
                                    var email = result["email"];
                                    console.log(firstname);
                                    finalBulkList.push(id);
                                    if(finalBulkList.length == 0 && studentIDList.length == 0){
                                        $("#addList").addClass("disabled");
                                    }
                                    else {
                                        $("#addList").removeClass("disabled");
                                    }
                                    console.log(studentIDList);
                                    $('#myTable tbody').append('<tr class="child"><td>'+firstname+'</td><td>'+lastname+'</td><td>'+email+'</td><td style="display:none;" class = "studid">'+id+'</td><td><button class = "btn btn-danger btn-xs" onclick="removeRow(this)">Remove Student</button></td></tr>');
                                }
                                else {
                                    errorCount++;
                                }
                            if(index+1 >= bulkMailStudentIDList.length && errorCount > 0) {
                                alert("" + errorCount + " of " + bulkMailStudentIDList.length + " emails were invalid and were not processed");
                            }
                            });
                        });
                        
                    }
                    else {
                        bulkIDStudentList.forEach(function(term) {
                            $.get( "getDataFromId.php?id=" + parseInt(term), function( data ) { 
                                if (data != "FAIL") {
                                    var result = JSON.parse(data);
                                    var id = result["id"];
                                    var firstname = result["firstname"];
                                    var lastname = result["lastname"];
                                    var email = result["email"];
                                    console.log(firstname);
                                    finalBulkList.push(id);
                                    if(finalBulkList.length == 0 && studentIDList.length == 0){
                                        $("#addList").addClass("disabled");
                                    }
                                    else {
                                        $("#addList").removeClass("disabled");
                                    }
                                    console.log(studentIDList);
                                    $('#myTable tbody').append('<tr class="child"><td>'+firstname+'</td><td>'+lastname+'</td><td>'+email+'</td><td style="display:none;" class = "studid">'+id+'</td><td><button class = "btn btn-danger btn-xs" onclick="removeRow(this)">Remove Student</button></td></tr>');
                                }
                            });
                        });
                    }
                })

                removeRow = function(el) {
                    var studid = $(el).parents("tr").children(".studid").text();
                    var index = $.inArray(studid, studentIDList);
                    if(~index) {
                        studentIDList.splice(index, 1);
                    }
                    var bulkindex = $.inArray(studid, finalBulkList);
                    if(~bulkindex) {
                        finalBulkList.splice(index, 1);
                    }
                    $(el).parents("tr").remove();
                    if (document.getElementById("myTable").rows.length < 2) {
                        studentIDList = [];
                        finalBulkList = [];
                    }
                    if(studentIDList.length == 0 && finalBulkList.length == 0){
                        $("#addList").addClass("disabled");
                    }
                    else {
                        $("#addList").removeClass("disabled");
                    } 
                    console.log(studentIDList);
                    console.log(finalBulkList);      
                };
                $('#addList').on('click', function(event) {
                    var jsonArr = [];
                    var clubid = <?php echo $_COOKIE['clubid'];?>;
                    $.each(studentIDList, function(index, value) {
                        jsonArr.push({"studentID": parseInt(value), "clubID": clubid});
                        console.log(value);
                    });
                    $.each(finalBulkList, function(index, value) {
                        jsonArr.push({"studentID": parseInt(value), "clubID": clubid});
                        console.log(value);
                    });
                    console.log(JSON.stringify(jsonArr));
                    $.post("addMemberships.php", {json: JSON.stringify(jsonArr)}, function(data, status) {
                        console.log(data);
                        if (!($("#addList").hasClass("disabled"))) {
                            window.location.replace("http://times.bcp.org/clubs/addStudents.php?suc");
                        }
                    });
                });
                $('#addStudents').on('click', function(event) {
                    event.preventDefault(); 
                    console.log(currentTab);
                    var textBoxValue = $("#tags").val();
                    $("#tags").val("");
                    if (textBoxValue.length > 0) {
                        $.get( "getIDFromName.php?input=" + textBoxValue, function( data ) {
                            console.log(data);
                            var result = JSON.parse(data);
                            var id = result["id"];
                            var firstname = result["firstname"];
                            var lastname = result["lastname"];
                            var email = result["email"];
                            studentIDList.push(id);
                            if(studentIDList.length == 0){
                                $("#addList").addClass("disabled");
                            }
                            else {
                                $("#addList").removeClass("disabled");
                            }
                            console.log(studentIDList);
                            $('#myTable tbody').append('<tr class="child"><td>'+firstname+'</td><td>'+lastname+'</td><td>'+email+'</td><td style="display: none;" class = "studid">'+id+'</td><td><button class = "btn btn-danger btn-xs" onclick="removeRow(this)">Remove Student</button></td></tr>');
                        });
                    }

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
        <li><a href="index.php">Information</a></li>
        <li><a href="roster.php">Roster</a></li>
        <li class="active"><a href="#">Add Members</a></li>
        <li><a href="email.php">Emails</a></li>
        <li><a href="feedback.php">Feedback</a></li>
      </ul>

      <div class="container" style="margin-top: 30px;">


<!--         <div class="row" style="padding-bottom:10px">

          <div class="col-sm-5">

            <div class="btn-group btn-group-justified" role="group" aria-label="mode1">
              <div class="btn-group" role="group">
                <button id="single-add" type="button" class="btn btn-primary">Single Add (Search)</button>
              </div>
              <div class="btn-group" role="group">
                <button id="bulk-add" type="button" class="btn btn-default">Bulk Add (Paste in a List)</button>
              </div>
            </div>

          </div>

          <div class="col-sm-7">

            <div class="btn-group btn-group-justified" role="group" aria-label="mode2">
              <div class="btn-group" role="group">
                <button id="single-add" type="button" class="btn btn-primary">Name</button>
              </div>
              <div class="btn-group" role="group">
                <button id="bulk-add" type="button" class="btn btn-default">Email</button>
              </div>
              <div class="btn-group" role="group">
                <button id="bulk-add" type="button" class="btn btn-default">Student ID</button>
              </div>
            </div>

          </div>

        </div> -->

        <div class="alert alert-success" id = "addedalert" role="alert">Members added successfully.</div>

        

          </div>
            <ul class="nav nav-pills nav-justified">
              <li class="active"><a href="#setpill1">Single (Search for Student)</a></li>
              <li><a href="#setpill2">Bulk (Paste in List)</a></li>
            </ul>
            <div class = "tab-content" id = "searchType">
                <div class="tab-pane active" id="setpill1">
                    <p style="display: none" id="search">single</p>
                    <div class = "singleSearch">
                        <br>
                        <ul class="nav nav-pills nav-justified">
                          <li class="active"><a href="#pill1">Find by Name</a></li>
                          <li><a href="#pill2">Find by Email</a></li>
                          <li><a href="#pill3">Find by Student ID</a></li>
                        </ul>
                        <br>
                        <div class = "tab-content" id = "myTabContent">
                            <div class="tab-pane" id="pill2">
                                <p style="display: none" id = "singletype">email</p>
                            </div>
                            <div class="tab-pane" id="pill1">
                                <p style="display: none"id = "singletype">name</p>
                            </div>
                            <div class="tab-pane" id="pill3">
                                <p style="display: none"id = "singletype">studentid</p>
                            </div>
                        </div>
                        <br><br>
                        <div style = "text-align:center" class="ui-widget">
                            <div class="form-inline">
                              <div class="form-group">

                                <label style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px;" for="tags">Search: </label>
                                <input type="text" class="form-control" id="tags">
                              </div>
                              <div class="form-group">
                                <button style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 14px;" type = "button" id = "addStudents" class = "btn btn-primary">Add Student to List</button>
                              </div>
                            </div>
                          </div>
                        <br>
                    </div>
                </div>
                <div class="tab-pane" id="setpill2">
                    <p style="display: none" id = "search">bulk</p>
                    <br><br>
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a href="#bulkpill1">Paste in Emails</a></li>
                            <li><a href="#bulkpill2">Paste in Student IDs</a></li>
                        </ul>
                        <br>
                        <div class = "tab-content" id = "myTabContentBulk">
                            <div class="tab-pane" id="bulkpill1">
                                <p style="display: none" id = "bulktype">email</p>
                            </div>
                            <div class="tab-pane" id="bulkpill2">
                                <p style="display: none" id = "bulktype">studentid</p>
                            </div>
                        </div>
                    <br><br>
                    <div class = "text-center" id = "errormessage">
                        <p>Warning: Non-BCP Emails Detected</p>
                    </div>
                    <br>
                    <div class = "text-center">
                        <p><strong>Paste Emails/IDs Here</strong></p>
                        <textarea class="form-control" rows="10" id = "textarea"></textarea>
                        <br><br>
                        <button type = "button" id = "checkBulk" class = "btn btn-primary btn-lg">Add Bulk Data</button>
                    </div>
                    <br><br><br>
                </div>
            </div>
            <br><br><br>
            <div class = "text-center">
                <table id="myTable" class="table table-hover table-striped">
                    <tbody>
                        <tr>
                            <td><strong>First Name</strong></td>
                            <td><strong>Last Name</strong></td>
                            <td><strong>Email</strong></td>
                            <td style="display:none;"><strong>Student ID</strong></td>
                            <td><strong>Remove</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br><br>
            <button type = "button" id = "addList" class = "btn btn-primary btn-block disabled">Add List to Club</button>
            <br><br>
        </div> 

    </div><!-- /.container -->
  </body>
</html>