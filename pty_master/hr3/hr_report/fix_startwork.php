<?php
session_start();
include ("../../../config/phpconfig.php");
include("../../../common/common_competency.inc.php");
include ("../libary/function.php");
include ("timefunc.inc.php");

if ($_SERVER[REQUEST_METHOD] == "POST"){
if($Act_F == "EDIT"){

if($status_startwork=="")
{
echo "<script language=\"javascript\">
				alert(\"กรุณาระบุสถานะการรับราชการ\\n \");
				location.href='fix_startwork.php?id=$id&runid=$runid&action=edit';
				</script>";
				exit;	
}
else
{
	$sql_c1 = "SELECT * FROM salary WHERE id='$id' AND runid='$runid'";
	$result_c1 = mysql_db_query($dbname,$sql_c1);
	$rs_c1 = mysql_fetch_assoc($result_c1);
	
	$SQLCHECK="SELECT count(salary.runid)as A  FROM salary where id='$id' and status_startwork='in' ";
	$SQLCHECK2="SELECT count(salary.runid)as B  FROM salary where id='$id' and status_startwork='out' ";
	$QUERY_CHECK=mysql_db_query($dbname,$SQLCHECK)or die (mysql_error());
	$QUERY_CHECK2=mysql_db_query($dbname,$SQLCHECK2)or die (mysql_error());
	$rs=mysql_fetch_assoc($QUERY_CHECK);
	$rs1=mysql_fetch_assoc($QUERY_CHECK2);
	
	###  ตรวจสอบกรณีเลือกออกจากราชการ
	if($status_startwork == "out"){
		$next_runno = $rs_c1[runno]+1;
		$prev_runno = $rs_c1[runno]-1;
		
		$sqlc4 = "SELECT COUNT(id) as num4 FROM salary WHERE id='$id' AND runno > '$rs_c1[runno]' AND status_startwork='in'";	
		$resultc4 = mysql_db_query($dbname,$sqlc4);
		$rsc4 = mysql_fetch_assoc($resultc4);
		
		
		$sql_c2 = "SELECT COUNT(id) as num2 FROM salary WHERE id='$id' and runno='$next_runno' and status_startwork='out' ";
		$sql_c2_1  = "SELECT COUNT(id) as num2_1 FROM salary WHERE id='$id' and runno='$prev_runno' and status_startwork='out'";
		$result_c2_1 = mysql_db_query($dbname,$sql_c2_1);
		$rs_c2_1 = mysql_fetch_assoc($result_c2_1);
		$result_c2 = mysql_db_query($dbname,$sql_c2);
		$rs_c2 = mysql_fetch_assoc($result_c2);
			if($rs_c2[num2] > 0 or $rs_c2_1[num2_1] > 0){ // กรณีเลือกเป็นออกจากราชการแล้วบรรทัดถัดไปเป็น ออกจากราชการไม่สามารถบันทึกได้
				echo "<script language=\"javascript\">
				alert(\"ระบุข้อมูลไม่ถูกต้อง โปรดระบุการออกจากราชการใหม่\\n \");
				location.href='fix_startwork.php?id=$id&runid=$runid&action=edit';
				</script>";
					exit;	
			}//end if($rs_c2[num2] > 0){
			if($rsc4[num4] > 0){
				echo "<script language=\"javascript\">
				alert(\"ระบุข้อมูลไม่ถูกต้อง โปรดระบุการออกจากราชการใหม่\\n \");
				location.href='fix_startwork.php?id=$id&runid=$runid&action=edit';
				</script>";
				exit;	

			}
		
	} //end if($status_startwork == "out"){
//	
	if($status_startwork == "in"){
		$next_runno = $rs_c1[runno]+1;
		$prev_runno = $rs_c1[runno]-1;

		$sql_c3 = "SELECT COUNT(id) as num3 FROM salary WHERE id='$id' and status_startwork is not null and status_startwork <> ''";
		$result_c3 = mysql_db_query($dbname,$sql_c3);
		$rs_c3 = mysql_fetch_assoc($result_c3);
			if($rs_c3[num3] > 0){
					$temp_check = $rs_c3[num3]%2;
					
					if($temp_check == 0){
					echo "<script language=\"javascript\">
				alert(\"ระบุข้อมูลไม่ถูกต้อง โปรดระบุการออกจากราชการก่อน\\n \");
				location.href='fix_startwork.php?id=$id&runid=$runid&action=edit';
				</script>";
					exit;	
					}
			}
			
		###  ตรวจสอบกรณีเลือกเข้าก่อนออก
		$sqlc4 = "SELECT COUNT(id) as num4 FROM salary WHERE id='$id' AND runno < '$rs_c1[runno]' AND status_startwork='out'";	
		$resultc4 = mysql_db_query($dbname,$sqlc4);
		$rsc4 = mysql_fetch_assoc($resultc4);
		
		
		$sql_c4_1 = "SELECT COUNT(id) as num4_1 FROM salary WHERE id='$id' AND runno > '$rs_c1[runno]' AND status_startwork='in'";
		//echo $sql_c4_1;die;
		$result_c4_1 = mysql_db_query($dbname,$sql_c4_1);
		$rs_c4_1 = mysql_fetch_assoc($result_c4_1);
		
		$numx1 = mysql_fetch_assoc(mysql_db_query($dbname,"SELECT COUNT(id) as num2 FROM salary WHERE id='$id' and runno='$next_runno' and status_startwork='in' "));
		$numx2 = mysql_fetch_assoc(mysql_db_query($dbname,"SELECT COUNT(id) as num2_1 FROM salary WHERE id='$id' and runno='$prev_runno' and status_startwork='in'"));
		//echo "($rsc4[num4] ) or ($rsc4[num4]  and $rs_c4_1[num4_1] )";die;
		
		if(($rsc4[num4] < 1)){
				echo "<script language=\"javascript\">
				alert(\"ระบุข้อมูลไม่ถูกต้อง กรุณาตรวจสอบอีกครั้ง\\n \");
				location.href='fix_startwork.php?id=$id&runid=$runid&action=edit';
				</script>";
					exit;	

		}
		//echo "$numx1[num2]  $numx2[num2_1]";die;
		if($numx1[num2] > 0 or $numx2[num2_1] > 0){
							echo "<script language=\"javascript\">
				alert(\"ระบุข้อมูลไม่ถูกต้อง กรุณาตรวจสอบอีกครั้ง\\n \");
				location.href='fix_startwork.php?id=$id&runid=$runid&action=edit';
				</script>";
					exit;	

		}
		
	}// if($status_startwork == "in"){
	###  ตรวจสอบกรณีเลือกออกจากราชการ
	//echo $status_startwork;die;
	
	
	 if(((($rs1[B]-$rs[A])==1) and ($rs1[B]>$rs[A]) )and ($status_startwork =="out")){
	 	echo "<script language=\"javascript\">
				alert(\"ระบุข้อมูลไม่ถูกต้อง โปรดระบุกลับเข้ารับราชการใหม่\\n \");
				location.href='fix_startwork.php?id=$id&runid=$runid&action=edit';
				</script>";
					exit;	
	 }else if(($rs[A]==$rs1[B] ) ){
		if($status_startwork=="in"){
	echo "<script language=\"javascript\">
				alert(\"ระบุข้อมูลไม่ถูกต้อง โปรดระบุออกจากราชการก่อน\\n \");
				location.href='fix_startwork.php?id=$id&runid=$runid&action=edit';
				</script>";
					exit;	
		}else{//if($status_startwork !="")
	
	$SQLUPSA="UPDATE salary SET status_startwork='$status_startwork' where id='$id' and runid='$runid' ";
	
	$returnid = add_monitor_logbefore("salary","  id ='$id' and runid ='$runid'  ");
	$result=mysql_db_query($dbname,$SQLUPSA)or die (mysql_error());
	add_monitor_logafter("salary"," id ='$id' and runid ='$runid' ",$returnid);
	
	echo "<script language=\"javascript\">
				alert(\"บันทึกข้อมูลเรียบร้อยแล้ว\\n \");
				</script>";
	echo "  <script language=\"JavaScript\"> opener.document.location.reload();  </script> ";	
	echo "<script language=\"javascript\">window.close();</script>";	
	exit;	
	}
	}else{// END else if(($rs[A]==$rs1[B] ) )

	$SQLUPSA="UPDATE salary SET status_startwork='$status_startwork' where id='$id' and runid='$runid' ";
	$returnid = add_monitor_logbefore("salary","  id ='$id' and runid ='$runid'  ");
	$result=mysql_db_query($dbname,$SQLUPSA)or die (mysql_error());
	add_monitor_logafter("salary"," id ='$id' and runid ='$runid' ",$returnid);
	
	if($result)
	{
	echo "<script language=\"javascript\">
				alert(\"บันทึกข้อมูลเรียบร้อยแล้ว\\n \");
				</script>";
	echo "  <script language=\"JavaScript\"> opener.document.location.reload();  </script> ";	
	echo "<script language=\"javascript\">window.close();</script>";	
	exit;	
	}
	else
	{
	
		echo "<script language=\"javascript\">
				alert(\"ผิดพลาดไม่สามารถบันทึกข้อมูลได้กรุณาบันทึกใหม่\\n \");
				</script>";
		echo "<script language=\"javascript\">window.close();</script>";	
		exit;	
	}
}	//echo $SQLUPSA."$dbname"
}

}// end Act_F == EDIT

if($Act_F == "DEL_OUT"){
	if($out_data == "out"){
	$status_null = "";
		$strSQL  = "UPDATE salary SET status_startwork='$status_null' where id='$id' and runid='$runid'";
			$returnid = add_monitor_logbefore("salary","  id ='$id' and runid ='$runid'  ");
		$Result=mysql_db_query($dbname,$strSQL)or die (mysql_error());
		add_monitor_logafter("salary"," id ='$id' and runid ='$runid' ",$returnid);
	if($Result)
	{
	echo "<script language=\"javascript\">
				alert(\"บันทึกข้อมูลเรียบร้อยแล้ว\\n \");
				</script>";
	echo "  <script language=\"JavaScript\"> opener.document.location.reload();  </script> ";	
	echo "<script language=\"javascript\">window.close();</script>";	
	exit;	
	}

	}
}


}
?>
		
<html>
<head>
<title>ข้อมูลข้าราชการ</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<script language="javascript" src="js/daily_popcalendar.js"></script>
<script language="javascript" src="js/displayelement.js"></script>
<link href="hr.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
.style3 {color: #999999}
.style4 {
	color: #666666;
	font-weight: bold;
}
-->
</style>
<script language="javascript">
/*var xmlHttp;
function createXMLHttpRequest() {
    if (window.ActiveXObject) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    } 
    else if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    }
}


function setdbkp7() {
				var item1 = getCheckedValue(set_kp7);
				var url = "ajax_setkp7_historyname.php?runid=" + item1;
				createXMLHttpRequest();
				xmlHttp.open("GET", url, true);
				xmlHttp.send(null);
}

function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}*/

function check(){
if(document.form1.status_startwork.checked == false)
{
alert("cccccc");
}
}	
</script>
</head>
<body >

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" background="bimg/bg1.gif" style="background-repeat: no-repeat; background-position:right bottom "><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="60" bgcolor="#2C2C9E">
	<? if($action == "edti" or $action == "DEL_OUT"){?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="15%"><div align="center"><img src="bimg/hr.gif" width="64" height="64" /></div></td>
              <td width="85%"><B class="pheader">
                ุกลับเข้ารับราชการ(เฉพาะที่เคยออกจากราชการ)</B></td>
            </tr>
        </table>
	<? }?>
		</td>
      </tr>
      
    </table>
<?
if($action == "edit"){
?>
<form name="form1" method="post" action="fix_startwork.php" onSubmit="return check();">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="runid" value="<?=$runid?>">
<? $SQL="SELECT * FROM salary where id='$id' and runid='$runid' ";
	$quey_sql=mysql_db_query($dbname,$SQL)or die (mysql_error());
	$rs=mysql_fetch_assoc($quey_sql);
?>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" style="border:1px #5595CC solid;padding:2px;">
    
    <tr>
      <td colspan="2" align="center" bgcolor="#CCCCCC"style="border:1px #5595CC solid;padding:2px;"><span class="style4">สถานะทางราชการ</span></td>
      </tr>
    <tr>
      <td width="49%"  align="right"><input type="radio" name="status_startwork" id="status_startwork" value="out" <? if($rs[status_startwork]=="out"){echo "checked";}?>></td>
      <td width="51%" >ออกจากราชการ</td>
      </tr>
    <tr>
      <td align="right"><input type="radio" name="status_startwork"  id="status_startwork1"value="in" <? if($rs[status_startwork]=="in"){echo "checked";}?>></td>
      <td>เข้ารับราชการใหม่</td>
    </tr>
    <tr>
      <td colspan="2" align="center" style="border-top: 1px dashed #FF0000;
" >
			<input type="hidden" name="Act_F" value="EDIT">
			<input name="add" type="submit" id="add" value="บันทึก">
        &nbsp;
         <input name="cancle" type="submit" id="cancle" value="ยกเลิก" onClick="window.close();"></td>
      </tr>
  </table>
</form> 
<?
}
if($action == "DEL_OUT"){
?>
<form name="form1" method="post" action="fix_startwork.php" onSubmit="return check();">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="runid" value="<?=$runid?>">
<? $SQL="SELECT * FROM salary where id='$id' and runid='$runid' ";
	$quey_sql=mysql_db_query($dbname,$SQL)or die (mysql_error());
	$rs=mysql_fetch_assoc($quey_sql);
?>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" style="border:1px #5595CC solid;padding:2px;">
    
    <tr>
      <td colspan="2" align="center" bgcolor="#CCCCCC"style="border:1px #5595CC solid;padding:2px;"><span class="style4">สถานะทางราชการ</span></td>
      </tr>
    <tr>
      <td width="50%"  align="right"><input name="out_data" type="radio" id="out_data"  value="out" checked></td>
      <td width="50%" >ยกเลิกข้อมูล</td>
      </tr>
    <tr>
      <td colspan="2" align="center" style="border-top: 1px dashed #FF0000;
" >
<input type="hidden" name="Act_F" value="DEL_OUT">
<input name="add" type="submit" id="add" value="บันทึก">
        &nbsp;
         <input name="cancle" type="submit" id="cancle" value="ยกเลิก" onClick="window.close();"></td>
      </tr>
  </table>
</form> 


<?
} if($action == "edit" or $action == "DEL_OUT"){
?>

<table width="100%" border="0" cellpadding="4" cellspacing="0">
   <tr>
     <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style3">กรุณาระบุสถานะการเข้ารับราชการใหม่หรือออกจากราชการ โดยข้อมูลในส่วนนี้ใช้ในการคำนวนอายุราชการของท่าน ท่านที่เคยออกจากราชการและกลับเข้ารับราชการใหม่ กรุณาระบุข้อมูลในวันที่ที่ท่านได้ออกจากราชการและกลับเข้ารับราชการใหม่ </span></td>
     </tr>
 </table>
 <?
 }
 ?>
 <p>&nbsp;</p>
 <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td colspan="2" align="center"></td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
