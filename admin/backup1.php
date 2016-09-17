<?php
echo "<br><br> making backups <br><br>";

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

$conn = new mysqli("localhost",$sqlUN,$sqlP,"CourseFeedback");
if($conn->connect_error){
	echo "Connection Failed:".$conn->connect_error;
}

$course_query = "select courseId from course";
$course_result = $conn->query($course_query);

if ($course_result->num_rows == 0){
	//no courses
}else{
	//Take year and sem from excelFile table
	$data_query = "select * from excelFile where sno=(select max(sno) from excelFile)"; 
	$data_result = $conn->query($data_query); 
	$data = $data_result->fetch_assoc();
	$year = $data["year"];
	$sem = $data["semester"];

	//dropping backup<year><semester> table if not present
	$check_query = "drop table backup".$year.$sem;
	$check_result = $conn->query($check_query);

	//creating backup<year><semester> table
    	$table_query = "create table backup".$year.$sem."(courseId varchar(10) primary key, mean float, sd float)";
    	$table_result = $conn->query($table_query);
    	if ($table_result == FALSE)
		echo "Could not create table: ".mysql_error();
	else
		echo "backup table backup$year$sem created<br>";
}

//iterate through <courseid>Feedback(if exists) and find mean of every question
while($course = $course_result->fetch_assoc()){
    	$count = 0;
    	$feedback_query = "select * from ".$course['courseId']."Feedback;";
    	$feedback_result = $conn->query($feedback_query);

    	//Find num of ques
    	$numq_query = "show columns from ".$course['courseId']."Feedback;";
    	$numq_result = $conn->query($numq_query); 
    	$numq = ($numq_result->num_rows) - 1;
    	if ($numq == -1) continue;
    	$division = $numq;

    	//Find mean feedback of every ques (store in $q1,$q2,..)
    	for($i = 1; $i <= $numq; $i++)
		${'q'.$i} = 0;
    	while($feedback = $feedback_result->fetch_assoc()){	
		$count++;
    		for ($i = 1; $i <= $numq; $i++)
	    		${'q'.$i} = ${'q'.$i} + $feedback["q".$i];
    	}

    	// Find mean feedback of all questions (store in $Mean_IC150,...)
    	${'Sum_'.$course["courseId"]} = 0.0;
    	for($i = 1; $i <= $numq; $i++){
		${'Sum_'.$course["courseId"]} = ${'Sum_'.$course["courseId"]} + ${'q'.$i};
		if(${'q'.$i} == 0)
    			$division--;
   	}
    	echo $course["courseId"].":".$division."<br>";
    	${'Mean_'.$course["courseId"]} = ${'Sum_'.$course["courseId"]}/($division*$count);
    	//echo ${'Mean_'.$course["courseId"]}."<br>";

    	// Find SD of all questions
    	${'Variance_'.$course["courseId"]} = 0.0;
    	for ($i = 1; $i <= $numq; $i++){
		if (${'q'.$i} == 0) continue;
		else ${'Variance_'.$course["courseId"]} += pow((${'q'.$i}/$count) - ${'Mean_'.$course["courseId"]}, 2);
    	}
    	${'Variance_'.$course["courseId"]} = ${'Variance_'.$course["courseId"]}/$division;
    	${'SD_'.$course["courseId"]} = sqrt(${'Variance_'.$course["courseId"]});

    	// Populate Backup<Year><Sem> table
    	$insert_query = "insert into backup".$year.$sem."(courseId, mean, sd) values ('".$course["courseId"]."',".${'Mean_'.$course["courseId"]}.",".${'SD_'.$course["courseId"]}.");";
    
    	echo $insert_query."<br>";
    	$insert_result = $conn->query($insert_query);
    	if ($insert_result == FALSE)
		echo "Could not insert data into table: ".mysql_error()."<br><br>";
	}
?>
