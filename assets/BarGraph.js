function printBarGraph(x0,y0,lp,rp,bp,tp,m,noofoptions,canvas,ctx){

/*origin
var x0,y0;
x0=100;
y0=100;
*/

/*paddings
var lp,rp,bp,tp;
lp = x0;
rp=x0;
bp=y0;
tp=y0;
*/

	//height and width of canvas
	var h,w;
	h=canvas.height;
	w=canvas.width;

	//printing axes
	printAxes(h,w,bp,tp,lp,rp);

	function printAxes(h,w,bp,tp,lp,rp){
		ctx.beginPath();
		ctx.moveTo(lp,h-bp);
		ctx.lineTo(lp,tp);
		//ctx.strokeStyle="rgb(00,00,00)";
		ctx.closePath();
		ctx.stroke();//left
		ctx.beginPath();
		ctx.moveTo(lp,h-bp);
		ctx.lineTo(w-rp,h-bp);
		ctx.closePath();
		ctx.stroke();
	}

/*mean array
var m = [1,2,3,4,5,4.5,3.5,2.5,1.5,0.5];
*/

	//x and y ratios
	var ymr,xmr,n;
	n=m.length;
	ymr=(h-bp-tp)/(noofoptions+1);
	xmr=(w-lp-rp)/(n+1);

	var i = 1;

	//printing tick marks
	while(i<=noofoptions){
		ctx.beginPath();
		ctx.moveTo(convertX(0),convertY(i*ymr));
		ctx.lineTo(convertX(0-5),convertY(i*ymr));
		ctx.closePath();
		ctx.stroke();
		ctx.fillStyle = "rgba(128,203,196,1)";
		ctx.font = "20px Arial";
		ctx.fillText(i,convertX(0-20),convertY(i*ymr-7));
		i++;
	}

	i=1;

	//printing graph
	while(i<=n){
		ctx.beginPath();
		ctx.moveTo(convertX(i*xmr-xmr/3),convertY(0));
		ctx.lineTo(convertX(i*xmr-xmr/3),convertY(m[i-1]*ymr));
		ctx.lineTo(convertX(i*xmr+xmr/3),convertY(m[i-1]*ymr));
		ctx.lineTo(convertX(i*xmr+xmr/3),convertY(0));
		ctx.closePath();
		ctx.stroke();
		ctx.fillStyle = "rgba(128,203,196,0.5)";
		ctx.fill();
		ctx.fillStyle = "rgba(128,203,196,1)";
		ctx.font = "10px Arial";
		ctx.fillText("Q"+i,convertX(i*xmr-5),convertY(0-15));
		ctx.fillText(m[i-1].toFixed(2),convertX(i*xmr-5),convertY(m[i-1]*ymr+10));
		i++;
	}

	function convertX(x){
		return lp+x;
	}

	function convertY(y){
		return h-(bp+y);
	}

}

function hexToR(h) {return parseInt((cutHex(h)).substring(0,2),16)}
function hexToG(h) {return parseInt((cutHex(h)).substring(2,4),16)}
function hexToB(h) {return parseInt((cutHex(h)).substring(4,6),16)}
function cutHex(h) {return (h.charAt(0)=="#") ? h.substring(1,7):h}


function drawAnimatedGraph(x0,y0,lp,rp,bp,tp,mplot,noofoptions,canvas,ctx,nor){

window.requestAnimFrame = (function(callback) {
        return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame ||
        function(callback) {
          window.setTimeout(callback,1000/60);
        };
      })();

	function animate(canvas, ctx, startTime,i,nor) {

        // update
        var time = (new Date()).getTime() - startTime;
	var m = getTempArray(mplot,i,nor);

	i=i+1;

        // clear
        ctx.clearRect(0, 0, canvas.width, canvas.height);

	printBarGraph(x0,y0,lp,rp,bp,tp,m,noofoptions,canvas,ctx);	
	
	if(i<=nor){
        // request new frame
        requestAnimFrame(function() {
        animate(canvas,ctx,startTime,i,nor);
        });}
      }

//filling full canvas with a color
ctx.fillStyle = "#fff";
ctx.fillRect(0,0,500,500);

function getTempArray(array,i,nor){

var ar = new Array();
var index = 0;
while(index<array.length){
ar.push((i)*array[index]/nor);
index++;
}
return ar;

}

// wait one second before starting animation
      setTimeout(function() {
        var startTime = (new Date()).getTime();
        animate(canvas, ctx, startTime,0,50);
      }, 10);

}


