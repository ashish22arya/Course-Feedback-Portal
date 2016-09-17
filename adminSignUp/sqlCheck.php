<?php
$username = $_GET['sqlUserName'];
$password = $_GET['sqlPassword'];

$database="CourseFeedbackV2";
if(@mysql_connect('localhost',$username,$password))
echo "2";
else
echo "1";

//@mysql_select_db($database) or die( "Unable to select database<br>Sql User Name or Password is wrong!!!");
//mysql_close();

?>
