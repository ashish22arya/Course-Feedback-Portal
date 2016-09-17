<?php
$courseid="ic121";

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

//

$conn = new mysqli("localhost",$sqlUN,$sqlP,"CourseFeedback");
if($conn->connect_error)
    die("Connection Failed: ".$conn->connect_error);

//Take courseid, year and sem from excelFile table
$data_query = "select * from excelFile where sno=(select max(sno) from excelFile)"; 
$data_result = $conn->query($data_query); 
$data = $data_result->fetch_assoc();
$year = $data["year"];
$sem = $data["semester"];

//iterate through <courseid>Feedback and find mean of every question
    $count = 0;
    $feedback_query = "select * from ".$courseid."Feedback";
    $feedback_result = $conn->query($feedback_query);
    //Find num of ques
    $numq_query = "show columns from ".$courseid."Feedback"; 
    $numq_result = $conn->query($numq_query); 
    $numq = ($numq_result->num_rows) - 1;
    if ($numq == -1) continue;
    $division = $numq;

    //Find mean feedback of every ques (store in $q1,$q2,..)
    for($i = 1; $i <= $numq; $i++)
	${'q'.$i} = 0;
    while($feedback = $feedback_result->fetch_assoc())
    {	
	$count++;
    	for ($i = 1; $i <= $numq; $i++)
	    ${'q'.$i} = ${'q'.$i} + $feedback["q".$i];
    }

    // Find mean feedback of all questions (store in $Mean_$courseid)
    ${'Sum_'.$courseid} = 0.0;
    for($i = 1; $i <= $numq; $i++)
    {
	${'Sum_'.$courseid} = ${'Sum_'.$courseid} + ${'q'.$i};
	if(${'q'.$i} == 0)
	    $division--;
    }
    echo $courseid.":".$division."<br>";
    ${'Mean_'.$courseid} = ${'Sum_'.$courseid}/($division*$count);
    //echo ${'Mean_'.$courseid}."<br>";

    // Find SD of all questions
    ${'Variance_'.$courseid} = 0.0;
    for ($i = 1; $i <= $numq; $i++)
    {
	if (${'q'.$i} == 0) continue;
	else ${'Variance_'.$courseid} += pow((${'q'.$i}/$count) - ${'Mean_'.$courseid}, 2);
    }
    ${'Variance_'.$courseid} = ${'Variance_'.$courseid}/$division;
    ${'SD_'.$courseid} = sqrt(${'Variance_'.$courseid});

//    echo ${'Mean_'.$courseid};
//    echo ${'SD_'.$courseid};

//

mysql_connect("localhost",$sqlUN,$sqlP);

@mysql_select_db("CourseFeedback") or die("Unable to select database");

$curYear = (int)date("Y");
$tobreak = false;
echo $curYear;
$average = array();

array_push($average,(float)${'Mean_'.$courseid});

	while(1){
		$query = "select * from backup".$curYear."Autumn where courseid='$courseid'";
		$result = mysql_query($query);
		if($result){
			if($row=mysql_fetch_array($result)){
				echo "reached 1";
				array_push($average,(float)$row[1]);
			}
		}else{
			$tobreak=true;
		}
		$query = "select * from backup".$curYear."Spring where courseid='$courseid'";
		$result = mysql_query($query);
		if($result){
			if($row=mysql_fetch_array($result)){
				echo "reached 2";
				array_push($average,(float)$row[1]);
			}
		}else{
			$tobreak=true;
		}
		if($tobreak){
		break;}
		$curYear--;
		}

print_r($average);

?>
