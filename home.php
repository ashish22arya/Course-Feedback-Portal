<!DOCTYPE html>
<html>
<head>
<title>
LOGIN
</title>
<script type="text/javascript" src="assets/javascript.js"></script>
<script>

function signupclicked(){
var username = document.getElementById("userName");
var password = document.getElementById("password");
var usernameerror = document.getElementById("userNameError");
var passworderror = document.getElementById("passwordError");
//var userType = document.getElementById("form1").elements.namedItem("userType").value;

var un = checkInputOnSubmit(5,username,usernameerror);
var p = checkInputOnSubmit(5,password,passworderror);

var allOK = (un&&p)?1:0;
	if(allOK==1){
               var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                        var response = xhttp.responseText;
                        if(response==1){
                                usernameerror.innerHTML = "Already has an account";
                                allOK=0;
                        }else if(response==3){
                                usernameerror.innerHTML = "Not enrolled in any courses";
				allOK=0;
                        }else{
				createStudentAccount();
			}
                }
                }       
        xhttp.open("GET", "checkStudentRollno.php?rollno="+username.value+"", true);
        xhttp.send();
	}

//	usernameerror.innerHTML = " "+allOK+" ";

function createStudentAccount(){

	if(1){
               var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                        var response = xhttp.responseText;
                        if(response==1){
				//window.location.href = "studenthome.php";
                                //usernameerror.innerHTML = "Already has an account";
                                //allOK=0;
				document.getElementById('form1').action = "student/studentHome.php";
				document.getElementById('form1').method = "get";
				document.getElementById('form1').submit();
                        }else{
                                document.getElementById('error').innerHTML = "account not created , unknown error occured";
                                //allOK=0;
                        }
                }
                }       
        xhttp.open("GET", "createStudentAccount.php?rollno="+username.value+"&password="+password.value+"", true);
        xhttp.send();
        }
}

}

function signinclicked(){

var username = document.getElementById("userName");
var password = document.getElementById("password");
var usernameerror = document.getElementById("userNameError");
var passworderror = document.getElementById("passwordError");
var userType = document.querySelector('input[name="userType"]:checked').value;
//username.value=userType;
var un = checkInputOnSubmit(5,username,usernameerror);
var p = checkInputOnSubmit(5,password,passworderror);

var allOK = (un&&p)?1:0;
        if(allOK==1){
               var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                        var response = xhttp.responseText;
                        if(response==1){
                                usernameerror.innerHTML = "Did not have account";
                                passworderror.innerHTML = "";
                        }else if(response==2){
                                usernameerror.innerHTML = "";
                                passworderror.innerHTML = "incorrect password";
                        }else{
                		document.getElementById('form1').action = userType+"/"+userType+"Home.php";
				if(userType=="student")
				document.getElementById('form1').method = "get";
                                document.getElementById('form1').submit();
                             }
                }
                }       
        xhttp.open("GET", "checkCredentials.php?userName="+username.value+"&password="+password.value+"&userType="+userType+"", true);
        xhttp.send();
        }

}

</script>

<link type="text/css" rel="stylesheet" href="/project/assets/style.css"/>

<style>
</style>

</head>

<body>

<h1 style="padding:0px;margin-top:50px;color:#fff;text-shadow:0 1px 1px #999;font-family:roboto-medium;">Course feedback</h1>

<div class="loginDiv">
<img src="/project/assets/account-circle.png" width="80px"/>
<h1 style="padding:0px;margin:0px;color:#ffffff;">Login</h1>

<br>
<form id="form1" method="post">

<input type="radio" name="userType" value="student" id="student" checked/>
<label for="student">Student</label>
<input type="radio" name="userType" value="faculty" id="faculty" />
<label for="faculty">Faculty</label>
<input type="radio" name="userType" value="admin" id="admin"/>
<label for="admin">Admin</label>
<br><br>

<div class="inputError" id="userNameError"></div>
<input type="text" id="userName" maxlength="20" name="userName" placeholder="Roll no">
<br>
<br>
<div class="inputError" id="passwordError"></div>
<input type="password" id="password" maxlength="20" placeholder="password"/>
<br>
<br>
<input type="button" name="signup" value="sign up" id="signup" onclick='signupclicked()' /> <input type="button" name="signin" value="sign in" id="signin" onclick='signinclicked()'/>

</form>
<p id="error"></p>
</div>
<script>

var username = document.getElementById("userName");
username.addEventListener("input",function(){ onInputListener(20,username,document.getElementById("userNameError"));});

var password = document.getElementById("password");
password.addEventListener("input",function(){ onInputListener(20,password,document.getElementById("passwordError"));});

document.getElementById('student').addEventListener("click",function(){
document.getElementById("signup").disabled=false;
document.getElementById("userName").placeholder="Roll no";
});

document.getElementById('faculty').addEventListener("click",function(){
document.getElementById("signup").disabled=true;
document.getElementById("userName").placeholder="Username";
});

document.getElementById('admin').addEventListener("click",function(){
document.getElementById("signup").disabled=true;
document.getElementById("userName").placeholder="Username";
});

//document.getElementById('signup').addEventListener('click',signupclicked());

</script>

</body>
</html>
