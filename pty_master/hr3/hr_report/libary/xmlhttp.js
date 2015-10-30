var xmlHttp = XmlHttpRequestObject();
function XmlHttpRequestObject()
{ 
	var objXmlHttp = null
	if (navigator.userAgent.indexOf("Opera")>=0)
	{
		alert("Error creating the XMLHttpRequest object.") 
		return 
	}

	if (navigator.userAgent.indexOf("MSIE")>=0)
	{ 
		var strName	="MSXML2.XMLHTTP"
		if (navigator.appVersion.indexOf("MSIE 5.5")>=0)
		{
			strName="Microsoft.XMLHTTP"
		} try { 
			objXmlHttp	= new ActiveXObject(strName)
			return objXmlHttp
		} catch(e) { 
			alert("Error. Scripting for ActiveX might be disabled") 
			return 
		} 
	} 

	if (navigator.userAgent.indexOf("Mozilla")>=0)
	{
		objXmlHttp				= new XMLHttpRequest()
		objXmlHttp.onload	= handler
		objXmlHttp.onerror	= handler 
		return objXmlHttp
	}
} 

<!-- -----------------------------------------------------Set Emotion on form  -->
function setsmile(what){
	document.post.message.value = document.post.elements.message.value+" "+what;
	document.post.message.focus();
}

<!-- -------------------------------------------------Check / Uncheck List All  -->
function checkUncheckAll(theElement) {

	var theForm = theElement.form, z = 0;
	for(z=0; z<theForm.length;z++){ 	
		if(theForm[z].type == 'checkbox' && theForm[z].name != 'checkall') theForm[z].checked = theElement.checked;       
	}
	 
}

<!-- --------------------------------------------------------Hidden Status Bar -->
function hidestatus(){
window.status=''
return true
}

if (document.layers)
document.captureEvents(Event.MOUSEOVER | Event.MOUSEOUT)
document.onmouseover	= hidestatus
document.onmouseout	= hidestatus

<!-- -----------------------------------Close Popup and Refresh Main Page -->
function closewin() {
	window.opener.location.reload();
	self.close();
}

<!-- --------------------------------------------Flip Color when mouse Over -->
function mOvr(src,clrOver){ 
if (!src.contains(event.fromElement)){ 
	src.style.cursor = 'hand'; 
	src.bgColor = clrOver; 
}} 

<!-- ---------------------------------------------Flip Color when mouse Out -->
function mOut(src,clrIn){ 
if (!src.contains(event.toElement)){ 
	src.style.cursor = 'default'; 
	src.bgColor = clrIn; 
}} 

<!-- ------------------------------------------Jump to Another URL by Click -->
function jump(url)
{	
	window.location.href = url;
}

<!-- ------------------------------------------------------------Check Langth -->
var ns6=document.getElementById&&!document.all

function restrictinput(maxlength,e,placeholder){
	
  if (window.event&&event.srcElement.value.length>=maxlength)
	return false
  else if (e.target&&e.target==eval(placeholder)&&e.target.value.length>=maxlength){
   	var pressedkey=/[a-zA-Z0-9\.\,\/]/ 
  if (pressedkey.test(String.fromCharCode(e.which)))
  	e.stopPropagation()
  }
  
}

function countlimit(maxlength,e,placeholder){
var theform=eval(placeholder)
var lengthleft=maxlength-theform.value.length
var placeholderobj=document.all? document.all[placeholder] : document.getElementById(placeholder)

if (window.event||e.target&&e.target==eval(placeholder)){
  if (lengthleft<0)
    theform.value=theform.value.substring(0,maxlength)
    placeholderobj.innerHTML=lengthleft
  }
}

function displaylimit(theform,thelimit){
var limit_text='<span id="'+theform.toString()+'">'+thelimit+'</span>'
if (document.all||ns6)
  document.write(limit_text)
  if (document.all){
    eval(theform).onkeypress=function(){ return restrictinput(thelimit,event,theform)}
    eval(theform).onkeyup=function(){ countlimit(thelimit,event,theform)}
  }
  else if (ns6){
    document.body.addEventListener('keypress', function(event) { restrictinput(thelimit,event,theform) }, true); 
    document.body.addEventListener('keyup', function(event) { countlimit(thelimit,event,theform) }, true); 
  }
}

<!-- ------------------------------------------------------------Check Number -->
function Filter_Keyboard() {
  var keycode = window.event.keyCode;
  if( keycode >=37 && keycode <=40 ) 	return true;  // arrow left, up, right, down  
  if( keycode >=48 && keycode <=57 ) 	return true;  // key 0-9
  if( keycode >=96 && keycode <=105) 	return true;  // numpad 0-9
  if( keycode ==110 || keycode ==190) 	return true;  // dot
  if( keycode ==8) 									return true;  // backspace
  if( keycode ==9) 									return true;  // tab
  if( keycode ==45 ||  keycode ==46 || keycode ==35 || keycode ==36) return true;  // insert, del, end, home
  return false;
}

<!-- -----------------------------------------------------------CheckBox Array -->
js_globalArr = new Array();
function js_buildArrStructure(f_cBoxArg){

  if(f_cBoxArg.checked == true){

    fn_cBoxArr = new Array();
    fn_cBoxArr.push(f_cBoxArg.name);
    fn_cBoxArr.push(f_cBoxArg.value);
    js_globalArr.push(fn_cBoxArr);

  } else{
 
    fn_remVal = new Array();
    fn_remVal.push(f_cBoxArg.name);
    fn_remVal.push(f_cBoxArg.value);

    if(js_globalArr.length == 1){

      js_globalArr = js_globalArr.unshift();
      js_globalArr = new Array();

    } else{

      for(var s_index = 0; s_index < js_globalArr.length; s_index++){
        tmp_arr = new Array();
        tmp_arr = js_globalArr[s_index];

        if(tmp_arr.toString() == fn_remVal.toString()){
          js_globalArr.splice(s_index, 1);
        } else{
           continue;
        }
      }
    }
  }
}

var isNN = (navigator.appName.indexOf("Netscape")!=-1);
function autoTab(input,len, e) {
	var keyCode = (isNN) ? e.which : e.keyCode; 
	var filter = (isNN) ? [0,8,9] : [0,8,9,16,17,18,37,38,39,40,46];
	if(input.value.length >= len && !containsElement(filter,keyCode)) {
		input.value = input.value.slice(0, len);
		input.form[(getIndex(input)+1) % input.form.length].focus();
	}

	function containsElement(arr, ele) {
	var found = false, index = 0;
		while(!found && index < arr.length)
			if(arr[index] == ele)
				found = true;
			else
				index++;
		return found;
	}

	function getIndex(input) {
		var index = -1, i = 0, found = false;
		while (i < input.form.length && index == -1)
			if (input.form[i] == input)
				index = i;
			else 
				i++;
			return index;
	}

	return true;
}