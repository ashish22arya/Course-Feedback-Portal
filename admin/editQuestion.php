<?php
$qsno = htmlspecialchars($_POST['qsn']);
$ques = htmlspecialchars($_POST['question']);
$rel = htmlspecialchars($_POST['relevance']);



$myfile = fopen("/var/www/html/project/assets/sqlUNP.txt","r") or die("Unable to open file!");
$number = 1;

$sqlUN = "";
$sqlP = "";

// Output one line until end-of-file
$line = fgets($myfile);
$pieces = explode(",",$line);
echo "$sqlUN $sqlP";
$sqlUN = $pieces[0];
$sqlP = $pieces[1];
fclose($myfile);

mysql_connect("localhost",$sqlUN,$sqlP);

@mysql_select_db("CourseFeedback") or die("Unable to select database");

$query = "update questions set questions='$ques',relevance='$rel' where sno=$qsno";
$result = mysql_query($query);
echo "$ques $rel $qsno";
?>

