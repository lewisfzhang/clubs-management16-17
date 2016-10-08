<!DOCTYPE html>


<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="favicon.ico">
  <style>


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

  .demorect {
    border-radius: 2px;
    border: 3px solid black;
    box-shadow: 0 16px 28px 0 rgba(0, 0, 0, 0.3);
    opacity: 1;
    width: 60px;
    height:60px;
    display: inline-block;
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

  .handle {
    border: 3px solid black;
    width: 40px;
    height: 25px;
    background: repeating-linear-gradient(
      45deg,
      #FFFFFF,
      #FFFFFF 10px,
      #465298 10px,
      #465298 20px
    );
    position: absolute;
    left: 50%;
  }

  #img {
    width:110%;
  }
  #urlinput {
    padding-left:80px;
  }
  div.buttons {
    display:inline-block;
    position: relative;
  }
  div.resizer {
    float:left;
    display:inline-block;
    height:150px;
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
          <a class="navbar-brand" href="index.php">Bellarmine Clubs</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="photoMaster.php">Master Club List</a></li>
          </ul>
          <p class="navbar-text navbar-right"></p>

        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div id="loading"></div>
    <div class="container" id="top">
 


      <br>
      <div class = "picture-container">
        <span id="photo"><img id="img" src="/clubs/photos/<?php echo $_GET['clubid'];?>.jpg" /></span>
      </div>
      <br><br>
      <h3 class = "namedisplay"> Rows: </h3>
      <div class = "namedisplay">
        <textarea readonly id = "rowDisplay" rows = "4" cols = "50"></textarea>
      </div><br><br>
      <div class = "buttons">
        <!--<button onclick = "saveChanges()" type="button" class="btn">Save Changes</button>-->
        <button onclick = "loadTags()" type="button" class="btn">Refresh</button>
        <button onclick = "safeClearAll()" type="button" class="btn">Clear All</button>
        <button onclick = "createDivider()" type="button" class="btn">Make Row Divider</button>
        <button onclick = "screenShotTag(prompt('Enter A Name (make sure it matches the tag text)', ''));" type="button" class="btn">Test Photo Save (Experimental)</button>
        <button onclick = "sendEmail()" type = "button" class = "btn">Send Email to Club Members</button>
      </div>
      <br><br>
      <div class = "resizer">
          Click on a tag, then drag the slider to change size: <div><input id = "sizeslider" type="range" name="points" min="10" max="110" onchange = "sliderChange(this.value)" oninput = "sliderChange(this.value)"></div>
          <div class = "demorect" id = "demorect"></div>
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
      //Amit Mondal '16
      var resizerRect = null;
      var ignoreResize = false;
      var tempTags = [];
      var colorCounter = 0;
      function Tag (x, y, w, h, name) {
        this.x = x;
        this.y = y;
        this.width = w;
        this.height = h;
        this.name = name;
      }
      var areas = [];
      var sliderChange = function(value) {
        document.getElementById('demorect').style.width = value + "px";
        document.getElementById('demorect').style.height = value + "px";
        if (resizerRect != null) {
          var heightChange = value - resizerRect.offsetHeight;
          var widthChange = value - resizerRect.offsetWidth;
          var currentLeft = $(resizerRect).position().left;
          var currentTop = $(resizerRect).position().top;
          resizerRect.style.width = value + "px";
          resizerRect.style.height = value + "px";
          resizerRect.style.left = currentLeft - widthChange/2 + "px";
          resizerRect.style.top = currentTop - heightChange/2 + "px";
        }
        saveChanges();

      }
      var loadTracking = function() {
        $('#loading').hide();
        var img = document.getElementById('img');
        $.post("faceTaggingData.php", {option: "g", clubid: <?php echo $_GET['clubid'] ?>, ptdata: ""}, function(data, status) {
          if (JSON.parse(JSON.parse(data)['photo_tag']).length < 1) {
            track(img);
          }
          else {
            loadTags();
            tempTags = formatTagData(); 
          }
        });
        $('#photo').click(function(event) {
          if (event.target.nodeName == 'IMG') {
            $('.arrow').hide();
            $('.createdInput').hide();
          }
        });   
        $("#img").dblclick(function (e) {
          var offset = $(this).offset();
          var x = (e.pageX - offset.left);
          var y = (e.pageY - offset.top);
          var sum = 0;
          $.each(document.getElementById('photo').children, function(index, value) {
            if (value.id != 'img' && value.tagName != 'HR') {
              sum += (value.offsetHeight * value.offsetWidth);
            }
          });
          var size = document.getElementById('sizeslider').value;
          console.log(size);
          plotRectangle(x, y, size, size, "", true); 
          saveChanges();
          console.log('saving here');
          $('.arrow').hide();
          $('.createdInput').hide();
        });
      };
      function refreshImg() {
        $('#loading').show();
        clearAll();
        loadTempTags();
        $('#loading').hide();
      }
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
      function track(img) {
        var tracker = new tracking.ObjectTracker('face');
        tracking.track(img, tracker);
        tracker.on('track', function(event) {
          event.data.forEach(function(rect) {
            plotRectangle(rect.x, rect.y, rect.width, rect.height, "", true);
          });
        });
      }
      function formatTagData() {
        var tags = []
        var children = document.getElementById('photo').children;
        var img = document.getElementById('img');
        $.each(children, function(index, value) {
          if (typeof value !== 'undefined' && value.id != "img" && value.tagName != 'HR') {
            if (index == 0 && value.tagName == 'DIV') {
              var c = value
              var t = c.getContext('2d');
              window.open('', value.toDataURL());
            }
            var height = value.offsetHeight;
            var height_prop = height / img.offsetHeight;
            var width = value.offsetWidth;
            var width_prop = width / img.offsetWidth;
            var x = $(value).position().left;
            var x_prop = (x - img.offsetLeft) / img.offsetWidth;
            var y = $(value).position().top;
            var y_prop = (y - img.offsetTop) / img.offsetHeight;
            var text = "";
            if (value.getElementsByTagName('input').length > 0 ) {
              text = value.getElementsByTagName('input')[0].value;
            }
            //clear out those damned duplicates
            var fdup = false;
            $.each(tags, function(index2, value2) {
              if (value2.x == x_prop && value2.y == y_prop) {
                document.getElementById('photo').removeChild(value)
                fdup = true;
                console.log("Cleaned House!");
              }
            });
            if (!fdup) {
              tags.push(new Tag(x_prop, y_prop, width_prop, height_prop, text));
            }
            fdup = false;
          }
        });
        return tags;
      }
      var plotRectangle = function(x, y, w, h, text, auto) {
        areas.push(w * h);
        var rect = document.createElement('div');
        var arrow = document.createElement('div');
        var input = document.createElement('input');
        input.className = "createdInput";

        $(input).autocomplete({
           source: 'nameautocomplete.php',
           minLength: 3
        });
        
        if (text.length > 0) {
          rect.style.borderColor = 'rgb(0,255,0)';
          input.value = text;
        }

        rect.onclick = function name() {
          resizerRect = rect;
          input.select();
          document.getElementById("sizeslider").value = Math.min(rect.offsetHeight, 110);
          sliderChange(Math.min(rect.offsetHeight, 110));
        };

        $(input).keyup(function() {
          tempTags = formatTagData();
          saveChanges();
          console.log('saving here');
          var tempRect = $(input).closest('.rect');
          if ($(input).val().length > 0) {
            tempRect.css('border-color', 'rgb(0,255,0)');
            if (dividers.length > 0) {
              assessDividers();
            }
          }
          else {
            console.log(tempRect);
            tempRect.css('border-color', 'rgb(255,255,255)');
          }
        });

        //replaced some css functionality with jQuery, so show/hide on hover is done here
        $(rect).hover(function() {
          $('.createdInput').hide();
          $('.arrow').hide();
          $(rect).children().show();
        }, function() {
          if ($(rect).find('input').is(':focus')) {

          }
          else {
            $(rect).children().hide();
          }
        });

        arrow.classList.add('arrow');
        rect.classList.add('rect');

        rect.appendChild(input);
        rect.appendChild(arrow);
        document.getElementById('photo').appendChild(rect);
        rect.style.width = w + 'px';
        rect.style.height = h + 'px';
        if (auto) {
          rect.style.left = (img.offsetLeft + x) + 'px';
          rect.style.top = (img.offsetTop + y) + 'px';
        }
        else {
          rect.style.left = (x) + 'px';
          rect.style.top = (y) + 'px';          
        }
        $(rect).draggable({
          stop: function(event, ui) {
            tempTags = formatTagData();
            saveChanges();
            console.log('saving here');
          }
        });
        rect.addEventListener('click', function(evt) {
          if (evt.detail === 3) {
            alert('triple click!');
          }
        });
        $(rect).dblclick(function(e) {
          document.getElementById('photo').removeChild(rect);
          tempTags = formatTagData();
          saveChanges();
          console.log('saving here');
        });
        tempTags = formatTagData();
        //saveChanges();
        //console.log('saving here');
        $(input).hide();
        $(arrow).hide();
      };
      window.onload = loadTracking;
      var saveChanges = function() {
        var clubid = (<?php echo $_GET['clubid'] ?>);
        //those two replaces are because apostrophes and backslashes cause issues
        var sanitizedData = JSON.stringify(formatTagData()).replace(/'1/g, "1").replace(/\\\\/g, '\\');
        $.post("faceTaggingData.php", {option: "s", clubid: <?php echo $_GET['clubid'] ?>, ptdata: sanitizedData }, function(data, status) {
          if (status == 'success') {
            console.log('saved changes');
          }
        });
      };
      var clearAll = function() {
        while (document.getElementById('photo').children.length > 1) {
          $.each(document.getElementById('photo').children, function(index, value) {
            if (typeof value != 'undefined' && value.id != 'img' && value.tagName != 'hr') {
              document.getElementById('photo').removeChild(value);
            }
            else if (typeof value == 'undefined') {
              document.getElementById('photo').removeChild;
            }
          });
        }
        location.reload();
      }
      var safeClearAll = function() {
        if (confirm("Are you sure you want to clear all the tags? This action is permanent and cannot be undone.") == true) {
          clearAll();
          saveChanges();
          console.log('saving here');
        }
      }
      var loadTempTags = function() {
        $.each(tempTags, function(index, value) {
          plotRectangle(value.x * img.offsetWidth, value.y * img.offsetHeight, value.width * img.offsetWidth, value.height * img.offsetHeight, value.name, true);
        });
      }
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
      var dividers = [];
      var createDivider = function() {
        assessDividers();
        colorCounter++;
        var divider = document.createElement('hr');
        divider.className = 'divider';
        dividers.push(divider);
        divider.style.borderColor = "orange";
        $(divider).dblclick(function(e) {
          var index = dividers.indexOf(divider);
          if (index > -1) {dividers.splice(index, 1);}
          divider.parentNode.removeChild(divider);
          assessDividers();
        });
        var dtime;
        var dtimeout = false;
        var ddelta = 200;
        $(divider).draggable({
          axis: 'y',
          drag: function() {
            dtime = new Date();
            if (dtimeout === false) {
                dtimeout = true;
                setTimeout(dragResizeend, ddelta);
            }
          }
        });
        function dragResizeend() {
            if (new Date() - dtime < ddelta) {
                setTimeout(dragResizeend, ddelta);
            } else {
                dtimeout = false;
                assessDividers();
            }               
        }
        divider.style.top = '-150px';
        divider.style.left = '0px';
        var handle = document.createElement('div');
        handle.className = 'handle';
        divider.appendChild(handle);
        document.getElementById('photo').appendChild(divider);
      }
      //looks at the dividers and creates arrays of Tag objects to separate rows
      function assessDividers() {
        console.log('assessing dividers');
        dividers.sort(function(a, b) {
          if (typeof a != 'undefined' && typeof b != 'undefined') {
            return $(a).position().top - $(b).position().top;
          }
        });
        var liveTagCopies = tempTags.slice(0);
        var remains = liveTagCopies.slice(0);
        var img = document.getElementById('img');
        var rows = [];
        var i;
        for (i = 0; i < dividers.length; i++) {
          var tagSort = [];
          //this could just as easily have been $.each, I didn't quite understand how $.grep worked at the time
          $.grep(liveTagCopies, function(value, index) {
            var distance = img.offsetTop + value.y * img.offsetHeight + (value.height * img.offsetHeight / 2);
              if (i==0  && dividers[i].offsetTop > distance) {
                tagSort.push(value);
                //this is the grep that matters
                remains = $.grep(remains, function(value2){return value2 != value;})
                return false; 
                console.log("hello");
              }
              else if (i > 0 && dividers[i].offsetTop > distance && dividers[i-1].offsetTop < distance) {
                tagSort.push(value);
                remains = $.grep(remains, function(value2){return value2 != value;})
                return false; 
              }
              else return true;
          });
          rows.push(tagSort);
        }
        rows.push(remains);
        displayRowData(rows);
      }
      //sorts each Tag object in each row from left to right and then displays the row data
      function displayRowData(rows) {
        var displayString = "";
        $.each( rows, function(index, value) {
          var tempString = "";
          if (index == 0) {
            tempString += "Back Row: "
          } else if  (index == rows.length - 1) {
            tempString += "Front Row: "
          } else {
            tempString += "Row " + (rows.length - index) + ": "
          }
          value.sort(function(a, b) {
            return a.x - b.x;
          });
          $.each(value, function(index2, value2) {
            if (value2.name.substring(value2.name.length-2, value2.name.length-1) == '1') {
              tempString += value2.name.substring(0,value2.name.length-3) + ", ";
            } else {
            tempString += value2.name + ", ";
            }
          });
          tempString = tempString.substring(0,tempString.length-2) + ". ";
          displayString = tempString + displayString;
        });
        $('#rowDisplay').val(displayString);
      }
      function screenShotTag(name) {
        var element;
        var children = document.getElementById('photo').children;
        var img = document.getElementById('img');
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
        html2canvas(document.body, {
          onrendered: function(canvas) {
            console.log(canvas.constructor.name);
            if (typeof element == 'undefined') {alert ("Uh oh, something went wrong. Please make sure the name you entered is exactly the same as the one in the tag.");}
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
            $.get('getIDFromName.php?input=' + name, function(data, status) {
              if (status.toLowerCase() == 'success' && data.indexOf('empty') <= -1) {
                var pData = JSON.parse(data);
                $.post('convertToImage.php', {imgData: dataURL, firstname: pData['firstname'], lastname: pData['lastname'], email: pData['email']}, function(data, status) {console.log(data);});
              }
              else {
                console.log('invalid name');
                alert('The name on the tag is not in our database. Please re-tag and try again.');
              }
            });
          }
        });
      }
      var sendEmail = function() {
        var clubid = "<?php echo $_GET['clubid']; ?>";
        var clubname;
        $.get( "getDataFromClubID.php?id=" + parseInt(clubid), function( data, status ) { 
          clubname = JSON.parse(data)['name'];
          $.post('faceTagMailer.php', {clubid: clubid, clubname: clubname}, function(data, status) {
            alert(data);
          });
        });
      }
    </script>
  </body>
</html>