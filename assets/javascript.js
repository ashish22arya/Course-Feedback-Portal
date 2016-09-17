function checkInputOnSubmit(minlength,inputTarget,errorTarget){
var input = inputTarget.value;
if(hasWhiteSpace(input)){
errorTarget.innerHTML = "No white spaces allowed";
return 0;
}else if(input.length<minlength){
errorTarget.innerHTML = "Min "+minlength+" letters required";
return 0;
}else{
errorTarget.innerHTML = "";
return 1;
}
}

function hasWhiteSpace(s) {
return /\s/g.test(s);
}

function onInputListener(maxlength,inputTarget,errorTarget){
var input = inputTarget.value;
if(input.length==maxlength){
errorTarget.innerHTML = "Max "+maxlength+" letters allowed";
}else{
errorTarget.innerHTML = "";
}
}
