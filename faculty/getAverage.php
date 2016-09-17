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

$query = "select * from $courseId"."Feedback";
$result = mysql_query($query);
//$row = mysql_fetch_array($result);
//echo $row['name'];
$numRows;$row;
$averages = array();
if($numRows=mysql_num_rows($result)){

$numCols=mysql_num_fields($result);
$rowIndex=1;
	while($row=mysql_fetch_array($result)){
		$colIndex=1;
		while($colIndex<$numCols){
			if($rowIndex==1){
				if($row[$colIndex]==null){
					array_push($averages,0);
					//echo 0;
				}else{
					array_push($averages,(int)$row[$colIndex]);
					//echo $row[$colIndex];
				}
			}else{
				if($row[$colIndex]!=null)
					$averages[$colIndex-1] = $averages[$colIndex-1]+$row[$colIndex];
			}
		$colIndex++;
		}
	$rowIndex++;
	}

$index=0;
//echo $numCols;
//echo $rowIndex;
while($index<=($numCols-2)){
$averages[$index] = $averages[$index]/($rowIndex-1);
echo "".$averages[$index].",";
$index++;
}	
//print_r($averages);

echo "</select>";
}else{
echo "no courses found";
}
?>

