<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title></title>
</head>

<?php 
$queryString= $_GET['queryString'];
$siteid= $_GET['siteid'];
?>
<link href="style/style_rowover.css" rel="stylesheet" type="text/css" />
<script type="text/javascript"  src="ajax.js"></script>
<script  type="text/javascript"  >
someObject = function()
    {        
        this.messages=null;    
        this.url=null;    
        this.GetData = function()//ส่งค่าไปยัง page
            {                
                this.InitializeRequest('GET', this.url);                
                this.Commit( this.messages);
            }              
        this.OnLoading = function()//กำลังรอ
            {
            var    str_return='<div align="center"><font size="1" color="#000000"  style="font-weight:bold"  >';
                    str_return+='<img src="images/loading.gif" />Pleate Wait...</font></div>';
                document.getElementById('cdisplay').innerHTML =str_return;
               // document.getElementById('txtsearch').rea
            }
        this.OnSuccess = function()//มีการคืนค่ากลับมา
            {
            var str_return=this.GetResponseText();           
            document.getElementById('cdisplay').innerHTML =str_return
            }    
    }
    someObject.prototype = new ajax();
    myObject = new someObject();    
    // Ajax 

 function searchschool(){      
   // myObject.messages='siteid='+document.form1.siteid.value;
  //  myObject.messages+='&queryString=' +document.form1.txtsearch.value  ;
    myObject.url='getschool.php?messagesid=' + Math.random()*1000+'&siteid='+document.form1.siteid.value+'&queryString=' +document.form1.txtsearch.value;
    myObject.GetData( );
    document.form1.txtsearch.focus();
 }
 function filldata(id,str){        
var o = new Object();
    o.Fleetstr = str;
    o.FleetId = id;
window.returnValue = o;
window.close();   

 }   
</script>
</head>
<body onload="searchschool()">
<form name="form1" id="form1" action="#">
<table width="100%" >
<tr>
	<td align="center">
    <input  type="hidden" name="siteid" id="siteid" value="<?=$siteid?>"  />
    <label>ค้นหา:<input  onkeyup="searchschool()" type="text" name="txtsearch"  value="<?=$queryString?>"  id="txtsearch"/></label></td>
<tr>
	<td><div id="cdisplay" ></div </td>
</tr>
<tr>
	<td></td>
</tr>
</table>
</form>
</body></html>