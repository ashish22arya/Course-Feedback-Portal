<?php
$courseId = htmlspecialchars($_POST['course']);
//echo $courseId;
?>
<!DOCTYPE html>

<html>
<head>
<link type="text/css" rel="stylesheet" href="/project/assets/style.css"/>
</head>
<body style="width:100%;text-align:center;background-color:#ddd">
<input type= 'button' value = "Back" onclick="history.back()"><br><br>
<div style="background-color:rgba(128,203,196,1);padding:10px;border-radius:5px;width:200px;margin-left:auto;margin-right:auto;
font-family:roboto-medium;color:#fff;position:fixed;left:42%;">
<?php echo htmlspecialchars($_POST['course'])."<br>";?>
Statistics
</div>
<br>
<div style="background-color: rgba(85,110,151,1);border-radius:4px;margin-top:40px;">
<br>
<font style="font-family:roboto-medium;color:#fff;">Average values of feedback of each question<font>
<br>
<canvas id="avg" width="700px" height="700px">
browser dont support canvas</canvas>
</div>
<br>
<div style="background-color: rgba(85,110,151,1);border-radius:4px;">
<br>
<font style="font-family:roboto-medium;color:#fff;">Standard deviation of feedback of each question<font><br>
<canvas id="sd" width="700px" height="700px">
browser dont support canvas</canvas>
</div>
<br>
<div style="background-color: rgba(85,110,151,1);border-radius:4px;">
<br>
<font style="font-family:roboto-medium;color:#fff;">Over all average of the course<font><br>
<canvas id="oaavg" width="700px" height="700px">
browser dont support canvas</canvas>
</div>
<br>
<div style="background-color: rgba(85,110,151,1);border-radius:4px;">
<br>
<font style="font-family:roboto-medium;color:#fff;">Standard deviation of mean values of each question<font><br>
<canvas id="oasd" width="700px" height="700px">
browser dont support canvas</canvas>
</div>
<font id="i"></font>
<script type="text/javascript" src="/project/assets/BarGraph.js">
</script>
<script type="text/javascript" src="/project/assets/BarGraph2DA.js">
</script>
<script>
<?php echo "var id = '".htmlspecialchars($_POST['course'])."';"?>
//document.getElementById('courseId').innerHTML = id;

//getting context
var canvas = document.getElementById("avg");
var ctx = canvas.getContext("2d");

function plotGraph(canvas,ctx,file){
	var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                        var response = xhttp.responseText+"";
                        makeArray(response);
			//document.getElementById('i').innerHTML = response;       
                }
                }       
        xhttp.open("GET",""+file+"?courseId="+id+"", true);
        xhttp.send();

var mplot = new Array();

function makeArray(response){
var pieces = response.split(",");
var index = 0;
while(index<(pieces.length-1)){
mplot.push(pieces[index]);
index++;
}
}
var x = mplot.length;

drawAnimatedGraph(100,100,100,100,100,100,mplot,5,canvas,ctx,50);


}

function plotGraphOA(canvas,ctx,file){
	var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                        var response = xhttp.responseText+"";
                        makeArray(response);
			//document.getElementById('i').innerHTML = response;       
                }
                }       
        xhttp.open("GET",""+file+"?courseId="+id+"", true);
        xhttp.send();

var mplot = new Array();

function makeArray(response){
var pieces = response.split(",");
var index = 0;
while(index<(pieces.length-1)){
var pp = pieces[index].split(":");
var ob = {label:pp[1],value:pp[0]};
mplot.push(ob);
index++;
}
}
//var x = mplot.length;

drawAnimatedGraphOA(100,100,100,100,100,100,mplot,5,canvas,ctx,50);


}

plotGraph(canvas,ctx,"getAverage.php");

canvas = document.getElementById("sd");
ctx = canvas.getContext("2d");

plotGraph(canvas,ctx,"getSD.php");

canvas = document.getElementById("oaavg");
ctx = canvas.getContext("2d");

plotGraphOA(canvas,ctx,"getOverAllAvg.php");

canvas = document.getElementById("oasd");
ctx = canvas.getContext("2d");

plotGraphOA(canvas,ctx,"getOverAllSD.php");

</script>

</body>

</html>
