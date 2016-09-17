<!DOCTYPE html>
<html>

<head>
<title>

Upload file

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

<body style="text-align:center;background-color:#ddd;font-family:roboto-medium;color:#fff;">
<input type= 'button' value = "Back" onclick="history.back()"><br><br>
<!--
<h1>Choose appropriate excel(.xls) file for populating the database</h1> -->
<br>
<div class="loginDiv">

<form name="myForm" method="post" action="upload.php" enctype="multipart/form-data" id="form1">
	Semester :  
	<select name="semester">
		<option value="Autumn">Autumn</option>
		<option value="Spring">Spring</option>
	</select>
	
	<br><br>
	Choose appropriate excel(.xls) file for populating the database
	<br><br>
	<input type="file" name="fileToUpload" id="fileToUpload" style="width:200px;"/>
	<br>
	<br>
	<b>
	<input type="button" value="Submit" name="submitBtn" onclick="submitClicked()"/>
</form>

</div>
	
<script>
function submitClicked(){
document.getElementById('form1').submit();}
</script>

</body>
</html>
