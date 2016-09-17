<?php
$rollno = htmlspecialchars($_GET['rollno']);

$myfile = fopen("assets/sqlUNP.txt","r") or die("Unable to open file!");
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

$query = "select * from studentAccount where rollNo='$rollno' ";
$result = mysql_query($query);
//$row = mysql_fetch_array($result);
//echo $row['name'];

if(mysql_num_rows($result)){
echo "1";//hasaccount
}else{
$query = "select * from courseStudents where rollNo='$rollno' ";
$result = mysql_query($query);
if(mysql_num_rows($result)){
echo "2";//enrolled
}else{
echo "3";//not enrolled
}
}
?>

