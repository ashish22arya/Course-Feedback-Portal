<?php
$courseId = htmlspecialchars($_GET['courseId']);

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

$query = "select * from course WHERE courseId LIKE '$courseId%' OR courseId LIKE '%$courseId%'";
$result = mysql_query($query);
//$row = mysql_fetch_array($result);
//echo $row['name'];
$numRows;$row;
if($numRows=mysql_num_rows($result)){
echo "<select size=\"$numRows\" id=\"course\" onclick=\"courseSelected()\" name=\"course\">";
while($row=mysql_fetch_array($result)){
echo "<option value=\"".$row['courseId']."\">".$row['courseId']." ".$row['name']." ".$row['l']."-".$row['t']."-".$row['p']."-".$row['c']."</option>";
}
echo "</select>";
}else{
echo "no courses found";
}
?>

