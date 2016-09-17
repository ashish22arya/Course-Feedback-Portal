<?php
echo "<br><br>populating default questions<br><br>"; 
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

$query = "create table questions (sno int,questions varchar(1000),relevance varchar(10))";
$result = mysql_query($query);

if($result){
$line ="";$sno=1;
$myfile = fopen("/var/www/html/project/assets/defaultQuestions.txt", "r") or die("Unable to open file!");
// Output one line until end-of-file
while(!feof($myfile)) {
	$line = fgets($myfile)."";
	$parts = explode('**',$line,3);
	if($parts['0']!=""){
	$query = "insert into questions values($sno,'".$parts[0]."','".$parts[1]."')";
	$result = mysql_query($query);
	echo "<br>inserting question<br>".$parts[0].",".$parts[1].",".$sno."<br>";
	}
	$sno++;
}
fclose($myfile);

}else{
echo "<br>questions already exist<br>";
}
?>
