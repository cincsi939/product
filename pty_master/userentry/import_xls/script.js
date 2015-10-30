// JavaScript Document

function importdata(){	 
document.getElementById('f1_upload_process').style.visibility = 'visible';
document.getElementById('f1_upload_form').style.visibility = 'hidden';
}
function stopimportdata(){	 
 document.getElementById('f1_upload_process').style.visibility = 'hidden';
 document.getElementById('f1_upload_form').style.visibility = 'visible';}
function editdata(){

}





function Checkdata(chk_desc,msg){
if(chk_desc.value.length>0){
	return true;	
	}	
else{
	alert(msg);
	chk_desc.setfocus();
return true;		
	}

}
