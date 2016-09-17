<!DOCTYPE html>
<html>
<head>
<title>

faculty sign up

</title>
<link type="text/css" rel="stylesheet" href="/project/assets/style.css"/>
<script type="text/javascript" src="/project/assets/javascript.js"></script>
<script>

function onSubmit(){

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
                                usernameerror.innerHTML = "Account already exists";
				allOK=0;
                        }else{
				//usernameerror.innerHTML = response;
			}
        	}
		}	
        xhttp.open("GET", "checkFacultyUserName.php?username="+username.value+"", false);
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
				document.getElementById("result").innerHTML = "Account Created";
                        }else{
				document.getElementById("result").innerHTML = "Unknow error occured , account cannot be created"; 	
			}
                }
		}       
        xhttp.open("GET", "createFacultyAccount.php?username="+username.value+"&password="+password.value+"", true);
        xhttp.send();
        }	
}

</script>

<head>
<body>

<h1 style="padding:0px;margin-top:50px;color:#fff;text-shadow:0 1px 1px #999;font-family:roboto-medium;">FACULTY SIGN UP</h1>
<input type ="button" onclick = "history.back(1);" value="Back"/>
<div class="loginDiv">
<img src="/project/assets/account-circle.png" width="80px"/>
<div id="userNameError"class="inputError"></div>
<input type="text" id="userName" maxlength="20" placeholder="Username"/>
<br><br>
<div id="passwordError"class="inputError"></div>
<input type="password" id="password" maxlength="20" placeholder="Password"/>
<br><br><br>
<input type="button" value="create account" id="signUp" onclick="onSubmit()"/>

</div>
<div style="background-color: rgba(85,110,151,1);padding:10px;border-radius:5px;width:300px;margin-left:auto;margin-right:auto;
font-family:roboto-medium;color:#fff;position:absolute;bottom:30px;right:40%;">
<font id="result"></font>
</div>
<script>

var username = document.getElementById("userName");
username.addEventListener("input",function(){ onInputListener(20,username,document.getElementById("userNameError"));});

var password = document.getElementById("password");
password.addEventListener("input",function(){ onInputListener(20,password,document.getElementById("passwordError"));});

</script>
</body>
<html>
