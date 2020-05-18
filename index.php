<?php

session_start ();
function loginForm() {
    echo '
	<div class="form-group">
		<div id="loginform">
			<form action="index.php" method="post">
			<h1>Welcome :)</h1><hr/>
				<label for="name">Please enter your alias to proceed..</label>
				<input type="text" name="name" id="name" class="form-control" placeholder="Enter Your Alias"/>
				<input type="submit" class="btn btn-default" name="enter" id="enter" value="Enter" />
			</form>
		</div>
	</div>
   ';
}
 
if (isset ( $_POST ['enter'] )) {
    if ($_POST ['name'] != "") {
        $_SESSION ['name'] = stripslashes ( htmlspecialchars ( $_POST ['name'] ) );
        $cb = fopen ( "log.html", 'a' );
        fwrite ( $cb, "<div class='msgln'><i>User " . $_SESSION ['name'] . " has joined the chat.</i><br></div>" );
        fclose ( $cb );
    } else {
        echo '<span class="error">Please Enter a Name</span>';
    }
}
 
if (isset ( $_GET ['logout'] )) {
    $cb = fopen ( "log.html", 'a' );
    fwrite ( $cb, "<div class='msgln'><i>User " . $_SESSION ['name'] . " has left the chat.</i><br></div>" );
    fclose ( $cb );
    session_destroy ();
    header ( "Location: index.php" );
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Let's Chat Anonymously</title>
	 <link rel="shortcut icon" href="bg.png" type="image/x-icon" />
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script type="text/javascript" src="js/jquery.min.js"></script>
<style>
#element {
    scrollbar-width: none;
}
::-webkit-scrollbar {
    display: none;
}
</style>
<script>
var d = new Date(<?php echo time() * 1000 ?>);

function updateClock() {
  // Increment the date
  d.setTime(d.getTime() + 1000);

  // Translate time to pieces
  var currentHours = d.getHours();
  var currentMinutes = d.getMinutes();
  var currentSeconds = d.getSeconds();

  // Add the beginning zero to minutes and seconds if needed
  currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
  currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;

  // Determine the meridian
  var meridian = (currentHours < 12) ? "AM" : "PM";

  // Convert the hours out of 24-hour time
  currentHours = (currentHours > 12) ? currentHours - 12 : currentHours;
  currentHours = (currentHours == 0) ? 12 : currentHours;

  // Generate the display string
  var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + meridian;

  // Update the time
  document.getElementById("clock").firstChild.nodeValue = currentTimeString;
}

window.onload = function() {
  updateClock();
  setInterval('updateClock()', 1000);
}
</script>
</head>
<body>




<?php
	if (! isset ( $_SESSION ['name'] )) {
	loginForm ();
	} else {
?>
<div id="wrapper">
	<div id="menu">
	<h1>Let's Chat</h1> <?php
	date_default_timezone_set("Asia/Kathmandu");
	?> 
<div id="clock">&nbsp;</div> <hr/>
		<p class="welcome"><b>Hi   <a><?php echo $_SESSION['name']; ?></a></b></p> 
		<p class="logout"><a id="exit" href="#" class="btn btn-default">Exit Chat</a></p>
	<div style="clear: both"></div>
	</div>
	<div id="chatbox">
	<?php
		if (file_exists ( "log.html" ) && filesize ( "log.html" ) > 0) {
		$handle = fopen ( "log.html", "r" );
		$contents = fread ( $handle, filesize ( "log.html" ) );
		fclose ( $handle );
		echo $contents;
		}
	?>
	</div>
<form name="message" action="">
	<input name="usermsg" class="form-control" type="text" id="usermsg" placeholder="Create A Message" /><br>
	<input name="submitmsg" class="btn btn-default" type="submit" id="submitmsg" value="Send" />
	
</form><br>
    <form method="post"> 
        <input type="submit" name="button1"
                class="btn btn-default" value="Clear Messages" /> 
    </form> 

</div>
<script type="text/javascript">
$(document).ready(function(){
});
$(document).ready(function(){
    $("#exit").click(function(){
        var exit = confirm("Are you sure you want quit?");
        if(exit==true){window.location = 'index.php?logout=true';}     
    });
});
$("#submitmsg").click(function(){
        var clientmsg = $("#usermsg").val();
        $.post("post.php", {text: clientmsg});             
        $("#usermsg").attr("value", "");
        loadLog;

    return false;
});
function loadLog(){    
    var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
	 var audio = new Audio('noti.mp3');
    $.ajax({
        url: "log.html",
        cache: false,
        success: function(html){ 		
            $("#chatbox").html(html);       
            var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
            if(newscrollHeight > oldscrollHeight){
                $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal');
				       
        audio.play();
            }              
        },
    });
}
setInterval (loadLog, 1500);



</script>

<?php
}
?>
<?php
        if(array_key_exists('button1', $_POST)) { 
            button1(); 
        } 

        function button1() { 
           unlink("log.html");
		    $fp = fopen("log.html", "w");
fwrite($fp, '<center><h1>Start The Chat<br>|<br>|<br>|<br>|<br>V</center></h1>');
fclose($fp);
		   
        } 

    ?> 
 
</body>
</html>