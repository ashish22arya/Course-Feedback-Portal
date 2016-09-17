<!DOCTYPE html>
<html>
<head>
<title>
Select Course To give feedback
</title>
<link type="text/css" rel="stylesheet" href="/project/assets/style.css"/>
<style>
.textInput{
margin-left:auto;
margin-right:auto;
width:280px;
}
.inputError{
height:20px;
}
.courseField{
text-align:center;
float:left;
}
</style>
</head>	
<body style="text-align:center;background-color:#ddd;">

<input type ="button" onclick = "window.location.href='/project/home.php'" value="log out"/>
 
<?php
$userName = $_GET['userName'];	
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
$rq =  mysql_query("select name from student where rollNo = '$userName' ");
$row = mysql_fetch_assoc($rq);
$studentName = $row['name'];
?>

<br>
<br>

<div style="background-color: rgba(85,110,151,1);padding:10px;border-radius:5px;width:300px;margin-left:auto;margin-right:auto;
font-family:roboto-medium;color:#fff;">
<img src="/project/assets/user.png" width="40px"/><br>	
<?php echo "Roll No - $userName<br>Name - $studentName";?>
</div>
<br>
<div style="background-color:rgba(128,203,196,1);border-radius:5px;width:500px;margin-left:auto;margin-right:auto;padding:10px;
font-family:roboto-medium;color:#fff;">
	<?php echo "<h3>Course List</h3>";?>
	<?php
	$query="select courseId from courseStudents where rollNo = '$userName' ";
	$run=mysql_query($query);
	while($row=mysql_fetch_array($run))
	{
		$temp = $row['courseId'];
		
	$rq =  mysql_query("select name from course where courseId = '$temp' ");
	$row = mysql_fetch_assoc($rq);
	
	$courseName = $row['name'];

	$rq =  mysql_query("select l from course where courseId = '$temp' ");
	$row = mysql_fetch_assoc($rq);
	$l = $row['l'];

	$rq =  mysql_query("select t from course where courseId = '$temp' ");
	$row = mysql_fetch_assoc($rq);
	$t = $row['t'];

	$rq =  mysql_query("select p from course where courseId = '$temp' ");
	$row = mysql_fetch_assoc($rq);
	$p = $row['p'];

	$rq =  mysql_query("select c from course where courseId = '$temp' ");
	$row = mysql_fetch_assoc($rq);
	$c = $row['c'];

	$rq =  mysql_query("select feedback from courseStudents where courseId = '$temp' and rollNo = '$userName' ");
	$row = mysql_fetch_assoc($rq);
	$feedback = $row['feedback'];

	if(!$feedback){
	echo "<div class=\"link\" style=\"width:500px;height:60px;margin-right:auto;margin-left:auto;padding:0px;\"><a href=feedbackForm.php?courseId=".urlencode($temp)."&rollNo=".urlencode($userName)."><div class=\"courseField\" style=\"width:100px;\">$temp</div><div class=\"courseField\" style=\"width:300px;\">$courseName</div><div class=\"courseField\" style=\"width:100px;\">($l-$t-$p-$c)</div></a></div><br>";
	}
	else
		echo "<div class=\"link\" style=\"width:500px;height:60px;margin-right:auto;margin-left:auto;padding:0px;color: rgba(85,110,151,1);\"><div class=\"courseField\" style=\"width:100px;\">$temp</div><div class=\"courseField\" style=\"width:300px;\">$courseName<br>(submitted)</div><div class=\"courseField\" width=\"100px\">($l-$t-$p-$c)</div></div><br>";
	}

?>
</div>
			
	
</body>
</html>
