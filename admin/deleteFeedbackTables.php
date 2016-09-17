<?php
echo "<br><br>Deleting feedback tables<br><br>";
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

$query = "select * from course";
$result = mysql_query($query);

if($result){
echo "table courseFeedback exists<br>";
while($row=mysql_fetch_array($result)){
$courseId=$row[0];
$query = "drop table ".$courseId."Feedback";
$result1 = mysql_query($query);
if($result1){
echo "table $courseId dropped<br>";
}
}
}
?>
