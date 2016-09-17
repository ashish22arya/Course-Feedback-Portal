<?php
$username = $_POST['sqlUserName'];
$password = $_POST['password'];
//$sem = $_POST['semester'];

$myfile = fopen("/var/www/html/project/assets/sqlUNP.txt", "w") or die("Unable to open file!");
$txt = $username.",".$password.",";
fwrite($myfile, $txt);
fclose($myfile);
?>

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

mysql_query("create database CourseFeedback");

@mysql_select_db("CourseFeedback") or die("Unable to select database");

$result = mysql_query("create table adminAccount (userName varchar(20),password varchar(20))");
$result = mysql_query("create table facultyAccount (userName varchar(20),password varchar(20))");
$result = mysql_query("create table studentAccount (rollNo varchar(10),password varchar(20))");

?>

<!DOCTYPE html>
<html>
<head>
<title>

Admin sign up

</title>
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
<script type="text/javascript" src="/project/assets/javascript.js"></script>
<script>

function onSubmit(){

	document.getElementById("result").innerHTML = "";

	//if it is 1 then create account
	var allOK = 1;

	var username = document.getElementById("userName");
	var password = document.getElementById("password");
	var usernameerror = document.getElementById("userNameError");
	var passworderror = document.getElementById("passwordError");

	//checking inputs in textfields
	var un = checkInputOnSubmit(5,username,usernameerror)
	var p = checkInputOnSubmit(5,password,passworderror);

	allOK = (un&&p)?1:0;

	//checking if account exists already
	if(allOK==1){
        	var xhttp = new XMLHttpRequest();
        	xhttp.onreadystatechange = function() {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                        var response = xhttp.responseText;
                        if(response==1){
                                usernameerror.innerHTML = "Account already exists";//account already exists , do nothing
				allOK=0;
                        }else{
				//account does not exist already , create account
			}
        	}
		}	
        xhttp.open("GET", "checkAdminUserName.php?username="+username.value+"",false);
        xhttp.send();
	}

	//creating account
	if(allOK==1){
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                        var response = xhttp.responseText+"";
                        if(response==1){
                                username.value = "";
                                password.value = "";
				document.getElementById("result").innerHTML = "Result : Account Created";//account created
                        }else{
				document.getElementById("result").innerHTML = "Result : Unknow error occured , account cannot be created";//account not created 	
			}
                }
		}       
        xhttp.open("GET", "createAdminAccount.php?username="+username.value+"&password="+password.value+"", true);
        xhttp.send();
        }
}

</script>

<head>
<body style="text-align:center;background-color:#ddd;">
<div style="-ms-transform: translateX(-50%) translateY(-50%);-webkit-transform: translate(-50%,-50%);transform: translate(-50%,-50);position:absolute;top:50%;left:50%;
width:400px;text-align:center;background-color:#eee;padding:20px;border-radius:3px;box-shadow: 0px 2px 1px #aaa;">
<h2 style="padding:0px;margin:0px;">ADMIN SIGN UP</h2>
<br><br>
<div class="textInput"><input type="text" id="userName" maxlength="20" placeholder="Username"/><br><div class="inputError" id="userNameError"> </div></div>
<br>
<div class="textInput"><input type="password" id="password" maxlength="20" placeholder="password"/><br><div class="inputError" id="passwordError"> </div></div>
<br>
<input type="button" value="create account" id="signUp" onclick="onSubmit()" style=""/>
<br>
<br>
<div id="result" class="inputError"></div>
</div>
<a href="/project/home.php">Home</a>
<script>
//maximum limit check
var username = document.getElementById("userName");
username.addEventListener("input",function(){ onInputListener(20,username,document.getElementById("userNameError"));});
//maximum limit check
var password = document.getElementById("password");
password.addEventListener("input",function(){ onInputListener(20,password,document.getElementById("passwordError"));});
</script>
</body>
<html>
