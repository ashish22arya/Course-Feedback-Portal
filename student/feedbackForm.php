
<!DOCTYPE html>
<html>
<head><title>Questions</title>
<link type="text/css" rel="stylesheet" href="/project/assets/style.css"/>
<style>
body{

}
.textInput{
margin-left:auto;
margin-right:auto;
width:280px;
}
.inputError{
height:20px;
}
</style>
</head>
<body style="background:rgba(85,110,151,1);text-align:left;">
<input type= 'button' value = "Back" onclick="history.back()">
<?php
$courseid = $_GET['courseId'];
echo "<br><br><h1 style=\"color:#fff;\">$courseid feedback form</h1>";
echo "<br><font style=\"color:#fff;font-family:roboto-medium;\">\"Where 1 is highly disagree and 5 is highly agree\"</font><br><br>";
$rollno = $_GET['rollNo'];

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
$conn=mysqli_connect("localhost",$sqlUN,$sqlP,"CourseFeedback");

if($conn->connect_error)
    die("Connection to database failed: ".$conn->connect_error);
$sql = "select * from questions";
$result = $conn->query($sql);
if ($result->num_rows == 0)
    die("No questions!"."<br>");
$count = 0; $check_flag = 0;
while($row = $result->fetch_assoc()) 
{ 
    $count++;
    ?> <br><font style="color:#fff;font-family:roboto-medium;"> <?php echo $row["sno"].". ".$row["questions"]."<br><br>";
    ?></font>
    <form action = "" method = "post">
    <?php
    $rel = $row['relevance'];
    $check = "select $rel from course where courseId='$courseid'";
    $check_result = $conn->query($check);
    $check_row = $check_result->fetch_assoc();
    if ($check_result->num_rows == 0)
        die("Error in determining relevance!"."<br>");
    else if ($check_row["$rel"] == 0)
    { 
        echo "<font style=\"color:#fff;font-family:roboto-medium;\">N/A!</font>";
	if ($count == 1) $check_flag = 1;
    }
    else
    {    
	for ($i = 1; $i <= 5; $i++) 
        {
        ?>
<input type="radio" name="answer<?php echo $count; ?>" id="answer<?php echo $count.','.$i; ?>" value="<?php echo $i; ?>" required> 
<label for="answer<?php echo $count.",".$i; ?>"><?php echo $i; ?></label>
        <?php
        }
    }
    echo "<br><br>";
    ?>
<?php
} 
?>
    <input type= 'submit' value = "Give Feedback">
    </form>
<?php
$flag = 0;
$questions = "";$answers="";$questionsDef="";
for ($i = 1; $i <= $count; $i++)
{$questions.="q".$i.",";$questionsDef.="q".$i." int,";
    if (isset($_POST["answer".$i]))
    {
	echo $_POST["answer".$i];
	$answers = $answers.$_POST["answer".$i].",";
	$flag++;
    }
    else if ($flag != 0 || ($flag == 0 && $check_flag == 1))
    {
	echo "0";
	$answers = $answers."0".",";
    }
}
if ($flag == 0)
{
    $check_one = "select * from $courseid"."Feedback";
    $check_result = $conn->query($check_one);
    if ($check_result->num_rows == 0)
    {     
	$query1 = "create table $courseid"."Feedback(sno int auto_increment primary key,".rtrim($questionsDef,',').");";
	if($conn->query($query1) == FALSE){;}
	    //die("Could not create Feedback table!");
    }
}
    if ($flag != 0)
    {
        $init = "insert into $courseid"."Feedback(".rtrim($questions,',').") values(".rtrim($answers,',').")";
	//echo $init;
        if ($conn->query($init) == FALSE){
    	    die("Error in populating feedback!"."<br>");}else{
		
		echo "<script>";
		echo "window.location=\"studentHome.php?userType=student&userName=$rollno\";</script>";
		
		}
    }
    if ($flag != 0)
    {
	$record = "update courseStudents set feedback=1 where rollNo='$rollno' and courseId='$courseid'";
        if ($conn->query($record) == FALSE)
    	    die("Error in recording feedback!"."<br>");
    }
?>
</body>
</html>
