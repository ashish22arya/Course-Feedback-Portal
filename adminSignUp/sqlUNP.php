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
	//var un = checkInputOnSubmit(5,username,usernameerror)
	//var p = checkInputOnSubmit(5,password,passworderror);

	//allOK = (un&&p)?1:0;

	var xhttp = new XMLHttpRequest();
  	xhttp.onreadystatechange = function() {
    		if (xhttp.readyState == 4 && xhttp.status == 200) {
      			var response = xhttp.response;
        		if(response==1){
                		usernameerror.innerHTML = "this username does not work"//invalid
				passworderror.innerHTML = "this password does not work"//invalid
                
        		}else if(response==2){
                		//document.getElementById('demo').innerHTML = "valid"
                                usernameerror.innerHTML = ""//invalid
                                passworderror.innerHTML = ""//invalid
				document.getElementById('form1').submit();
        		}
    		}

	}
  	xhttp.open("GET", "sqlCheck.php?sqlUserName="+username.value+"&sqlPassword="+password.value+"", true);
  	xhttp.send();

}

</script>

<head>
<body style="text-align:center;background-color:#ddd;">
<form id="form1" method="post" action="adminSignUp.php">
<div style="-ms-transform: translateX(-50%) translateY(-50%);-webkit-transform: translate(-50%,-50%);transform: translate(-50%,-50%);position:absolute;top:50%;left:50%;
width:400px;text-align:center;background-color:#eee;padding:20px;border-radius:3px;box-shadow: 0px 2px 1px #aaa;">
<h2 style="padding:0px;margin:0px;">Enter sql username and password</h2>
<br><br>
<div class="textInput"><input type="text" id="userName" maxlength="20" name="sqlUserName" placeholder="Username"/><br><div class="inputError" id="userNameError"> </div></div>
<br>
<div class="textInput"><input type="password" id="password" maxlength="20" name="password"  placeholder="password"/><br><div class="inputError" id="passwordError"> </div></div>
<br>
<input type="button" value="save" id="signUp" onclick="onSubmit()" style=""/>
<br>
<font id="result"></font>
</div>
</form>
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
