<!DOCTYPE html>
<?php include "checkFeedback.php";?>
<html>
<head>
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
<body>
<h1  style="font-family:roboto-medium;color:#fff;">Alter questions</h1>
<input type= 'button' value = "Back" onclick="history.back()"><br><br>
<div class="loginDiv" style="width:840px;">
<div id="questions">
</div>
<br>
<input type="button" value="edit" id="editbtn" onclick="editClicked()" style="margin:10px;"/>
<input type="button" value="delete" id="deletebtn" onclick="deleteClicked()" style="margin:10px;"/>	
<br>
<br>
<br>
<div>
<input type="checkbox" value="add" id="addbtn"/><label for="addbtn" >Add question</label><br>
<br><font style="font-family:roboto-medium;color:#fff;">Make changes here :</font>
<br><span id="sno"></span>
<br>
<span id="errorText"></span>
<textarea rows="5" cols="100" disabled="true" id="alteringQuestion"></textarea>
<br><br>
<font  style="font-family:roboto-medium;color:#fff;">Relevance</font>
<br>
<input type="text" name="relevance" id="relevanceI" disabled="true" style="width:30px;"/><br>
<br>
<input type="button" value="save" id="savebtn" disabled="true" onclick="saveClicked()" style="margin:10px;"/>
<input type="button" value="cancel" id="cancelbtn" disabled="true" onclick="cancelClicked()" style="margin:10px;"/>

</div>
</div>
</div>
<script>

document.getElementById('addbtn').addEventListener('click',addBtnClicked);

function addBtnClicked(){
if(document.getElementById('addbtn').checked){
disableAlterThings(false);document.getElementById('alteringQuestion').value="";document.getElementById('relevanceI').value="";
}
}

function refreshQuestions(){
var questions = document.getElementById('questions');
var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                        var response = xhttp.responseText;
                        questions.innerHTML = response;       
                }
                }       
        xhttp.open("GET","getQuestions.php", true);
        xhttp.send();
        //courses.innerHTML = searchBox.value;
}
refreshQuestions();

function deleteClicked(){
var qsn = document.getElementById('question').value;
var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                        //var response = xhttp.responseText;
                        //questions.innerHTML = response;       
                	refreshQuestions();
		}
                }       
        xhttp.open("GET","deleteQuestion.php?qsn="+qsn+"", true);
        xhttp.send();
        //courses.innerHTML = searchBox.value;
}

function editClicked(){
var textArea = document.getElementById('alteringQuestion');
var qsn = document.getElementById('question').value;
document.getElementById('sno').innerHTML = qsn;
if(qsn!=""){
disableAlterThings(false);
document.getElementById('addbtn').checked=false;
var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                        var response = xhttp.responseText+"";
                        var pieces = response.split("//-1//");
			//questions.innerHTML = response;       
                        textArea.value = pieces[0].trim();
			document.getElementById('relevanceI').value = pieces[1];
			
                }
                }       
        xhttp.open("GET","getQuestion.php?qsn="+qsn+"", true);
        xhttp.send();
}
}

function saveClicked(){

var textArea = document.getElementById('alteringQuestion');
var qsn = document.getElementById('question').value;
var page = "editQuestion.php";
var add = document.getElementById('addbtn');
if(add.checked)
page="addQuestion.php";

var relevance = document.getElementById('relevanceI').value;

if((textArea.value=="")||(relevance!="l"&&relevance!="t"&&relevance!="p"&&relevance!="c")){
document.getElementById('errorText').innerHTML = "invalid input";
}else{
document.getElementById('errorText').innerHTML = "";

var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                  	//document.getElementById('errorText').innerHTMl = xhttp.responseText+"";
                      	disableAlterThings(true);
			refreshQuestions();
			document.getElementById('addbtn').checked=false;

                }
                }       
        xhttp.open("POST",""+page+"", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("qsn="+qsn+"&question="+textArea.value+"&relevance="+relevance+"");

}
document.getElementById('alteringQuestion').value="";
document.getElementById('relevanceI').value="";
}

function cancelClicked(){
document.getElementById('alteringQuestion').value="";
document.getElementById('relevanceI').value="";
disableAlterThings(true);
document.getElementById('addbtn').checked=false;
}

function disableAlterThings(disable){
document.getElementById('savebtn').disabled=disable;
document.getElementById('cancelbtn').disabled=disable;
document.getElementById('editbtn').disabled=!disable;
document.getElementById('deletebtn').disabled=!disable;

if(document.getElementById('question')!=null)
document.getElementById('question').disabled=!disable;

document.getElementById('addbtn').disabled=!disable;
document.getElementById('relevanceI').disabled=disable;
document.getElementById('alteringQuestion').disabled=disable;
}

</script>
</body>
</html>
