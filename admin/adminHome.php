<html>
<head>
<title>
Admin Home Page
</title>
<link type="text/css" rel="stylesheet" href="/project/assets/style.css"/>
<style>
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

<body style="text-align:center;background-color:#ddd;">
<br>
<input type= 'button' value = "Log out" onclick="history.back()"><br><br>
<div style="background-color: rgba(85,110,151,1);padding:10px;border-radius:5px;width:300px;margin-left:auto;margin-right:auto;
font-family:roboto-medium;color:#fff;">
<img src="/project/assets/user.png" width="40px"/><br>
<font id="facultyUserName" style="font-family:roboto-medium;">
<?php
	$userName = $_POST['userName'];
	echo "User Name - $userName";
?>
</font>
</div>
<div class="loginDiv">

	<a href="populateDatabase.php"><div class="link" style="font-family:roboto-medium;color:#fff;">Upload Excel Files</div></a>
	<a href="alterQuestions.php"><div class="link" style="font-family:roboto-medium;color:#fff;">Alter questions</div></a>
	<a href="facultySignUp/facultySignUp.php"><div class="link" style="font-family:roboto-medium;color:#fff;">Sign up faculty</div></a>
	<a href="viewAccountDetails.php"><div class="link" style="font-family:roboto-medium;color:#fff;">View accounts</div></a>
</div>
</body>
</html>	
