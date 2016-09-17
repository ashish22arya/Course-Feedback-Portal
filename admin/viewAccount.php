<?php
$userName = htmlspecialchars($_GET['username']);
$user = htmlspecialchars($_GET['user']);

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

if($user == "faculty")
{
	$ch = 0;	
	$rq = mysql_query("select userName from facultyAccount where userName='$userName'");
	$row = mysql_fetch_assoc($rq);
	$temp = $row['userName'];

	if($temp == $userName)
		$ch = 1;
	
	if($ch)
	{
		$rq = mysql_query("select password from facultyAccount where userName='$userName'");
		$row = mysql_fetch_assoc($rq);
		$password = $row['password'];

		echo "<br>Faculty User Name:- $userName<br>Password:- $password";
	}
	
	else
		echo "User doesn't exist!!!";	
}
if($user == "student")
{
	$ch = 0;	
	$rq = mysql_query("select rollNo from studentAccount where rollNo='$userName'");
	$row = mysql_fetch_assoc($rq);
	$temp = $row['rollNo'];

	if($temp == $userName)
		$ch = 1;
	
	if($ch)
	{
		$rq = mysql_query("select password from studentAccount where rollNo='$userName'");
		$row = mysql_fetch_assoc($rq);
		$password = $row['password'];

		$rq = mysql_query("select sem from student where rollNo='$userName'");
		$row = mysql_fetch_assoc($rq);
		$sem = $row['sem'];

		echo "<br>Student's User Name:- $userName<br>Password:- $password<br>Semester:- $sem";
	}
	
	else
		echo "User doesn't exist!!!";	
}




?>
