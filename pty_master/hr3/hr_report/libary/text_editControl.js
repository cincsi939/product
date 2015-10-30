function button_over(eButton)	{
	eButton.style.backgroundColor = "#ffff99"
	eButton.style.borderColor = "darkblue darkblue darkblue darkblue"
}

function button_out(eButton) {
	eButton.style.backgroundColor = ""
	eButton.style.borderColor = ""
}

function button_down(eButton) {
	idContent.focus();
	eButton.style.backgroundColor = "#ff3300"
	eButton.style.borderColor = "darkblue darkblue darkblue darkblue"
}

function button_up(eButton) {
	eButton.style.backgroundColor = "#ff9900"
	eButton.style.borderColor = "darkblue darkblue darkblue darkblue"
	eButton = null; 
}

function document.onreadystatechange() {
   //idContent.document.designMode="On";
}

function cmdExec(cmd,opt) {
  	idContent.document.execCommand(cmd,"",opt);
	idContent.focus();
}

function foreColor()	{
	var prop 	= "font-family:'tahoma'; font-size:10pt; dialogWidth:156px; dialogHeight:130px; status:no;";
	var arr 		= showModalDialog("../libary/selcolor.php?bgcolor=","", prop);
	if (arr != null) cmdExec("ForeColor",arr);		
}

function backColor()	{
	var prop 	= "font-family:'tahoma'; font-size:10pt; dialogWidth:156px; dialogHeight:130px; status:no;";
	var arr 		= showModalDialog("../libary/selcolor.html?bgcolor=","", prop);
	if (arr != null) cmdExec("BackColor",arr);		
}

function insert_image()	{
	var url			= "../libary/insert_image.php";
	var newwin 	= window.open(url,'popup','location=0,status=no,scrollbars=no,resizable=no,width=400,height=390,top=200');
	newwin.focus();
} 

function db_image(id)	{
	var url 			= "../libary/insert_image_db.php?id=" + id + "&rnd=" + Math.random() ;
	var newwin 	= window.open(url ,'popup','location=0,status=no,scrollbars=no,resizable=no,width=400,height=390,top=200');
	newwin.focus();
} 	

function insertEmotion(emo) {
	idContent.focus();
	cmdExec("InsertImage","../images/emotion/" + emo  + ".gif");
}