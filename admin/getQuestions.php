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

$query = "select * from questions";
$result = mysql_query($query);
//$row = mysql_fetch_array($result);
//echo $row['name'];
$numRows;$row;
if($numRows=mysql_num_rows($result)){
echo "<select size=\"5\" id=\"question\" name=\"question\">";
while($row=mysql_fetch_array($result)){
echo "<option value=\"".$row['sno']."\">".$row['sno']." ".$row['questions']." ".$row['relevance']."</option>";
}
echo "</select>";
}else{
echo "no questions found";
}
?>

