<!DOCTYPE html>
<html>
<head>
<link type="text/css" rel="stylesheet" href="/project/assets/style.css"/>
</head>
<body style="background:#fff">
<?php
$sem = $_POST['semester'];
$seme = $sem;
$target_dir = "";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$redirectCommand = "";
// Check if file already exists
if (file_exists($target_file)) {
    echo "File already exists.Deleting it<br>";
    unlink($target_file);
//$redirectCommand = "<meta http-equiv='refresh' content='2;URL=uform.php' /> ";

}


// Check file size
if ($_FILES["fileToUpload"]["size"] > 20000000) {
    echo "Sorry, file is too large.<br>";
    $uploadOk = 0; 
//$redirectCommand = "<meta http-equiv='refresh' content='2;URL=uform.php' /> ";

}


//Allow certain file formats
if($imageFileType != "xls") {
 echo "Sorry the selected file is not .xls file<br>";
    $uploadOk = 0;
//$redirectCommand = "<meta http-equiv='refresh' content='2;URL=uform.php' /> ";

}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "File was not uploaded . Redirecting to previous page ... <br>";
    $redirectCommand = "<meta http-equiv='refresh' content='3;URL=populateDatabase.php' /> ";

// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading the file . Redirecting to previous page ... <br>";
    $redirectCommand = "<meta http-equiv='refresh' content='3;URL=populateDatabase.php' /> ";
    }
}

echo $redirectCommand;

$fileName = basename($_FILES["fileToUpload"]["name"]);
$toPrint = "";
if($uploadOk!=0){

include 'backup.php';
include 'populateDefaultQuestions.php';
include 'deleteFeedbackTables.php';

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

$query = "drop table courseStudents";
$result = mysql_query($query);

$query = "create table courseStudents (courseId varchar(10),rollNo varchar(10),feedBack boolean)";
$result = mysql_query($query);

$query = "drop table student";
$result = mysql_query($query);

$query = "create table student (rollNo varchar(10),name varchar(30),sem int)";
$result = mysql_query($query);

$query = "drop table course";
$result = mysql_query($query);

$query = "create table course (courseId varchar(10),name varchar(50),faculty varchar(30),l int,t int,p int,c int)";
$result = mysql_query($query);

$query = "create table excelFile (sno int primary key auto_increment,excelFileName varchar(30),semester varchar(20),year int)";
$result = mysql_query($query);
$date = date("Y");
$query = "insert into excelFile (excelFileName,semester,year) values('".$fileName."','".$seme."',".$date.")";
$result = mysql_query($query);

include 'excel_reader.php';
$excel = new PhpExcelReader;
$excel->read($fileName);

function course($excel){
	$sheet = $excel->sheets[0];
	//$toPrint = "<br>";
	$x = 1;

	while($x <= $sheet['numRows']){
		//$cell = isset($sheet['cells'][$x][$y]) ? $sheet['cells'][$x][$y] :'';
		mysql_query("insert into course values('".$sheet['cells'][$x][1]."','".$sheet['cells'][$x][2]."','".$sheet['cells'][$x][3]."',".$sheet['cells'][$x][4].",".$sheet['cells'][$x][5].",".$sheet['cells'][$x][6].",".$sheet['cells'][$x][7].")");
		//$toPrint;	
		//$toPrint .= "<br>";
		$x++;
		}
	}


function student($excel){
	$sheet = $excel->sheets[1];
	//$toPrint = "<br>";
	$x = 1;

	while($x <= $sheet['numRows']){
		//$cell = isset($sheet['cells'][$x][$y]) ? $sheet['cells'][$x][$y] :'';
		mysql_query("insert into student values('".$sheet['cells'][$x][1]."','".$sheet['cells'][$x][2]."',".$sheet['cells'][$x][3].")");
		//$toPrint;	
		//$toPrint .= "<br>";
		$x++;
		}
	}


function courseStudents($excel){
	$sheet = $excel->sheets[2];
	$toPrint = "<br>";
	$x = 1;

	while($x <= $sheet['numRows']){
		$y=1;
		$rollNo;

		while($y <= $sheet['numCols']){
			$cell = isset($sheet['cells'][$x][$y]) ? $sheet['cells'][$x][$y] :'';
			if(($y==1)){
				$rollNo = $sheet['cells'][$x][$y];
			}else if($sheet['cells'][$x][$y]!=""){
				mysql_query("insert into courseStudents values('".$sheet['cells'][$x][$y]."','".$rollNo."',0)");
			}
			$toPrint .= " $cell ";
			$y++;
			}
		$toPrint .= "<br>";
		$x++;
		}
	}
}

course($excel);
student($excel);
courseStudents($excel);
?>
<?php
if($toPrint!="<br>"){
echo "Data written to database<br>";
}
?>

</body>

</html>
