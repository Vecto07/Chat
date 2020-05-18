<?php
	date_default_timezone_set("Asia/Kathmandu");
session_start();
if(isset($_SESSION['name'])){
    $text = $_POST['text'];
     
    $cb = fopen("log.html", 'a');
    fwrite($cb, "<div class='msgln'>(".date("M d g:i A").") <b>".$_SESSION['name']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
    fclose($cb);
}
?>