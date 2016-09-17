<?php
$userName = htmlspecialchars($_GET['userName']);
$password = htmlspecialchars($_GET['password']);
$userType = htmlspecialchars($_GET['userType']);
$finalLink;$variable="userName";
if($userType=="student"){
$finalLink="studentHome.php";$variable="rollNo";}
if($userType=="faculty"){
$table="facultyAccount";$finalLink="facultyHome.php";}
if($userType="admin"){
$table="adminAccount";$finalLink="adminHome.php";}

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

$query = "select * from ".htmlspecialchars($_GET['userType'])."Account where `{$variable}`='$userName'";

$result = mysql_query($query);
//$row = mysql_fetch_array($result);
//echo $row['name'];

if(mysql_num_rows($result)){

$row = mysql_fetch_array($result);
if($row[1]==$password){
echo "".$finalLink;
}else{
echo "2";
}
}else{
echo "1";//not has account
}

?>

