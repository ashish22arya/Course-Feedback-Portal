<?php
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

$query = "select * from courseStudents where feedback=1";
$result = mysql_query($query);
//$row = mysql_fetch_array($result);
//echo $row['name'];
$numRows;$row;
if($numRows=mysql_num_rows($result)){
die ("You cannot alter questions now<br>Some students have already submitted feedback<br>If you alter questions now the application will misbehave");
}
?>
