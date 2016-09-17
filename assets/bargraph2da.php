<!DOCTYPE html>

<html>

<body style="width:100%;height:100%;text-align:center;">

<canvas id="can" width="700px" height="700px">
browser dont support canvas</canvas>


<script type="text/javascript" src="BarGraph2DA.js">


</script>

<script>
//getting context
var canvas = document.getElementById("can");
var ctx = canvas.getContext("2d");

var ob = {label:"AU-15",value:3};
var mplot = [];
mplot.push(ob);

var ob = {label:"SP-15",value:2};
mplot.push(ob);

drawAnimatedGraph(100,100,100,100,100,100,mplot,5,canvas,ctx,50);

</script>

</body>

</html>

