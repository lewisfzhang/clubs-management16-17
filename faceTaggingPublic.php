<!DOCTYPE html>

<?php
  $newURL = 'http://times.bcp.org/clubs/congratulations.html';
  header('Location: '.$newURL);
  $oneWeek = (7 * 24 * 60 * 60);
  $showModal = false;
  if (isset($_COOKIE['last_logged_time'])) {
    $showModal =  (time() - $_COOKIE['last_logged_time'] > $oneWeek);
  } 
  else {
    setCookie('last_logged_time', time(), time() + 2 * $oneWeek);
    $showModal = true;
  }
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="favicon.ico">
  <style>

  /*
  .rect:hover * {
    opacity: 1;
    visibility:visible;
  }
  */

  .rect {
    border-radius: 2px;
    border: 3px solid white;
    box-shadow: 0 16px 28px 0 rgba(0, 0, 0, 0.3);
    cursor: pointer;
    left: -1000px;
    opacity: 1;
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
    opacity: 1;
    /*visibility:hidden;*/
  }

  .createdInput {
    border: 0px;
    bottom: -42px;
    color: #a64ceb;
    font-size: 15px;
    height: 30px;
    left: 50%;
    margin-left: -90px;
    opacity: 1;
    outline: none;
    position: absolute;
    text-align: center;
    width: 180px;
    z-index: 5;
    /*visibility:hidden;*/
    transition: visibility 0s,opacity .35s ease-out;
  }
  #img {
    width:110%;
  }
  #urlinput {
    padding-left:80px;
  }
  div.buttons {
    display:inline-block;
  }
  #loading {
      position: absolute; width: 100%; height: 100%; background: url('loading.gif') no-repeat center center;
  }
  hr.divider{
      border-top: 5px solid;
      width:100%;
  }
  .namedisplay{
    width:50%;
    margin: 0 auto;
  }
  </style>
    <title>BCP Clubs</title>
    <link rel="stylesheet" href="assets/demo.css">

    <script src="build/tracking-min.js"></script>
    <script src="build/data/face-min.js"></script>
    <script src="build/html2canvas.js"></script>
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
          <a class="navbar-brand" href="">Bellarmine Clubs</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="photoStatus.php">Club List</a></li>
            <li><a onclick="$('#myModal').modal()">Help</a></li>
          </ul>
          <p class="navbar-text navbar-right"></p>

        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Looks like you're new here!</h4>
          </div>
          <div class="modal-body">
            <p>Here's some quick tips on tagging:</p>
            <ul>
              <li>Mouse over a person's tagged face to see who it is.</li>
              <li>Faces with green tags have already been named, but faces with white rectangles still need to be named!</li>
              <br>
              <li>The textboxes under tagged faces will autocomplete the student's name after three letters have been entered.</li>
              <li>You must choose a name from the autocomplete dropdown, otherwise your text will be automatically deleted, even if you type out the student's full name</li>
              <li>If the dropdown isn't showing up when a student's name is entered, try only entering the first 3 or 4 letters of their first name</li>
              <br>
              <li><b>Once you're done tagging, make sure to exit by clicking "Confirm and Close."</b> Confirming your changes sends a confirmation email to each person you've named</li>
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Got It</button>
          </div>
        </div>
        
      </div>
    </div>


    <div class="modal fade" id="mobileModal" role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Uh oh! Looks like you're on a mobile device.</h4>
          </div>
          <div class="modal-body">
            <p>Unfortunately, this site was't designed for use on a smartphone. Although you can see your club photo and your friend's tags, you won't be able to tag anyone unless you use
              a computer or your iPad.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Got It</button>
          </div>
        </div>
        
      </div>
    </div>
    <div id="loading"></div>
    <div class="container" id="top">
      <br><br>
      <div class = "buttons">
        <!--<button onclick = "saveChanges()" type="button" class="btn">Save Changes</button>-->
        
        <form method = "post" action = "mailto:amit.mondal16@bcp.org,chanan.walia16@bcp.org?subject=Issue on Face Tagging Page"/>
        <button id = "confirmButton" onclick = "confirmAndClose()" type="button" class="btn btn-primary">Confirm and Close</button>
        <button type="submit" class="btn">Report Issue</button>
        <img style = "width:28px; margin-left:10px;"id = "smallLoading" src = "smallLoading.gif"></img>
        </form>
      </div>
      <br><br>
      <div class = "picture-container">
        <span id="photo"><img id="img" src="/clubs/photos/<?php echo $_GET['clubid'];?>.jpg" /></span>
      </div>
      <br><br>
    </div>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css"><!-- /.container -->
    <script> 
     // http://html-generator.weebly.com/html-right-click-disable-code.html 
     var tenth = ''; 
     
     function ninth() { 
       if (document.all) { 
         (tenth); 
         return false; 
       } 
     } 
     
     function twelfth(e) { 
       if (document.layers || (document.getElementById && !document.all)) { 
         if (e.which == 2 || e.which == 3) { 
           (tenth); 
           return false; 
         } 
       } 
     } 
     if (document.layers) { 
       document.captureEvents(Event.MOUSEDOWN); 
       document.onmousedown = twelfth; 
     } else { 
       document.onmouseup = twelfth; 
       document.oncontextmenu = ninth; 
     } 
     document.oncontextmenu = new Function('return false;') 
    </script>

    <script>
      //Amit Mondal '16
      var ignoreResize = false;
      var tempTags = [];
      var interactedTags = [];
      var colorCounter = 0;
      var sessionStore;// used to track changes made during this session
      var disableInputs = false;
      var isTouchG = false;
      //Tag objects store position (x, y), width, height, and name for each tag
      function Tag (x, y, w, h, name) {
        this.x = x;
        this.y = y;
        this.width = w;
        this.height = h;
        this.name = name;
      }
      var areas = [];
      var loadTracking = function() {
        var isTouch = !!("undefined" != typeof document.documentElement.ontouchstart);
        isTouchG = isTouch;
        var isMobile = navigator.userAgent.match(/(iPhone|iPod|iPad|Android|BlackBerry)/); 
        var isNotPad = navigator.userAgent.match(/(iPhone|iPod|Android|BlackBerry)/); 
        if (isMobile && isNotPad) {
          $('#mobileModal').modal();
          disableInputs = true;
        }
        else {
          var showModal = <?php if($showModal){echo 'true';}else{echo 'false';}?>;
          if (showModal) {
            $('#myModal').modal();
          }   
        }
        $('#photo').click(function(event) {
          if (event.target.nodeName == 'IMG') {
            $('.arrow').hide();
            $('.createdInput').hide();
          }
        });    
        //set the function to run before unload to make sure user confirms
        window.onbeforeunload = checkBeforeClose;
        //make sure loading gif is hidden
        $('#loading').hide();
        $('#smallLoading').hide();
        var img = document.getElementById('img');
        //get the saved face tagging data
        $.post("faceTaggingData.php", {option: "g", clubid: <?php echo $_GET['clubid'] ?>, ptdata: ""}, function(data, status) {
          //set the session store
          sessionStore = JSON.parse(JSON.parse(data)['photo_tag']);
          console.log(sessionStore);
          //if there are no tags, use tracking.js to detect faces and tag them
          if (JSON.parse(JSON.parse(data)['photo_tag']).length < 1) {
            track(img);
          }
          //otherwise load the saved tags and save all tags on the screen to the tempTags variable
          else {
            loadTags();
            tempTags = formatTagData(); 
          }
        });
      };

      //refresh function clears and reloads all the tags
      function refreshImg() {
        $('#loading').show();
        clearAll();
        loadTempTags();
        $('#loading').hide();
      }

      //for replacing the tags when the window is resized, with a half-second delay
      var rtime;
      var timeout = false;
      var delta = 500;
      $(window).resize(function() {
          rtime = new Date();
          if (timeout === false) {
              timeout = true;
              setTimeout(resizeend, delta);
          }
      });

      function resizeend() {
          if (new Date() - rtime < delta) {
              setTimeout(resizeend, delta);
          } else {
              timeout = false;
              $('loading').show();
              while (document.getElementById('photo').children.length > 1) {
                clearAll();
              }
              loadTempTags();
              $('loading').hide();
          }               
      }


      //tracking.js function to detect faces
      function track(img) {
        var tracker = new tracking.ObjectTracker('face');
        tracking.track(img, tracker);
        tracker.on('track', function(event) {
          event.data.forEach(function(rect) {
            plotRectangle(rect.x, rect.y, rect.width, rect.height, "", true);
          });
        });
      }

      //gets all tags on the screen and formats it into an array of Tag objects for storage
      function formatTagData() {
        var tags = []
        var children = document.getElementById('photo').children;
        var img = document.getElementById('img');
        //iterate through all children elements of img
        $.each(children, function(index, value) {
          //make sure it's a tag and not something else
          if (typeof value !== 'undefined' && value.id != "img" && value.tagName != 'HR') {
            if (index == 0 && value.tagName == 'DIV') {
            }
            //get height, width, x, y -- note that they're all proportions so scaling is possible
            var height = value.offsetHeight;
            var height_prop = height / img.offsetHeight;
            var width = value.offsetWidth;
            var width_prop = width / img.offsetWidth;
            var x = $(value).position().left;
            var x_prop = (x - img.offsetLeft) / img.offsetWidth;
            var y = $(value).position().top;
            var y_prop = (y - img.offsetTop) / img.offsetHeight;
            //get name
            var text = "";
            if (value.getElementsByTagName('input').length > 0 ) {
              text = value.getElementsByTagName('input')[0].value;
            }
            //clear out those damned duplicates - probably unnecessary but just in case
            var fdup = false;
            $.each(tags, function(index2, value2) {
              if (value2.x == x_prop && value2.y == y_prop) {
                document.getElementById('photo').removeChild(value)
                fdup = true;
                console.log("Cleaned House!");
              }
            });
            //if it's not a duplicate, push it to the final array
            if (!fdup) {
              tags.push(new Tag(x_prop, y_prop, width_prop, height_prop, text));
            }
            fdup = false;
          }
        });
        return tags;
      }

      //needed for new save argument - note that some of the functions for height and whatnot are different - it's because this time, value is a jQuery object
      function formatIndividualTag(value) {
        var height = value.height();
        var height_prop = height / img.offsetHeight;
        var width = value.width();
        var width_prop = width / img.offsetWidth;
        var x = $(value).position().left;
        var x_prop = (x - img.offsetLeft) / img.offsetWidth;
        var y = $(value).position().top;
        var y_prop = (y - img.offsetTop) / img.offsetHeight;
        //get name
        var text = "";
        if (value.find("input").length > 0 ) {
          text = value.find("input")[0].value;
        }
        return new Tag(x_prop, y_prop, width_prop, height_prop, text);
      }

      //checks if your cursor is near an element - used to make sure user selects  a name from the autocomplete list
      function isNear( $element, distance, event ) {
          
          var left = $element.offset().left - distance,
              top = $element.offset().top - distance,
              right = left + $element.width() + ( 2 * distance ),
              bottom = top + $element.height() + ( 2 * distance ),
              x = event.pageX,
              y = event.pageY;
              
          return ( x > left && x < right && y > top && y < bottom );
          
      };

      //creates a tag based on the data from a Tag object - ignore the auto parameter - it's a remnant from the past that i'm too afraid to delete
      var plotRectangle = function(x, y, w, h, text, auto) {
        //add missing apostrophes to the text before the year (i.e. '16)
        text = addApost(text);
        //add an area to the areas array
        areas.push(w * h);
        //create the rect, arrow, and input elements
        var rect = document.createElement('div');
        var arrow = document.createElement('div');
        var input = document.createElement('input');
        //add the className to the input for the css
        input.className = "createdInput";

        //if the tag has a name, make the rect green to indicate it's been tagged
        if (text.length > 0) {
          rect.style.borderColor = 'rgb(0,255,0)';
          input.value = text;
        }

        //focus on textbox is user clicks on the tag, and 
        rect.onclick = function name() {
          input.select();
        };

        //replaced some css functionality with jQuery, so show/hide on hover is done here
        $(rect).hover(function() {
          $('.createdInput').hide();
          $('.arrow').hide();
          $(rect).children().show();
          if (isTouchG) {
            $(rect).find('input').focus();
          }
        }, function() {
          if ($(rect).find('input').is(':focus')) {

          }
          else {
            $(rect).children().hide();
          }
        });

        input.spellcheck = false;

        //for each keystroke in the input...
        $(input).keyup(function() {
          //store tags to tempTags
          tempTags = formatTagData();
          //find the closest rect and check if it should be green or white based on whether or not there is text in the input
          var tempRect = $(input).closest('.rect');
          if ($(input).val().length > 0) {
            tempRect.css('border-color', 'rgb(0,255,0)');
          }
          else {
            console.log(tempRect);
            tempRect.css('border-color', 'rgb(255,255,255)');
            interactedTags.push((formatIndividualTag($(input).parent())));
            saveChanges();
          } 
        });

        //set input as a jquery autocomplete widget
        $(input).autocomplete({
           source: 'nameautocomplete.php',
            change: function(event,ui){
              //for each change, save everything
              saveChanges();
              console.log(event.target);
              //check if the user didn't click on an autocomplete selection
              if (ui.item == null) {
                console.log(typeof event.target);
                //if user didn't click on autocomplete selection, empty textbox and make rect white
                $(this).val('');
                $(this).parent().css('border-color', 'rgb(255,255,255)');
              }
              interactedTags.push((formatIndividualTag($(input).parent())));
              saveChanges();
            },
            select: function(event, ui) {
              interactedTags.push((formatIndividualTag($(input).parent())));
              saveChanges();
            },
           minLength: 3
        });

        $(input).hide();
        $(arrow).hide();


        //if the user moves the cursor on the photo...
        $(input).focus(function() {
          $('#photo').on('mousemove', function(event) {
            //and if the cursor isn't near the rect or its children element...
            
            if (!isNear($(input), 70, event) && !isNear($(input).parent(), 70, event)) {
              //activate a blur, deselecting all the textboxes and triggering the change function in all the autocomplete textboxes, making them check if any recently changed text is from an autocomplete selection
              //this forces users to choose a selection from the autocomplete result list. If their text isn't from the autocomplete list, it should be automatically deleted
              $(':focus').blur()
              console.log('blurred');
            }
            
          })
        })

        //once the blur has been activated and the focus from the textboxes is gone, remove the mousemove listener for that rect from the photo so it doesn't interfere with other listeners
        $(input).focusout(function() {
          $('#photo').off('mousemove');
          console.log($._data( $('#photo')[0], "events" ));
          console.log('focusout');
        })
        
        //set classes for arrow and rect for css properties
        arrow.classList.add('arrow');
        rect.classList.add('rect');

        //append child elements
        rect.appendChild(input);
        rect.appendChild(arrow);
        document.getElementById('photo').appendChild(rect);

        //set width and height
        rect.style.width = w + 'px';
        rect.style.height = h + 'px';

        //ignore this part
        if (auto) {
          rect.style.left = (img.offsetLeft + x) + 'px';
          rect.style.top = (img.offsetTop + y) + 'px';
        }
        else {
          rect.style.left = (x) + 'px';
          rect.style.top = (y) + 'px';          
        }
        tempTags = formatTagData();

        if(disableInputs) {
          input.disabled = true;
        }
        //saveChanges();
        //console.log('saving here');
      };

      window.onload = loadTracking;

      //the old save function: it simply posts the results of formatTagData()
      var oldSaveFunction = function() {
        var clubid = (<?php echo $_GET['clubid'] ?>);
        //that stuff with .replace() is meant to prevent the apostrophes in the names (i.e. Amit Mondal '16) from causing any issues
        $.post("faceTaggingData.php", {option: "s", clubid: <?php echo $_GET['clubid'] ?>, ptdata: JSON.stringify(formatTagData()).replace(/'1/g, "1")}, function(data, status) {
          if (status == 'success') {
            console.log('saved changes');
          }
        });
      };

      //new save function that does some fancy checking whatnots to make sure data doesn't get overridden
      function saveChanges() {
        console.log('cautious');
        var img = document.getElementById('img');
        $.post("faceTaggingData.php", {option: "g", clubid: <?php echo $_GET['clubid'] ?>, ptdata: ""}, function(data, status) {
          var rawTags = JSON.parse(JSON.parse(data)["photo_tag"]);
          $.each(rawTags, function(index1, value1) {
            $.each(interactedTags, function(index2, value2) {
              //compares formatTagData() tags with the sessionStore
              if (round(value1.x, 13) == round(value2.x, 13) && round(value1.y, 13) == round(value2.y, 13)) {
                if (addApost(value2.name) != addApost(value1.name)) {
                  console.log(value1.name + ', ' + value2.name);
                  rawTags[index1].name = value2.name;
                }
              }
            });
          });
          var clubid = (<?php echo $_GET['clubid'] ?>);
          console.log(rawTags);
          $.post("faceTaggingData.php", {option: "s", clubid: <?php echo $_GET['clubid'] ?>, ptdata: JSON.stringify(rawTags).replace(/'1/g, "1")}, function(data, status) {
            if (status == 'success') {
              console.log('saved changes');
            }
          });
        });
      }

      //clears all tags from the screen. iterates through each child element on the photo and removes it if it is a tag. 
      var clearAll = function() {
        while (document.getElementById('photo').children.length > 1) {
          //Why does this need to be a while loop? I'm not sure. But when it didn't have this while loop, there would always be 2 or 3 tags remaining, so here it is
          $.each(document.getElementById('photo').children, function(index, value) {
            if (typeof value != 'undefined' && value.id != 'img' && value.tagName != 'hr') {
              document.getElementById('photo').removeChild(value);
              console.log("I'm here");
            }
            else if (typeof value == 'undefined') {
              document.getElementById('photo').removeChild;
            }
          });
        }
      }

      //checks with the user first if they want to clear elements
      var safeClearAll = function() {
        if (confirm("Are you sure you want to clear all the tags? This action is permanent and cannot be undone.") == true) {
          clearAll();
          saveChanges();
          console.log('saving here');
        }
      }

      //loads tags from the tempTags variable rather than the tags stored on the server - very important for resizing
      var loadTempTags = function() {
        $.each(tempTags, function(index, value) {
          plotRectangle(value.x * img.offsetWidth, value.y * img.offsetHeight, value.width * img.offsetWidth, value.height * img.offsetHeight, value.name, true);
        });
      }

      //loads tags from the server. Uses a jQuery post to get the data, then iterates through each tag and uses plotRectangle to display
      var loadTags = function() {
        $('#loading').show();
        formatTagData();
        var tagData = [];
        var img = document.getElementById('img');
        $.post("faceTaggingData.php", {option: "g", clubid: <?php echo $_GET['clubid'] ?>, ptdata: ""}, function(data, status) {
          var rawTags = JSON.parse(JSON.parse(data)["photo_tag"]);
          $.each(rawTags, function(index, value) {
            plotRectangle(value.x * img.offsetWidth, value.y * img.offsetHeight, value.width * img.offsetWidth, value.height * img.offsetHeight, value.name, true);
          });
          $('#loading').hide();
        });
      };

      //this is what sends emails to club members with a screenshot of their face, asking them to confirm. Gets the screenshot of the tag from the name on the tag, hence the name parameter
      function screenShotTag(name) {
        var element;
        var children = document.getElementById('photo').children;
        var img = document.getElementById('img');
        //simply iterates through children elements of the picture to find the right tag object
        $.each(children, function(index, value) {
          if (typeof value !== 'undefined' && value.id != "img" && value.tagName != 'HR') {
            var text = "";
            if (value.getElementsByTagName('input').length > 0 ) {
              if (value.getElementsByTagName('input')[0].value.toLowerCase() == name.toLowerCase()) {
                element = value;
              }
            }
          }
        });
        //html2canvas is a JS library that takes a virtual screenshot of a page and returns it as a canvas element
        html2canvas(document.body, {
          onrendered: function(canvas) {
            console.log(canvas.constructor.name);
            if (typeof element == 'undefined') {alert ("Uh oh, something went wrong. Please make sure the tags are correctly named");}
            //gives the start/end X and Y coordinates. compensation creates a frame around the tag 1/4 the size of the original dimensions, provided space is available for the frame
            var compensation = element.offsetHeight * .25;
            var startX; 
            //this series of if/else blocks just checks to make sure the compensation doesn't run off the edge of the page
            if (($(element).position().left - compensation) < 0) {
              startX = 0
            }
            else {
              startX = $(element).position().left - compensation;
            }    
            var startY;
            if (($(element).position().top - compensation) < 0) {
              startY = 0
            }
            else {
              startY = $(element).position().top - compensation;
            }    
            var endX;
            if ((startX + compensation*2  + element.offsetWidth) > canvas.width) {
              endX =  canvas.width;
            }
            else {
              endX = (startX + compensation*2  + element.offsetWidth);
            }
            var endY;
            if ((startY + compensation*2 + element.offsetHeight) > canvas.height) {
              endY = canvas.height
            }
            else {
              endY = (startY + compensation*2 + element.offsetHeight);
            }
            //cropping the canvas returned by html2canvas to only show the face
            var tempCanvas = document.createElement('canvas');
            var tempContext = tempCanvas.getContext('2d');
            var context = canvas.getContext('2d');
            var data = context.getImageData(startX, startY, endX, endY);
            tempCanvas.width = endX - startX;
            tempCanvas.height = endY - startY;
            tempContext.putImageData(data, 0, 0)
            //getting data URL and sending over to php script
            var dataURL = tempCanvas.toDataURL('image/png');
            var clubid = "<?php echo $_GET['clubid']; ?>";
            //gets the club name
            $.get( "getDataFromClubID.php?id=" + parseInt(clubid), function( data, status ) { 
              var clubname = JSON.parse(data)['name'];
              //gets the student info, including email
              $.get('getIDFromName.php?input=' + name, function(data, status) {
                if (status.toLowerCase() == 'success' && data.indexOf('empty') <= -1) {
                  var pData = JSON.parse(data);
                  //posts it all over to the script that creates an email with the screenshot attached
                  $.post('convertToImage.php', {imgData: dataURL, firstname: pData['firstname'], lastname: pData['lastname'], email: pData['email'], clubname: clubname, clubid: clubid, fullname: name.replace(/'1/g, "1")}, 
                    function(data, status) {console.log(data);});
                }
                else {
                  //alert('The name on the tag is not in our database. Please re-tag and try again.');
                }
              });
            });
          }
        });
      }
      //checks if the user has "confirmed" 
      var isSaved = function() {
        var value = true;
        var currentTags = formatTagData();
        $.each(currentTags, function(index1, value1) {
          $.each(sessionStore, function(index2, value2) {
            //compares formatTagData() tags with the sessionStore
            if (round(value1.x, 10) == round(value2.x, 10) && round(value1.y, 10) == round(value2.y, 10)) {
              if (addApost(value2.name) != addApost(value1.name)) {
                value = false;
                return false;
              }
            }
          });
        });
        return value;
      }
      var global = false;
      //similar to isSaved, but sends an email to each newly tagged person
      var confirmAndClose = function() {
        saveChanges();
        var currentTags = formatTagData();
        var count = 0;
        $.each(currentTags, function(index1, value1) {
          $.each(sessionStore, function(index2, value2) {
            if (round(value1.x, 10) == round(value2.x, 10) && round(value1.y, 10) == round(value2.y, 10)) {
              if (addApost(value2.name) != addApost(value1.name) && value1.name.length > 3) {
                if (true) {
                  screenShotTag(value1.name);
                  count++;
                }
              }
            }
          });
        });
        //closes window after alotting a minimum of 600 milliseconds per email to send
        $('#smallLoading').show();
        global = true;
        setTimeout(function() {
        $('#smallLoading').hide();
        
        window.top.close();
        if (!window.closed) {
          location.href = 'http://times.bcp.org/clubs/photoStatus.php';
        }
        
        },count*500 + 1000);
      }

      //this is the onbeforeunload function -- makes sure user has saved
      var checkBeforeClose = function() {
        
        if (isSaved() || global) {return null;}
        else {
          return "Changes on this page have not been confirmed. If you wish to confirm these changes, click \"Confirm and Close\" before exiting the page";
        }
        
      }

      //simple convenience rounding function
      function round(base, n) {
        return Math.round(base * Math.pow(10, n)) / Math.pow(10, n);
      }


      //simple function to add apostrophes since the conversion to JSON sometimes loses them. Input would be something like "Amit Mondal 16" and output would be "Amit Mondal '16"
      function addApost(text) {
        if (text.length > 3) {
          var year = text.substring(text.length-2, text.length);
          if ($.isNumeric(year) && text.substring(text.length-3, text.length-2) != "'"){
            var newText = text.substring(0, text.length-2) + "'" + year;
            return newText;
          }
          return text;
        }
        return text;
      }
    </script>
  </body>
</html>