<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Add Students</title>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="/resources/demos/style.css">
        <style>
            .special {color:#FFFFFF;}
            #special {color:#FFFFFF;}
            #errormessage {color:#FF0000;}
            a img { display:none;}
            a:hover img { display:block; }
            .ui-autocomplete-loading {
                background: white url("loading-gif.gif") right center no-repeat;
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
                return (id.length == 6 && id.substring(0,2) == "21" && parseInt(id.substring(2,3)) > 5 && parseInt(id.substring(2,3)) < 9);
            }


            $(function() {
                function showWarning(boolean) {
                    if (boolean == false) {
                        $("#errormessage").show();
                    }
                    else {
                        $("#errormessage").hide();
                    }
                }
                $("#textarea").on('change keyup paste', function() {
                    if (bulkType == "email") {
                        console.log("Made it into email if");
                        var tempMailList = [];
                        var text = $("textarea").val();
                        text = text.replace(/[\n\r]/g, ',');
                        var bool = true;
                        text.split(",").forEach(function(entry) {
                            if (entry.length > 0) {
                                if (!checkEmail(entry)) {
                                    bool = false;
                                }
                                else {
                                    tempMailList.push(entry);
                                }
                            }
                        });
                        showWarning(bool);
                        bulkMailStudentIDList = tempMailList;
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
                    if (bulkType == "email") {
                        bulkMailStudentIDList.forEach(function(term) {
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
                                    $('#myTable tbody').append('<tr class="child"><td>'+firstname+'</td><td>'+lastname+'</td><td>'+email+'</td><td style="display:none;" class = "studid">'+id+'</td><td><button class = "btn btn-danger btn-sm" onclick="removeRow(this)">Remove Student</button></td></tr>');
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
                                    $('#myTable tbody').append('<tr class="child"><td>'+firstname+'</td><td>'+lastname+'</td><td>'+email+'</td><td style="display:none;" class = "studid">'+id+'</td><td><button class = "btn btn-danger btn-sm" onclick="removeRow(this)">Remove Student</button></td></tr>');
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
                    studentIDList.forEach(function(entry) {
                        jsonArr.push({"studentID": parseInt(entry), "clubID": clubid});
                    });
                    finalBulkList.forEach(function(entry) {
                        jsonArr.push({"studentID": parseInt(entry), "clubID": clubid});
                    });
                    console.log(JSON.stringify(jsonArr));
                    $.post("addMemberships.php", {json: JSON.stringify(jsonArr)}, function(data, status) {
                        console.log(data);
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
                            $('#myTable tbody').append('<tr class="child"><td>'+firstname+'</td><td>'+lastname+'</td><td>'+email+'</td><td class = "studid">'+id+'</td><td><button class = "btn btn-danger btn-sm" onclick="removeRow(this)">Remove Student</button></td></tr>');
                        });
                    }
                });
            });
        </script>
    </head>
    <body>
        <div class="container">
            <h3 style="text-align:center; font-family:verdana">Add a Student Manually</h3>
            <br>
            <ul class="nav nav-pills nav-justified">
              <li class="active"><a href="#setpill1">Single</a></li>
              <li><a href="#setpill2">Bulk</a></li>
            </ul>
            <div class = "tab-content" id = "searchType">
                <div class="tab-pane active" id="setpill1">
                    <p style="display: none" id="search">single</p>
                    <div class = "singleSearch">
                        <br><br>
                        <ul class="nav nav-pills nav-justified">
                          <li class="active"><a href="#pill1">Name</a></li>
                          <li><a href="#pill2">Email</a></li>
                          <li><a href="#pill3">Student ID</a></li>
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
                        <br><br><br>
                        <div style = "text-align:center" class="ui-widget">
                            <label for="tags">Search: </label>
                            <input id="tags">
                        </div>
                        <br><br><br><br><br>
                        <div class = "text-center">
                            <button type = "button" id = "addStudents" class = "btn btn-primary btn-lg">Add Student to List</button>
                        </div>
                        <br><br><br><br>
                        <div class = "special">
                            <a href="#" id = "special">~~Chanan is Beautiful~~<img src = "BeautifulChanan.png"/></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="setpill2">
                    <p style="display: none" id = "search">bulk</p>
                    <br><br>
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a href="#bulkpill1">Email</a></li>
                            <li><a href="#bulkpill2">Student ID</a></li>
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
                        <p><strong>Paste Here (entries separated by returns)<strong></p>
                        <textarea row = "300" cols = "100" id = "textarea"></textarea>
                        <br><br>
                        <button type = "button" id = "checkBulk" class = "btn btn-primary btn-lg">Add Bulk Data</button>
                    </div>
                    <br><br><br><br><br>
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
                            <td><strong>Student ID</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br><br>
            <button type = "button" id = "addList" class = "btn btn-primary btn-block disabled">Add List to Club</button>
        </div> 
    </body>
</html>