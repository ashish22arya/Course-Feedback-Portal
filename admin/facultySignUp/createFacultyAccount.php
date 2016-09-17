<?php

$userName = htmlspecialchars($_GET['username']);
$password = htmlspecialchars($_GET['password']);
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

$result = mysql_query("insert into facultyAccount values('$userName','$password')");

if($result){
	echo "1";
}else{
	echo "0";
} 

?>
