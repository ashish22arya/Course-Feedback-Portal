<!DOCTYPE html>
<html>
<head>
<title>

View Accounts.

</title>

<script type="text/javascript" src="/project/assets/javascript.js"></script>
<script>

function onSubmit(){

	var allOK = 1;

	var username = document.getElementById("userName");
	var usernameerror = document.getElementById("userNameError");
	var user = document.getElementById("user");
	var un = checkInputOnSubmit(5,username,usernameerror);

	allOK = (un)?1:0;
	if(allOK==1){
        	var xhttp = new XMLHttpRequest();
        	xhttp.onreadystatechange = function() {
                if (xhttp.readyState == 4 && xhttp.status == 200) {

			document.getElementById("result").innerHTML = xhttp.responseText;                        
        	}
		}	
        xhttp.open("GET", "/project/admin/viewAccount.php?user="+user.value+"&username="+username.value+"", false);
        xhttp.send();
	}

	
}

</script>
<link type="text/css" rel="stylesheet" href="/project/assets/style.css"/>
</head>
<body>
<h1 style="padding:0px;margin-top:50px;color:#fff;text-shadow:0 1px 1px #999;font-family:roboto-medium;">View account</h1>
<input type ="button" onclick = "history.back(1);" value="Back"/>
<div class="loginDiv">
<font style="padding:0px;margin-top:50px;color:#fff;font-family:roboto-medium;">Select User : </font><select name="user" id="user">
	<option value="student">Student</option>
	<option value="faculty">Faculty</option>
	</select>
<br><br><div id="userNameError" class="inputError"></div>
<input type="text" id="userName" maxlength="20" placeholder="Username"/>
<br><br>
<input type="button" value="Submit" id="signUp" onclick="onSubmit()"/><br><br>
<div style="background-color:rgba(128,203,196,1);border-radius:5px;width:300px;margin-left:auto;margin-right:auto;padding:10px;
font-family:roboto-medium;color:#fff;">
<font id="result"></font>
</div>
</div>

<script>


var username = document.getElementById("userName");
username.addEventListener("input",function(){ onInputListener(20,username,document.getElementById("userNameError"));});


</script>
</body>
<html>
