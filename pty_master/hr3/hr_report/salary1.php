<?php

#START
###### This Program is copyright Sapphire Research and Development co.,ltd ########
#########################################################
$ApplicationName	= "competency_salary";
$module_code 		= "salary"; 
$process_id			= "salary";
$VERSION 				= "9.1";
$BypassAPP 			= true;
#########################################################
#Developer::
#DateCreate::17/07/2007
#LastUpdate::17/07/2007
#DatabaseTabel::
#END
#########################################################
session_start();
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
include("../../../config/phpconfig.php");
include("inc/libary.php");


// =====Constant ===============

/*
echo "<pre>";
print_r($namevit);
echo "</pre>";
*/
//===========================

$time_start = getmicrotime();
if ($_SERVER[REQUEST_METHOD] == "POST"){
$salary_st=str_replace(',',"",$salary);
add_log("ข้อมูลเงินเดือน",$id,$action);
$pls			= trim($pls);
$pls			= wordwrap($pls, 65, "\n", true);

if($action=="edit1")
{
	$dateorder	= ($checkdateorder == 0) ? "" : $dateorder_year.'-'.$dateorder_month.'-'.$dateorder_day ;
	$date 		= ($checkdate == 0) ? "" :$salary_year.'-'.$salary_month.'-'.$salary_day;
}
else if($action=="edit2")
{
	if($checkdate == 0){$date 		= "";}
	else if($checkdate == 1 ){$date  =$salary_year.'-'.$salary_month.'-'.$salary_day;}
	else if($checkdate == 2){$date=$olddate;}
	
	if($checkdateorder==0){$dateorder="";}
	else if($checkdateorder==1){$dateorder=$dateorder_year.'-'.$dateorder_month.'-'.$dateorder_day ;}
	else if($checkdateorder==2){$dateorder=$olddateorder;}
}

$comedate=$comeyear."-".$comemonth."-".$comeday;
if($action == "changeRow"){
	for($i=0;$i<count($runno);$i++){
		$sql		= " update salary set runno='".$runno[$i]."' where id='".$id."' and runid='".$runid[$i]."' ";		
		$result 	= mysql_query($sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	}
	//header("Location: ?id=$id");
	
	echo"<meta http-equiv='refresh' content='0;URL=salary.php?action=edit&viewall=1'>";
	exit;
}


  	$result 		= mysql_query(" select max(runno) as runno from salary where id='$id'; ")or die("Query line ". __LINE__ ." error<hr>".mysql_error());
  	$rs			= mysql_fetch_assoc($result);
  	$runno		= ($rs[runno] <= 0) ? 1 : ($rs[runno] + 1);
	mysql_free_result($result);
	unset($rs);

if($_POST[action]=="edit2"){
	if($instruct=="other")
	{
	$instruct=$instruct1;
	}
	else
	{
		$instruct=$instruct;
	}
$resultx1 = mysql_query(" SELECT  remark  FROM  vitaya_stat  WHERE    id ='$id'  AND  remark = '$noorder_old' ");
	$rr1=mysql_fetch_assoc($resultx1);
	$numrr1=mysql_num_rows($resultx1);
	if (($numrr1 !=0) 	and ($noorder_old == $rr1[remark])){
			$sql_update1 =  "UPDATE vitaya_stat  SET remark='$noorder' WHERE   id ='$id'  AND  remark='$noorder_old'" ;	
			//echo "$sql_update";
		mysql_query($sql_update1) or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	} 
	$resultx = mysql_query(" SELECT  remark  FROM  vitaya_stat  WHERE    id ='$id'  AND  remark = '$noorder' ");
	$rr=mysql_fetch_assoc($resultx);
	$numrr=mysql_num_rows($resultx);
	//อ่านเพื่อนำมาเช็คค่าว่ามีวิทยฐานะซ้ำกันหรือไม่
	$sql_name=mysql_query("select * from vitaya_stat WHERE id='$id' and name='$vitaya' ");
	$arn=mysql_fetch_assoc($sql_name);
	$numname=mysql_num_rows($sql_name);
	if($numname==0 and $numrr !=0) //ไม่ซ้ำกัน___________________________________________//......
		{
		if($vitaya !="")
		{
		//echo "แก้ไขได้เลยเพิ่มข้อมูลได้อ่ะครับ";
		$sql_update =  "UPDATE vitaya_stat  SET  date_start = '$date', date_command = '$dateorder' , name = '$vitaya',remark='$noorder' WHERE   id ='$id'  AND  remark='$rr[remark]'" ;
		mysql_query($sql_update) or die("Query line ". __LINE__ ." error<hr>".mysql_error());
			}
		else
		{
			$delete="DELETE  FROM  vitaya_stat where id='$id' and remark='$rr[remark]' ";
			mysql_query($delete)or die(mysql_error());
		}
					echo"
				<script language=\"javascript\">
				alert(\"ปรับปรุงข้อมูลวิทยฐานะเรียบร้อย\\n \");
				</script>";
		}
		else if($numname==0 and $numrr==0 and $vitaya !="")//มีคำสังนี้อยู่หรือไม่ ----------------------------------------//////
		{
			$sql_insert =  " insert  INTO  vitaya_stat  (id,name,date_command,date_start,remark)";
			 $sql_insert.="VALUES('$id','$vitaya','$dateorder','$date','$noorder')  " ;
			//echo "============".$sql_insert."<hr>";
			
		echo"
				<script language=\"javascript\">
				alert(\"ปรับปรุงข้อมูลวิทยฐานะเรียบร้อย\\n \");
				</script>";
		$rrr=mysql_query($sql_insert);
		}
	if($numname==1)
		{
			if($arn[remark]==$noorder)//เช็คว่า ค่าหมายเลขคำสั่ง ในตัวที่มีในฐานข้อมูลตรงกับ ตัวที่แก้ไขหรือไม่
			{}
			else
			{
			//echo "fdsfklds;fjdslf";
				$rtr="วิทยฐานะ $vitaya ไม่ถูกบันทึก เนื่องจากวิทยฐานะดังกล่าว มีอยู่แล้วในคำสั่งที่ $arn[remark]";
					echo"
				<script language=\"javascript\">
				alert(\"$rtr\\n \");
				</script>";
			}
			
		}

		$sql 	= " update  salary set  `date`='$date', `position`='$hr_addposition' , noposition = '$noposition', radub = '$hr_addradub', salary ='$salary_st', ";
	$sql	.= " `upgrade` = '$upgrade'  , note ='$note' ,noorder = '$noorder',pls = '$pls' , ch_position = '$ch_position' ,ch_salary = '$ch_salary', ";
	$sql	.= " ch_radub='$ch_radub', dateorder = '$dateorder', pos_name='$pos_name',instruct='$instruct',label_date='$label_date',label_salary='$label_salary',label_dateorder='$label_dateorder',label_radub='$label_radub' where id ='$id' and runid ='$runid' ;";	
	//echo $sql."update";
	mysql_query($sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
echo"
				<script language=\"javascript\">
				alert(\"ข้อมูลตำแหน่ง ระดับ และอัตราเงินเดือน บันทึกเรียบร้อย\\n \");
				</script>
			<meta http-equiv='refresh' content='0;URL=salary.php?action=edit&YY=$YY&viewall=$v'>";
	exit;

} else {
	add_log("ข้อมูลเงินเดือน",$id,$new);
	if($instruct=="other")
	{
	$instruct=$instruct1;
	}
	else
	{
		$instruct=$instruct;
	}
	$sql 	= "INSERT INTO salary (id, `date`, `position`, noposition, radub, salary, `upgrade`, note, noorder, ch_position, ch_radub, ch_salary, pls, dateorder, ";
	$sql	.= " pos_name, runno,instruct,label_date,label_salary,label_dateorder,label_radub) VALUES ('$id', '$date', '$hr_addposition', '$noposition', '$hr_addradub', '$salary_st', '$upgrade', '$note', '$noorder', ";
	$sql	.= " '$ch_position', '$ch_radub','$ch_salary','$pls','$dateorder','$pos_name','$runno','$instruct','$label_date','$label_salary','$label_dateorder','$label_radub') ";			
//echo $sql."<hr>";
	mysql_query($sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	// ======= INPUT  VITAYATHANA===========
	
	$sqlvitaya="select * from vitaya_stat where id='$id' and name='$vitaya' ";
	//echo $sqlvitaya;
	$qvitaya=mysql_query($sqlvitaya)or die (mysql_error());
	$rsv=mysql_fetch_assoc($qvitaya);
	$numvitaya=mysql_num_rows($qvitaya);
	if($numvitaya >0)
	{
				$sql_insert =  " insert  INTO  vitaya_stat  (id,name,date_command,date_start,remark)";
			 $sql_insert.="VALUES('$id','$vitaya','$dateorder','$date','$noorder')  " ;
		//$sql_insert =  " insert  INTO  vitaya_stat  VALUES('$id','$vitaya','$date','$dateorder','$noorder')  " ;
//echo "hjlkjh;l".$sql_insert."=========";
		$msger=mysql_query($sql_insert);
	$mssg="วิทยฐานะ $vitaya ไม่ถูกบันทึก เนื่องจากวิทยฐานะดังกล่าว มีอยู่แล้วในคำสั่งที่ $rsv[remark]";
					echo"
				<script language=\"javascript\">
				alert(\"$mssg\\n \");
				</script>
			<meta http-equiv='refresh' content='0;URL=salary.php?action=edit&YY=$YY&viewall=$v'>";
		
	}
	else if($numvitaya==0 and $vitaya !="")
	{
				$sql_insert =  " insert  INTO  vitaya_stat  (id,name,date_command,date_start,remark)";
			 $sql_insert.="VALUES('$id','$vitaya','$dateorder','$date','$noorder')  " ;
	//$sql_insert =  "INSERT  INTO  vitaya_stat  VALUES('$id','$vitaya','$date','$dateorder','$noorder' )" ;
	//echo $sql_insert."lkg;dsajf;lkdsjfdsl" ;
	$msger=mysql_query($sql_insert);
		echo"
				<script language=\"javascript\">
				alert(\"ข้อมูลวิทยฐานะบันทึกเรียบร้อย\\n \");
				</script>";
	}
				echo"
				<script language=\"javascript\">
				alert(\"ข้อมูลส่วนตำแหน่ง ระดับ และอัตราเงินเดือนบันทึกเรียบร้อย\\n \");
				</script>
			<meta http-equiv='refresh' content='0;URL=salary.php?action=edit&YY=$YY&viewall=$v'>";
	//+++++++++++++++++++++++++++++++
	/*
		echo " 
				<script language=\"javascript\">
				alert(\"ทำการบันทึกข้อมูลเสร็จสิ้น\\n \");
				location.href='?id=$id&action=edit#keys';
				</script>
				";
	//header("Location: ?id=$id&action=edit#keys");*/
	exit;
				
}
				

} elseif($_GET[action] == 'delete') {

	add_log("ข้อมูลเงินเดือน",$id,$action);
	mysql_query("delete from salary where id = $id and runid='$runid';")or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	mysql_query("delete from vitaya_stat where id = $id and remark='$rem'")or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	//header("Location: ?id=$id&action=edit");
	echo"<meta http-equiv='refresh' content='0;URL=salary.php?action=edit&viewall=$v&YY=$YY'>";
	exit;
	
} else {		
	
	$sql 		= "select * from  general where id='$id'  ;";
	$result 	= mysql_query($sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	$rs		= mysql_fetch_array($result,MYSQL_ASSOC);

	$sqlx 		= "select * from  vitaya_stat  where id='$id' AND date_start = '$date'  ;";
	$resultx 	= mysql_query($sqlx)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	$rsx		= mysql_fetch_array($resultx,MYSQL_ASSOC);

}
?>

<html>
<head>
<TITLE>application list</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">

<link href="libary/tab_style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="libary/tabber.js"></script>
<link href="hr.css" type="text/css" rel="stylesheet">
<style type="text/css">
body {  
	margin				: 0px  0px; 
	padding				: 0px  0px;
}

a:link { 
	color					: #005CA2; 
	text-decoration	: none;
}

a:visited { 
	color					: #005CA2; 
	text-decoration	: none;
}

a:active { 
	color					: #0099FF; 
	text-decoration	: underline
}

a:hover { 
	color					: #0099FF; 
	text-decoration	: underline;
}

.style1 {
	color					: #FFFFFF;
	font-weight		: bold;
}

.style2 {color: #FF0000}
.style3 {color: #000000}
.style5 {color: #000000; font-weight: bold; }
.style8 {color: #880000}
.style10 {color: #8C0000}
</style>
<!-- send id to menu flash -->
<script type="text/javascript">
document.write('<style type="text/css">.tabber{display:none;}<\/style>');
</script>
<script language="javascript">

function ylib_Browser()
{
	d				= document;
	this.agt		= navigator.userAgent.toLowerCase();
	this.major	= parseInt(navigator.appVersion);
	this.dom	= (d.getElementById)?1:0;
	this.ns		= (d.layers);
	this.ns4up	= (this.ns && this.major >=4);
	this.ns6	= (this.dom&&navigator.appName=="Netscape");
	this.op 		= (window.opera? 1:0);
	this.ie		= (d.all);
	this.ie4		= (d.all&&!this.dom)?1:0;
	this.ie4up	= (this.ie && this.major >= 4);
	this.ie5		= (d.all&&this.dom);
	this.win	= ((this.agt.indexOf("win")!=-1) || (this.agt.indexOf("16bit")!=-1));
	this.mac	= (this.agt.indexOf("mac")!=-1);
};

var oBw = new ylib_Browser();

function DisplayElement ( elt, displayValue ) {
	if ( typeof elt == "string" )
		elt = document.getElementById( elt );
	if ( elt == null ) return;
	if ( oBw && oBw.ns6 ) {
		// OTW table formatting will be lost:
		if ( displayValue == "block" && elt.tagName == "TR" )
			displayValue = "table-row";
		else if ( displayValue == "inline" && elt.tagName == "TR" )
			displayValue = "table-cell";
	}

	elt.style.display = displayValue;
}

function insert_bline(id, siteid)
{
	var url			= "bline_popup.php?kid=" + id + "&siteid=" + siteid;
	var newwin 	= window.open(url,'popup','location=0,status=no,scrollbars=no,resizable=no,width=500,height=370,top=200');
	newwin.focus();
} 

/*function disableInput(sta){
if(sta == 1){
	document.getElementById("t1").disabled=false;	
	document.getElementById("t2").disabled=false;
	document.getElementById("t3").disabled=false;
	document.getElementById("t4").disabled=false;
	document.getElementById("t5").disabled=false;
} else {
	document.getElementById("t1").disabled=true;	
	document.getElementById("t2").disabled=true;
	document.getElementById("t3").disabled=true;
	document.getElementById("t4").disabled=true;
	document.getElementById("t5").disabled=true;
}}*/

function popWindow(url, w, h){

	var popup		= "Popup"; 
	if(w == "") 	w = 420;
	if(h == "") 	h = 300;
	var newwin 	= window.open(url, popup,'location=0,status=no,scrollbars=yes,resizable=no,width=' + w + ',height=' + h + ',top=20');
	newwin.focus();

}

function onSelect(val, divid){
	if(val == 0){
 		document.getElementById(divid).style.display	= 'none';  
	} else {
		document.getElementById(divid).style.display	= 'block';  
	}
} 
function onSelect1(val, divid){
	if(val == 0){
 		document.getElementById(divid).style.display	= 'none';  
	} else {
		document.getElementById(divid).style.display	= 'block';  
	}
} 

function check(){
var ddd = document.getElementById("checkdate1");
var ddd2 = document.getElementById("checkdate2");
//alert(ddd.value);
 if (document.post.checkdate2.checked==true  && document.post.salary_day.value =="" &&  document.post.salary_month.value =="" && document.post.salary_year.value =="")
{
 alert("กรุณาระบุวันที่(วัน เดือน ปี)");
 return false;
 }
 
else if(document.post.noorder.value.length == 0)
	{
		alert("ระบุหมายเลขคำสั่ง");
		document.post.noorder.focus();
		return false;
	} 
else if(document.post.label_salary.value !="" && document.post.salary.value ==0 )
	{
		alert("ระบุอัตราเงินเดือนในช่อง เงินเดือนเพื่อเก็บเป็นข้อมูลสถิติ");
		return false;
	}
 if (document.post.checkdateorder2.checked==true  && document.post.dateorder_day.value =="" &&  document.post.dateorder_month.value =="" && document.post.dateorder_year.value =="")
{
 alert("กรุณาระบุวันที่(เอกสารอ้างอิง)");
 return false;
 }


}



function bbb()
{
	document.post.salary_day.disabled=false;
	document.post.salary_month.disabled=false;
	document.post.salary_year.disabled=false;
	document.post.label_date.disabled=false;
}
function clearselect()
{
	document.post.salary_day.disabled=true;
	document.post.salary_month.disabled=true;
	document.post.salary_year.disabled=true;
	document.post.label_date.disabled=true;
	
	 if (document.post.salary_day.value!="")
 	{
       document.post.salary_day.value="";
	   document.post.salary_day.disabled=true;
    }
	 if (document.post.salary_month.value!="")
 	{
       document.post.salary_month.value="";
	   document.post.salary_month.disabled=true;
    }
	
	 if (document.post.salary_year.value!="")
 	{
       document.post.salary_year.value="";
	   document.post.salary_year.disabled=true;
    }
	 if (document.post.label_date.value!="")
 	{
       document.post.label_date.value="";
	   document.post.label_date.disabled=true;
    }
}
function opendisable()
{
	document.post.dateorder_day.disabled=false;
	document.post.dateorder_month.disabled=false;
	document.post.dateorder_year.disabled=false;
	document.post.label_dateorder.disabled=false;
}
function disbb()
{
	document.post.dateorder_day.disabled=true;
	document.post.dateorder_month.disabled=true;
	document.post.dateorder_year.disabled=true;
	document.post.label_dateorder.disabled=true;
	
	 if (document.post.dateorder_day.value!="")
 	{
       document.post.dateorder_day.value="";
	   document.post.dateorder_day.disabled=true;
    }
	 if (document.post.dateorder_month.value!="")
 	{
       document.post.dateorder_month.value="";
	   document.post.dateorder_month.disabled=true;
    }
	
	 if (document.post.dateorder_year.value!="")
 	{
       document.post.dateorder_year.value="";
	   document.post.dateorder_year.disabled=true;
    }
	 if (document.post.label_dateorder.value!="")
 	{
       document.post.label_dateorder.value="";
	   document.post.label_dateorder.disabled=true;
    }
}

function check_radio(){
		document.post.vitaya_sts[1].checked = true;
}
function aaa()
{
document.post.instruct1.disabled=false;
}
 function doClear(instruct1) 
{
	document.post.instruct1.disabled=true;
     if (document.post.instruct1.value!="")
 	{
       document.post.instruct1.value="";
	   document.post.instruct1.disabled=true;
    }
}

function check_sum1(){
	var f1 = document.post;	
	a =  Number(f1.salary.value) ;
	if( a > 80000  ){
		alert(' กรุณาตรวจสอบข้อมูลเงินเดือนที่ท่านกรอก \n เนื่องตัวเลขอาจมากกว่าความเป็นจริง ');
	}
}

</script>
</head>
<body bgcolor="#A3B2CC" <?=$onload?>>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr valign="top"> 
	<td><table width="98%" border="0" cellspacing="0" cellpadding="2" align="center">
	  
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="30">		<? if($action=="edit" and $viewall==5)
		{?><table width="98%"  align="left">

            <tr>
              <td width="21%" height="21"><a href="salary.php?id=<?=$rs[id]?>&action=edit&viewall=0" title="แก้ไขข้อมูลเงินเดือน" class="style3"><img src="images/edit.png" width="16" height="16" align="absmiddle" border=""><span class="style3">เพิ่ม/ลบ/แก้ไข ข้อมูล</span></a> </td>
              <td width="41%"><a href="kp7_salary.php?id=<?=$id?>" class="style3"><img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" alt="ตรวจสอบข้อมูล กพ.7"><span class="style3">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์</span></a></td>
              <td width="38%">&nbsp;</td>
            </tr>
        </table>
        <? }else{?>
		<table width="98%"  align="left">
		 <tr>
              <td width="41%" height="21"><a href="kp7_salary.php?id=<?=$id?>"><img src="../../../images_sys/pdf.gif" width="16" height="16" border="0" alt="ตรวจสอบข้อมูล กพ.7"><span class="style3">ตรวจสอบเอกสารข้อมูล ก.พ.7 อิเล็กทรอนิกส์ </span></a></td>
              <td width="21%">&nbsp;</td>
            </tr>
        </table><? }?>		</td>
        </tr>
    </table>      
      <span class="style5"><a href="salary.php?id=<?=$rs[id]?>&action=edit&viewall=0" title="แก้ไขข้อมูลเงินเดือน" class="style3">&nbsp;</a>ชื่อ / สกุล &nbsp;<u>
      <?=$rs[prename_th]." ".$rs[name_th]." ".$rs[surname_th]?>
      </u>


    
      &nbsp;</span><br>
      <br>
      <span class="style3"><strong><a href="salary.php?id=<?=$rs[id]?>&action=edit&viewall=0" title="แก้ไขข้อมูลเงินเดือน" class="style3">&nbsp;</a>๑๓ . ตำแหน่งและอัตราเงินเดือน	  </strong></span></td>
  </tr>

  </table>
      
      <br>
      <?
if($action=="edit")
{
 if($viewall==5)
{
$i 			= 0;
$result 	= mysql_query("select * from salary where id='$id' order by runno asc;")or die("Query line ". __LINE__ ." error<hr>".mysql_error());
$row		= mysql_num_rows($result);
?>
<table width="98%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="black">
  
  <tr bgcolor="#A3B2CC" align="center" style="font-weight:bold;">
    <td width="10%"><strong>วัน เดือน ปี</strong></td>
	  <td width="40%"><strong>ตำแหน่ง</strong></td>
	  <td width="8%"><strong>เลขที่<br>
	    ตำแหน่ง</strong></td>
	  <td width="8%"><strong>ระดับ</strong></td>
	  <td width="7%"><strong>อัตรา<br>
	    เงินเดือน</strong></td>
	  <td width="27%">เอกสารอ้างอิง</td>
	  </tr>
  
  <?
while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
	$i++;
if ($i % 2) {
	$bg = "#EFEFEF";
}else{
	$bg = "#DDDDDD";
}

if($rs[instruct]=="#")
{
	$rinstruct="";
}
else
{
$rinstruct=$rs[instruct];
}
if($rs[label_salary] !="")
{
	$salary=$rs[label_salary];
}
else
{
	if($rs[salary]==0)
	{
	$salary="";
	}
	else
	{
	$salary=number_format($rs[salary]);
	}
}
if($rs[noorder]=="#")
{
	$noo="";
}
else
{
	$noo=$rs[noorder];
}
if($rs[label_date] !="")
{	
	$dateshow= $rs[label_date];
}
else
{
	
	$dateshowX=MakeDate2($rs[date]);
	$DX=explode(" ",$dateshowX);
	//echo "$DX[0]";
	if($DX[0]==0){$dxt="";}else{$dxt=$DX[0];}
	$dateshow=$dxt.$DX[1].$DX[2];
}
if($rs[label_dateorder] !="")
{
	$dateorder=$rs[label_dateorder];
}
else
{
	$dateorderX=MakeDate2($rs[dateorder]);
	$DO=explode(" ",$dateorderX);
	//echo "$DX[0]";
	if($DO[0]==0){$dot="";}else{$dot=$DO[0];}
	$dateorder=$dot.$DO[1].$DO[2];
	//$dateorder=MakeDate2($rs[dateorder]);
}

//__________________________________________
if($rs[label_radub] !=""){$radub=$rs[label_radub]; }
else{$radub=$rs[radub];}
?>
  <tr bgcolor="<?=$bg?>">
    <td>&nbsp;<?=$dateshow?></td>
	  <td><?=wordwrap($rs[pls], 30, "\n", true)?></td>
	  <td align="center"><?=$rs[noposition]?></td>
	  <td align="center"><?=$radub?></td>
	  <td><?=$salary?>&nbsp;</td>
	  <td align="left"><?=$noo." ".$rinstruct?>
        <input type="hidden" name="runid[]2" value="<?=$rs[runid]?>">
        <?=$dateorder?></td>
	  </tr>
  <?
	} //while
// List Template
?>
  </table>
<?

}
else if($viewall==0)
{
$result 	= mysql_query("select * from salary where id='$id'  order by date DESC limit 1;")or die("Query line ". __LINE__ ." error<hr>".mysql_error());

$rs1=mysql_fetch_array($result,MYSQL_ASSOC);
 	$d=explode("-","$rs1[date]");
 	$dleast=$d[0]-4;
	$dmore=$d[0]+1;
	$sql11="SELECT
		*
		FROM
		`salary`
		where id='$id' AND date Between '$dleast% ' AND '$dmore%'
		order by date ASC";
	
		
		$query11=mysql_query($sql11)or die(mysql_error());
		$row	= mysql_num_rows($query11);
?>
<input type="hidden" NAME="id" VALUE="<?=$id?>">
<table width="98%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="black">
  <tr bgcolor="#A3B2CC" align="center">
  <td colspan="8" bgcolor="#2C2C9E"><span class="style1">การเลื่อนขั้นตำแหน่ง(ข้อมูล 5 ปีย้่อนหลัง)</span></td>
  </tr>
  <tr bgcolor="#A3B2CC" align="center" style="font-weight:bold;">
    <td width="10%"><strong>วัน เดือน ปี</strong></td>
	  <td width="35%"><strong>ตำแหน่ง</strong></td>
	  <td width="7%"><strong>เลขที่<br>
	    ตำแหน่ง</strong></td>
	  <td width="5%"><strong>ระดับ</strong></td>
	  <td width="8%"><strong>อัตรา<br>
	    เงินเดือน</strong></td>
	  <td width="25%"><strong>เอกสารอ้างอิง</strong></td>
	  <td width="10%"><input type="button" name="add" value="เพิ่มข้อมูล" onClick="location.href='salary.php?id=<?=$id?>&v=0&action=edit1' "></td>    
  </tr>
  
  <?
while ($rs=mysql_fetch_array($query11,MYSQL_ASSOC)){
	$i++;
if ($i % 2) {
	$bg = "#EFEFEF";
}else{
	$bg = "#DDDDDD";
}
if($rs[instruct]=="#")
{
	$rinstruct="";
}

else
{
$rinstruct=$rs[instruct];
}
if($rs[label_salary] !="")
{
	$salary=$rs[label_salary];
}
else
{
	if($rs[salary]==0)
	{
	$salary="";
	}
	else
	{
	$salary=number_format($rs[salary]);
	}
}
if($rs[noorder]=="#")
{
	$noo="";
}
else
{
	$noo=$rs[noorder];
}
if($rs[label_date] !="")
{
	$dateshow= $rs[label_date];
}
else
{
		$dateshowX=MakeDate2($rs[date]);
	$DX=explode(" ",$dateshowX);
	//echo "$DX[0]";
	if($DX[0]==0){$dxt="";}else{$dxt=$DX[0];}
	$dateshow=$dxt.$DX[1].$DX[2];
}
if($rs[label_dateorder] !="")
{
	$dateorder=$rs[label_dateorder];
}
else
{
	$dateorderX=MakeDate2($rs[dateorder]);
	$DO=explode(" ",$dateorderX);
	//echo "$DX[0]";
	if($DO[0]==0){$dot="";}else{$dot=$DO[0];}
	$dateorder=$dot.$DO[1].$DO[2];
	//$dateorder=MakeDate2($rs[dateorder]);
}

//__________________________________________
if($rs[label_radub] !=""){$radub=$rs[label_radub]; }
else{$radub=$rs[radub];}
?>
  <tr align="center" bgcolor="<?=$bg?>">
    <td align="left">&nbsp;      <?=$dateshow?></td>
	  <td align="left">&nbsp;<?=wordwrap($rs[pls], 30, "\n", true)?></td>
	  <td align="center"><?=$rs[noposition]?></td>
	  <td align="center"><?=$radub?></td>
	  <td align="center"><?=$salary?>&nbsp;</td>
	  <td align="left"><?=$noo." ".$rinstruct?>
	    <input type="hidden" name="runid[]3" value="<?=$rs[runid]?>">
	    <?=$dateorder?></td><td align="center"><a href="salary.php?id=<?=$rs[id]?>&runid=<?=$rs[runid]?>&v=0&action=edit2#keys">
	    <img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> 
	    &nbsp; <a href="#" 
	onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id=<?=$rs[id]?>&runid=<?=$rs[runid]?>&v=0&rem=<?=$rs[noorder]?>';" >
	      <img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a>	</td>    
  </tr>
  <?
	} //while
// List Template
?>
  <tr bgcolor="#dddddd" align="center">
    <td colspan="7"><input type="button" name="viewall" value="เรียงลำดับข้อมูลและแสดงผลข้อมูลทั้งหมด"  onClick="location.href='salary.php?action=edit&viewall=1' ">
    <input type="button" name="viewperiod" value="ข้อมูลรายปี" onClick="location.href='salary.php?action=edit&viewall=2&YY=<?=$d[0]?>' ">
    <input type="button" name="viewdata" value="กลับหน้าแรก" onClick="location.href='salary.php?action=edit&viewall=5' ">    </td>
  </tr>
  </table>
<?
}
else if($viewall==1)
{
$i 			= 0;
$result 	= mysql_query("select * from salary where id='$id' order by runno asc;")or die("Query line ". __LINE__ ." error<hr>".mysql_error());
$row		= mysql_num_rows($result);
?>
<?
$res 	= mysql_query("select * from salary where id='$id'  order by date DESC limit 1;")or die("Query line ". __LINE__ ." error<hr>".mysql_error());

$rr=mysql_fetch_array($res,MYSQL_ASSOC);
 	$d=explode("-","$rr[date]");
 
	$dmore=$d[0];
?>
  <form name="form1" method="post" action="<?=$PHP_SELF?>">			
  <input type="hidden" name="action" value="changeRow">
    
  <input type="hidden" NAME="id" VALUE="<?=$id?>">

  <table width="98%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="black">
  <tr bgcolor="#A3B2CC" align="center">
  <td colspan="9" bgcolor="#2C2C9E"><span class="style1">การเลื่อนขั้นตำแหน่ง(แสดงข้อมูลทั้งหมด)</span></td>
  </tr>
  <tr bgcolor="#A3B2CC" align="center" style="font-weight:bold;">
    <td width="6%">ลำดับใหม่</td>
	  <td width="10%"><strong>วัน เดือน ปี</strong></td>
	  <td width="35%"><strong>ตำแหน่ง</strong></td>
	  <td width="9%"><strong>เลขที่<br>
	    ตำแหน่ง</strong></td>
	  <td width="4%"><strong>ระดับ</strong></td>
	  <td width="7%"><strong>อัตรา<br>
	    เงินเดือน</strong></td>
	  <td width="21%"><strong>เอกสารอ้างอิง</strong></td>
	  <td width="8%"><input type="button" name="add2" value="เพิ่มข้อมูล" onClick="location.href='salary.php?id=<?=$id?>&v=1&action=edit1' "></td>    
  </tr>
  
  <?
while ($rs=mysql_fetch_array($result,MYSQL_ASSOC)){
	$i++;
if ($i % 2) {
	$bg = "#EFEFEF";
}else{
	$bg = "#DDDDDD";
}
if($rs[instruct]=="#")
{
	$rinstruct="";
}
else
{
$rinstruct=$rs[instruct];
}
if($rs[label_salary] !="")
{
	$salary=$rs[label_salary];
}
else
{
	if($rs[salary]==0)
	{
	$salary="";
	}
	else
	{
	$salary=number_format($rs[salary]);
	}
}
if($rs[noorder]=="#")
{
	$noo="";
}
else
{
	$noo=$rs[noorder];
}
if($rs[label_date] !="")
{
	$dateshow= $rs[label_date];
}
else
{
		$dateshowX=MakeDate2($rs[date]);
	$DX=explode(" ",$dateshowX);
	//echo "$DX[0]";
	if($DX[0]==0){$dxt="";}else{$dxt=$DX[0];}
	$dateshow=$dxt.$DX[1].$DX[2];
}
if($rs[label_dateorder] !="")
{
	$dateorder=$rs[label_dateorder];
}
else
{
	$dateorderX=MakeDate2($rs[dateorder]);
	$DO=explode(" ",$dateorderX);
	//echo "$DX[0]";
	if($DO[0]==0){$dot="";}else{$dot=$DO[0];}
	$dateorder=$dot.$DO[1].$DO[2];
	//$dateorder=MakeDate2($rs[dateorder]);
}
if($rs[label_radub] !=""){$radub=$rs[label_radub]; }
else{$radub=$rs[radub];}
//__________________________________________

?>
  <tr align="center" bgcolor="<?=$bg?>">
    <td align="center"><select name="runno[]">
  <?
for($e=1;$e<=$row;$e++){
	$selected = ($e == $rs[runno]) ? " selected " : "" ;
	echo "<option value=\"".$e."\" ".$selected.">".$e."</option>";
}
?>	
      </select>      </td>
	  <td align="center"><?=$dateshow?></td>
	  <td align="left">&nbsp;
	    <?=wordwrap($rs[pls], 30, "\n", true)?></td>
	  <td align="center"><?=$rs[noposition]?></td>
	  <td align="center"><?=$radub?></td>
	  <td align="center"><?=$salary?>&nbsp;</td>
	  <td align="left"><?=$noo." ".$rinstruct?>
        <input type="hidden" name="runid[]22" value="<?=$rs[runid]?>">
        <?=$dateorder?></td>
	  <td align="center"><a href="salary.php?id=<?=$rs[id]?>&runid=<?=$rs[runid]?>&v=1&Y=all&action=edit2#keys">
	    <img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> 
	    &nbsp; <a href="#" 
	onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id=<?=$rs[id]?>&runid=<?=$rs[runid]?>&v=1&rem=<?=$rs[noorder]?>';" >
	      <img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a>	</td>    
  </tr>
  <?
	} //while
// List Template
?>
  <tr bgcolor="#dddddd" align="center">
    <td colspan="8"><input name="submit" type="submit" value="บันทึกการเรียงลำดับการแสดงผลใน ก.พ.7">
      <input type="hidden" NAME="viewall" VALUE="1"><input type="button" name="viewall" value="ข้อมูล5ปีย้อนหลังนับจากปัจจุบัน"  onClick="location.href='salary.php?action=edit&viewall=0' ">
      <input type="button" name="viewperiod2" value="ข้อมูลรายปี" onClick="location.href='salary.php?action=edit&viewall=2&YY=<?=$dmore?>' ">
      <input type="button" name="viewdata2" value="กลับหน้าแรก" onClick="location.href='salary.php?action=edit&viewall=5' "></td>
  </tr>
  </table>
  </form>
  
  <?
  }//END view==1
else if($viewall=2)

{
?>

<input type="hidden" NAME="id" VALUE="<?=$id?>">
<table width="98%" border="0" cellspacing="2" cellpadding="2" align="center" bgcolor="black">
  <tr bgcolor="#A3B2CC" align="center"><? $sql_yy="SELECT DISTINCT substring(`salary`.`date`,1,4) as Y FROM `salary` WHERE  id='$id'  order by date DESC ";
		$query_yy=mysql_query($sql_yy)or die (mysql_error());
		while($rsy=mysql_fetch_assoc($query_yy))	
		{
		echo "<a href=\"salary.php?action=edit&viewall=2&YY=$rsy[Y]\">$rsy[Y]</a> | ";
		
		}
		 $sql_data="select * from salary where id='$id' and date like '$YY%'  order by date DESC";
		
		$q_data=mysql_query($sql_data) or die (mysql_error());
		
		?>
		
    <td colspan="8" align="left" bgcolor="#2C2C9E"></td>
  </tr>
  <tr bgcolor="#A3B2CC" align="center">
  <td colspan="8" bgcolor="#2C2C9E"><span class="style1">การเลื่อนขั้นตำแหน่ง(แสดงข้อมูลช่วงปี)</span></td>
  </tr>
  <tr bgcolor="#A3B2CC" align="center" style="font-weight:bold;">
    <td width="11%"><strong>วัน เดือน ปี</strong></td>
	  <td width="36%"><strong>ตำแหน่ง</strong></td>
	  <td width="10%"><strong>เลขที่<br>
	    ตำแหน่ง</strong></td>
	  <td width="6%"><strong>ระดับ</strong></td>
	  <td width="6%"><strong>อัตรา<br>
	    เงินเดือน</strong></td>
	  <td width="23%"><strong>เอกสารอ้างอิง</strong></td>
	  <td width="8%"><input type="button" name="add3" value="เพิ่มข้อมูล" onClick="location.href='salary.php?id=<?=$id?>&v=2&YY=<?=$YY?>&action=edit1' "></td>    
  </tr>
  
  <?
while ($rs=mysql_fetch_array($q_data,MYSQL_ASSOC)){
	$i++;
if ($i % 2) {
	$bg = "#EFEFEF";
}else{
	$bg = "#DDDDDD";
}

if($rs[instruct]=="#")
{
	$rinstruct="";
}
else
{
$rinstruct=$rs[instruct];
}
if($rs[label_salary] !="")
{
	$salary=$rs[label_salary];
}
else
{
	if($rs[salary]==0)
	{
	$salary="";
	}
	else
	{
	$salary=number_format($rs[salary]);
	}
}
if($rs[noorder]=="#")
{
	$noo="";
}
else
{
	$noo=$rs[noorder];
}
if($rs[label_date] !="")
{
	$dateshow= $rs[label_date];
}
else
{
	$dateshowX=MakeDate2($rs[date]);
	$DX=explode(" ",$dateshowX);
	//echo "$DX[0]";
	if($DX[0]==0){$dxt="";}else{$dxt=$DX[0];}
	$dateshow=$dxt.$DX[1].$DX[2];
}
if($rs[label_dateorder] !="")
{
	$dateorder=$rs[label_dateorder];
}
else
{
	$dateorderX=MakeDate2($rs[dateorder]);
	$DO=explode(" ",$dateorderX);
	//echo "$DX[0]";
	if($DO[0]==0){$dot="";}else{$dot=$DO[0];}
	$dateorder=$dot.$DO[1].$DO[2];
	//$dateorder=MakeDate2($rs[dateorder]);
}
if($rs[label_radub] !=""){$radub=$rs[label_radub]; }
else{$radub=$rs[radub];}?>
  <tr align="center" bgcolor="<?=$bg?>">
    <td align="left">&nbsp;      <?=$dateshow?></td>
	  <td align="left">&nbsp;
        <?=wordwrap($rs[pls], 30, "\n", true)?></td>
	  <td align="center"><?=$rs[noposition]?></td>
	  <td align="center"><?=$radub?></td>
	  <td align="right"><?=$salary?>&nbsp;</td>
	  <td align="left"><?=$noo." ".$rinstruct?>
        <input type="hidden" name="runid[]222" value="<?=$rs[runid]?>">
        <?=$dateorder?></td>
	  <td align="center"><a href="salary.php?id=<?=$rs[id]?>&runid=<?=$rs[runid]?>&v=2&YY=<?=$YY?>&action=edit2#keys">
	    <img src="bimg/b_edit.png" width="16" height="16" border="0" alt="Edit"></a> 
	    &nbsp; <a href="#" 
	onClick="if (confirm('คุณจะทำการลบข้อมูลในแถวนี้ใช่หรือไม่!!')) location.href='?action=delete&id=<?=$rs[id]?>&runid=<?=$rs[runid]?>&v=2&YY=<?=$YY?>&rem=<?=$rs[noorder]?>';" >
	      <img src="bimg/b_drop.png" width="16" height="16" border="0" alt="Delete"></a>	</td>    
  </tr>
  <?
	} //while
// List Template
?>
  <tr bgcolor="#dddddd" align="center">
    <td colspan="7"><input type="button" name="viewall" value="เรียงลำดับข้อมูลและแสดงผลข้อมูลทั้งหมด"  onClick="location.href='salary.php?action=edit&viewall=1' ">
      <input type="button" name="viewall2" value="ข้อมูล 5 ปีย้อนหลังนับจากปัจจุบัน"  onClick="location.href='salary.php?action=edit&viewall=0' ">
      <input type="button" name="viewdata3" value="กลับหน้าแรก" onClick="location.href='salary.php?action=edit&viewall=5' "></td>
  </tr>
  </table>
<?
	}//END viewall==2	
}//END IF(action==edit)

  else
  {
if ($_GET[action]=="edit2"){

		$sql 		= "select * from salary where id='$id' and runid = '$runid'   ;";
		$result 	= mysql_query($sql);
		if ($result){
			$rs = mysql_fetch_array($result,MYSQL_ASSOC);
		}
		
}else{
	//	$sql = "select max(radub) as radub,max(salary) as salary, max(position) as position , max(noposition) as noposition from salary where id='$id'   ;";
	$sql 		= "select radub,salary,position,pos_group,noposition,dateorder,instruct from salary  where id='$id' order by runno desc limit 1";
	$result 	= mysql_query($sql);
	$rs		= mysql_fetch_assoc($result);
}
?>
  <a name="keys"></a>
  <form method="post" name="post" action="<?=$PHP_SELF?>" onSubmit="return check();">
  <input type="hidden" NAME="id" VALUE="<?=$id?>">
  <input type="hidden" NAME="v" VALUE="<?=$v?>">
    <input type="hidden" NAME="YY" VALUE="<?=$YY?>">
  <input type="hidden" NAME="runid" VALUE="<?=$runid?>">
  <input type="hidden" NAME="action" VALUE="<?=$_GET[action]?>">	
	  

  <table width="100%" border="0" cellspacing="3" cellpadding="2" align="center">
  <tr>
    <td width="174" align="right" >มีผล ณ : <br>
      (วัน เดือน ปี ) </td>
    <td align="left" valign="top"><? if($action=="edit1"){?><table width="580" border="0" cellpadding="1" cellspacing="2" bgcolor="#DEDFDE">
        
        <tr>
          <td><input type="radio" name="checkdate" value="0" id="checkdate1" onClick="clearselect();"   >ไม่ระบุวันที่            </td>
        </tr>
        <tr>
          <td><input type="radio" name="checkdate" value="1"  id="checkdate2" checked="checked" onClick="bbb();">
ระบุวันที่ </td>
        </tr>
        
		
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="2">
            <tr>
              <td><table width="100%" border="0" cellpadding="1" cellspacing="0">
    <tr>
      <td width="43%"><? //dateInput1($rs[date],"salary");?>
        <input  type="hidden" name="datebr"  id="datebr" value="<?=$rs[date]?>">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<select name="salary_day" id="salary_day">
				<?

						echo "<option value=''> ไม่ระบุ </option>";
						for ($i=1;$i<=31;$i++){
						$di=sprintf("%02d",$i);
						echo "<option value= $di>" .  $di . "</option>";
						}
				?>
				</select>
				<select name="salary_month" id="salary_month" >
				<?
				echo "<option value=''>ไม่ระบุ</option>";
				for ($i=1;$i<=12;$i++){
				$xi = sprintf("%02d",$i);
				echo "<option value='$xi'>$month[$i]</option>";
				}
				?>
				</select>
				<select name="salary_year" id="salary_year" >
				<?
				echo "<option value=''>ไม่ระบุ</option>";
				$thisyear = date("Y") + 543;
				$y1 = $thisyear - 80;
				$y2 = $thisyear ;
									
				for ($i=$y1;$i<=$y2;$i++){
						echo "<option value=$i>$i</option>";
				}
				
				?>
				</select>
</td>
      <td width="57%"><span class="style10">*รูปแบบการแสดงผลของวันที่คือ 12 ม.ค. 2551 ถ้า นอกเหนือจากตัวอย่างนี้ ให้ระบุในช่องส่วนแสดงผลใน ก.พ.7</span></td>
    </tr>
  </table></td>
            </tr>
            
            <tr>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="label_date" type="text" value="<?=$rs[label_date]?>" size="20" maxlength="100">
                <span class="style8">ส่วนแสดงผลใน ก.พ.7</span></td>
            </tr>
            
          </table></td>
        </tr>
    </table>
    <? }if($action=="edit2")
	{?>
	<table width="580" border="0" cellpadding="1" cellspacing="2" bgcolor="#DEDFDE">
        
        <tr>
          <td><input type="radio" name="checkdate" value="0" <? if($rs[date] ==""){echo "checked";}?>  id="checkdate1" onClick="clearselect();">
ไม่ระบุวันที่
  <input type="hidden" name="olddate" value="<?=$rs[date]?>"></td>
        </tr>
        <tr>
          <td><input type="radio" name="checkdate" value="1" <? if($rs[date] !=""){echo "checked";}?>  id="checkdate2" onClick="bbb();">
เปลี่ยนแปลงวันที่ใหม่</td>
        </tr>
        
        
		
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="2">
            <tr>
              <td><table width="100%" border="0" cellpadding="1" cellspacing="0">
    <tr>
      <td width="43%"><? //dateInput1($rs[date],"salary");?>
        <input  type="hidden" name="datebr2"  id="datebr2" value="<?=$rs[date]?>">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		<?  
		$d1=explode("-",$rs[date]);
		
		
		if ($d1[2] ==''){$dist="disabled";} 
		if ($d1[1]==''){$dist1="disabled";}
		if ($d1[0]==''){$dist2="disabled";}
	//	if($check_date==1 and $label_date=="")
	//	{
	//	$dist_label="disabled";
	//	}
	//	else if($check_date==0){ $dist_label="disabled";}
		
		
		?>
        <select name="salary_day" <?=$dist ?> >
				<?
						$d1=explode("-",$rs[date]);
						echo "<option value=''> ไม่ระบุ </option>";
						for ($i=1;$i<=31;$i++){
						  $di=sprintf("%02d",$i);
						if (intval($d1[2])== $i){
						echo "<option value='$di' SELECTED>" . $di. "</option>";
						}else{
								echo "<option>" .  sprintf("%02d",$i) . "</option>";
								}
						}
				?>
				</select>
				<select name="salary_month"<?=$dist1?> >
				<?
				echo "<option value=''>ไม่ระบุ</option>";
				for ($i=1;$i<=12;$i++){
					$xi = sprintf("%02d",$i);
					if (intval($d1[1])== $xi){
				//		echo "<option value='$xi' SELECTED>$xi</option>";
						echo "<option value='$xi' SELECTED>$month[$i]</option>";
					}else{
				//		echo "<option value='$xi'>$xi</option>";
						echo "<option value='$xi'>$month[$i]</option>";
					}
				}
				?>
				</select>
				<select name="salary_year" id="salary_year" <?=$dist2 ?> >
				<?
				echo "<option value=''>ไม่ระบุ</option>";
				$thisyear = date("Y") + 543;
				$y1 = $thisyear - 80;
				$y2 = $thisyear ;
									
				for ($i=$y1;$i<=$y2;$i++){
					if ($d1[0]== $i){
						echo "<option  value='$i' SELECTED>$i</option>";
					}else{
						echo "<option value='$i'>$i</option>";
					}
				}
				?>
				</select></td>
      <td width="57%"><span class="style10">*รูปแบบการแสดงผลของวันที่คือ 12 ม.ค. 2551 ถ้า นอกเหนือจากตัวอย่างนี้ ให้ระบุในช่องส่วนแสดงผลใน ก.พ.7</span></td>
    </tr>
  </table></td>
            </tr>
            
            <tr>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;<span class="style2">&nbsp;</span>&nbsp;&nbsp;
                <input name="label_date" type="text" value="<?=$rs[label_date]?>" size="20" maxlength="100" >
                <span class="style8">ส่วนแสดงผลใน ก.พ.7</span></td>
            </tr>
            
          </table></td>
        </tr>
    </table>
	<? }?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">
      ตำแหน่ง :<br>
      (ใน ก.พ.7) </td>
    <td width="787" align="left" valign="top"><table width="580" border="0" cellpadding="1" cellspacing="2" bgcolor="#DEDFDE">
        <tr>
          <td><span class="style8">ให้นำข้อมูลที่อยู่ในช่องตำแหน่งใน ก.พ. 7 มากรอก เช่น อาจารย์1 โรงเรียน xxxxx สพท.xxxx เป็นต้น </span></td>
        </tr>
        <tr>
          <td><textarea name="pls" cols="100" rows="5" id="pls"><?=$rs[pls]?></textarea></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right" valign="top">&nbsp;</td>
    <td align="left" valign="top"><span class="style8">**ส่วนปรับเปลี่ยนตำแหน่งและระดับ/อัตราเงินเดือน และ วิทยฐานะ กรุณากรอกข้อมูลให้ครบทั้งสามแท็บก่อนบันทึก </span></td>
  </tr>
  <tr>
    <td align="right" valign="top">&nbsp;</td>
    <td align="left" valign="top"><table width="580" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div class="tabber">
            <div class="tabbertab">
              <h2>ปรับเปลียนตำแหน่งและระดับ</h2>
              <table width="100%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
                <tr bgcolor="#dddddd">
                  <td height="20" colspan="2">&nbsp;<b><u>ส่วนปรับเปลี่ยนตำแหน่งและระดับ</u></b></td>
                </tr>
                <tr bgcolor="#f8f8f8">
                  <td width="25%" height="25" align="right">เลขที่ตำแหน่ง&nbsp;<b>:</b>&nbsp;</td>
                  <td width="75%"><input type="text" name="noposition" size="20" value="<?=$rs[noposition]?>"></td>
                </tr>
                <tr bgcolor="#f8f8f8">
                  <td height="25" align="right">ตำแหน่ง&nbsp;<b>:</b>&nbsp;</td>
                  <td><div id="hr_addposition">
                      <select name="hr_addposition" style="width:250px;">
                        <option value="" class="warn">ไม่ระบุ</option>
                        <?=getOption(" select runid as id, position as value from $dbnamemaster.hr_addposition order by position; ", $rs[position])?>
                      </select>
                      <? /*<img	src="images/web/index_add.gif" alt="เพิ่มข้อมูล" width="20" height="20" align="absmiddle"
	onclick="popWindow('addElement.php?table=hr_addposition','400','300')" style="cursor:hand;" />*/ ?>
                  </div></td>
                </tr>
                <tr bgcolor="#f8f8f8">
                  <td height="25" align="right">ระดับ&nbsp;<b>:</b>&nbsp;</td>
                  <td><div id="hr_addradub">
                      <select name="hr_addradub" style="width:154px;">
                        <option value="" class="warn">ไม่ระบุ</option>
                        <?=getOption(" select runid as id, radub as value from $dbnamemaster.hr_addradub order by radub; ", $rs[radub])?>
                      </select>
                      <? /*<img	src="images/web/index_add.gif" alt="เพิ่มข้อมูล" width="20" height="20" align="absmiddle"
	onclick="popWindow('addElement.php?table=hr_addradub','400','300')" style="cursor:hand;" />*/ ?>
                  </div></td>
                </tr>
                <tr bgcolor="#f8f8f8">
                  <td height="25" align="right">แสดงผลระดับในก.พ.7 &nbsp;<b>:</b>&nbsp;</td>
                  <td><input type="text" name="label_radub" value="<?=$rs[label_radub]?>">
                    <span class="style8">&nbsp;**กรอกในกรณีตำแหน่งไม่มีในส่วนที่เลือกจาก รายการระดับ</span></td>
                </tr>
              </table>
            </div>
          <div class="tabbertab">
              <h2>ปรับเปลียนอัตราเงินเดือน</h2>
            <table width="100%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
                <tr bgcolor="#dddddd">
                  <td height="20" colspan="2">&nbsp;<b><u>ส่วนปรับเปลี่ยนอัตราเงินเดือน</u></b></td>
                </tr>
                <tr bgcolor="#f8f8f8">
                  <td width="21%" height="25" align="right">อัตราเงินเดือน&nbsp;<b>:</b>&nbsp;</td>
                  <td width="79%"><input name="salary" type="text" id="salary" value="<?=$rs[salary]?>" style="width:100px;">
                    &nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr bgcolor="#f8f8f8">
                  <td height="25" align="right">&nbsp;ส่วนแสดงผลใน ก.พ.7&nbsp;<b>:</b>&nbsp;</td>
                  <td><input name="label_salary" type="text" id="label_salary" style="width:100px;" value="<?=$rs[label_salary]?>" maxlength="30" onBlur="check_sum1();">
                    <span class="style8">&nbsp;&nbsp;&nbsp;**ระบุเมื่อต้องการเปลี่ยนการแสดงผลอัตราเงินเดือนใน ก.พ.7 </span></td>
                </tr>
              </table>
          </div>
          <div class="tabbertab">
              <h2>ปรับเปลี่ยนวิทยฐานะ</h2>
            <table width="100%" cellspacing="1" cellpadding="2" align="center" bgcolor="#808080">
                <tr bgcolor="#dddddd">
                  <td height="20" colspan="2">&nbsp;<b><u>ส่วนปรับเปลี่ยนวิทยฐานะ</u></b></td>
                </tr>
                <tr bgcolor="#f8f8f8">
                  <td width="30%" height="25" align="right">ปรับเปลียนวิทยฐานะเป็น <b>:</b></td>
                  <td width="70%">&nbsp;
                      <? 
		//$sql_stat="SELECT * FROM vitaya_stat where id='$id'";
$xsql_s="SELECT * FROM vitaya_stat WHERE id='$id' and remark='$rs[noorder]' ";
	$xquery=mysql_query($xsql_s);
	$xrs_s=mysql_fetch_array($xquery,MYSQL_ASSOC);
	$remark=$xrs_s[remark];
	$xsql_v=mysql_query("SELECT * FROM $dbnamemaster.vitaya");
				
	  ?>
                      <select name="vitaya">
                        <?	
			
			echo "<option value=''if ($xrs_s[name] ==''){SELECTED}>ไม่ระบุวิทยฐานะ</option>";
		
				
			
	while ($xrs_v=mysql_fetch_array($xsql_v,MYSQL_ASSOC))
			{	
		 		if ($xrs_s[name] == $xrs_v[vitayaname])
					{ 			
					echo "<option value='$xrs_v[vitayaname]' SELECTED>$xrs_v[vitayaname]</option>";
					}
				else
					{
					echo "<option value='$xrs_v[vitayaname]'>$xrs_v[vitayaname]</option>";
					}
			}//end while
			
	/*		
			 echo " <option value=''if($xrs_v[name]==''){ selected }>ไม่มี</option>";
			while($xrs_v=mysql_fetch_array($xsql_v))
			{
             echo " <option value='$xrs_v[name]'  if($xrs_v[name]==$val){ selected}> $rsx[name]</option>";
			}*/ ?>
                    </select></td>
                </tr>
                <tr bgcolor="#f8f8f8">
                  <td height="25" align="right">&nbsp;</td>
                  <td bgcolor="#f8f8f8"><span class="style8">**เลือกวิทยฐานะในกรณี เป็นคำสั่งแต่งตั้งวิทยฐานะเท่านั้น**</span></td>
                </tr>
              </table>
            <? 
	  /*<input name="vitaya_sts" type="radio" value="0" <? if($xrs_s[dateorder] != $xrs_v[date_command]){ echo "checked";}/?>>
      //เป็นคำสั่งที่ไม่เกี่ยวข้องกับการได้รับ/ปรับเลื่อนวิทยฐานะ<br>
	  <input name="vitaya_sts" type="radio" value="1" <? if($xrs_s[dateorder]==$xrs_v[date_command]){ echo "checked";}?>>
      เป็นคำสั่งที่เกี่ยวกับการได้รับ/ปรับเลื่อนวิทยฐานะ&nbsp;เป็น
	  //<? 
		//$sql_stat="SELECT * FROM vitaya_stat where id='$id'";
	  ?>
      <select name="vitaya" onFocus="check_radio();">
        <option value="" <? if($xrs_v[name]==""){ echo "selected";}?>>ไม่มี</option>
        <?  
		foreach($namevit AS $key => $values){ 
			foreach ($values  AS  $val){
	?>
        
        <option value="<?=$val?>" <? if($xrs_v[name]=="$val"){ echo "selected";}?>><? echo "$key $val".$rsx[name]?></option>
        <? } } ?> 
        </select> 
      โดยคำสั่งนี้<br>*/?>
              <br>
          </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="right" ><font color="red">*</font> เลขที่คำสั่ง:<br>
แสดงในส่วนเอกสารอ้างอิง</td>
    <td align="left" valign="top"><table width="580" border="0" cellpadding="1" cellspacing="2" bgcolor="#DEDFDE">
      <tr valign="middle">
	  <?
	  $txtdis="";
if($action=="edit2")
{
$txtdis = "readonly=readonly" ;
}
	  ?>
        <td width="54%"><textarea name="noorder" style="width:300px; height:30px;"><?=$rs[noorder]?></textarea></td>
        <td width="46%"><span class="style8">กรณีไม่ระบุเลขที่คำสั่ง ให้ใส่เครื่องหมาย # 
          <input name="noorder_old" type="hidden" id="noorder_old" value="<?=$rs[noorder]?>">
        </span></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td align="right" >วันที่ :<br>
      (เอกสารอ้างอิง)</td>
    <td align="left" valign="top"><table width="580" border="0" cellpadding="1" cellspacing="2" bgcolor="#DEDFDE">
        <tr>
          <td bgcolor="#DEDFDE" ><input type="radio" name="instruct" value="ลว."  checked="checked" onClick="doClear(this);" <? if($rs[instruct]=="ลว."){ echo "checked" ;}?>>
          ลว.
          <input type="radio" name="instruct" value="สั่ง" onClick="doClear(this);" <? if($rs[instruct]=="สั่ง"){ echo "checked" ;}?> >
          สั่ง
          <input type="radio" name="instruct" value="other" onClick="aaa();"  <? if($rs[instruct]!="ลว."  and  $rs[instruct] !="สั่ง"){ echo "checked" ;}?> >
          อื่นๆ
          <input name="instruct1" type="text" disabled="disabled" value="<?=$rs[instruct]?>" size="10" maxlength="100"> 
          <span class="style2">&nbsp;<span class="style8">&nbsp;กรณีเลือกอื่นๆ และเป็นค่าว่างให้ใส่เครื่องหมาย # </span></span></td>
          </tr></table>
		  <? if($action=="edit1"){?>
		 <table width="580" border="0" cellpadding="1" cellspacing="2" bgcolor="#DEDFDE">
        <tr>
          <td><input type="radio" name="checkdateorder" value="0" id="checkdateorder1" onClick="disbb();">ไม่ระบุวันที่            </td>
        </tr>
        
        <tr>
          <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
            <tr>
              <td><input type="radio" name="checkdateorder" value="1"  id="checkdateorder2" checked="checked"  onClick="opendisable();">
ระบุวันที่</td>
            </tr>
            <tr>
              <td><table width="100%" border="0" cellpadding="1" cellspacing="0">
                  <tr>
                    <td width="43%" valign="middle"><? //dateInput1($rs[dateorder],"dateorder")?>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <select name="dateorder_day" >
                        <?
						
						echo "<option value=''> ไม่ระบุ </option>";
						for ($i=1;$i<=31;$i++){
						$doi=sprintf("%02d",$i);
						echo "<option value='$doi'>" .  $doi . "</option>";
						}
				?>
                      </select>
                      <select name="dateorder_month" >
                        <?
				echo "<option value=''>ไม่ระบุ</option>";
				for ($i=1;$i<=12;$i++){
						$xi = sprintf("%02d",$i);
						echo "<option value='$xi'>$month[$i]</option>";
					}

				?>
                      </select>
                      <select name="dateorder_year" id="dateorder_year" >
                        <?
				echo "<option value=''>ไม่ระบุ</option>";
				$thisyear = date("Y") + 543;
				$y1 = $thisyear - 80;
				$y2 = $thisyear ;					
				for ($i=$y1;$i<=$y2;$i++){
				echo "<option value='$i'>$i</option>";
				}
				?>
                      </select></td>
                    <td width="57%"><span class="style10">*รูปแบบการแสดงผลของวันที่คือ 12 ม.ค. 2551 ถ้า นอกเหนือจากตัวอย่างนี้ ให้ระบุในช่องส่วนแสดงผลใน ก.พ.7 </span></td>
                  </tr>
                </table></td>
            </tr>
            <tr>
              <td><span class="style2">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input name="label_dateorder" type="text" value="<?=$rs[label_dateorder]?>" size="20" maxlength="100">
                <span class="style8">ส่วนแสดงผลใน ก.พ.7</span></span></td>
            </tr>
            
          </table></td>
        </tr>
      </table>
		 <? }else if($action=="edit2"){?><table width="580" border="0" cellpadding="1" cellspacing="2" bgcolor="#DEDFDE">
        <tr>
          <td>
            <input type="hidden" name="olddateorder" value="<?=$rs[dateorder]?>">
          
          <input type="radio" name="checkdateorder" value="0"<? if($rs[dateorder]==""){echo "checked";}?> id="checkdateorder1" onClick="disbb();" >
ไม่ระบุวันที่</td>
        </tr>
        <tr>
          <td><input type="radio" name="checkdateorder" value="1"<? if($rs[dateorder] !=""){echo "checked";}?> id="checkdateorder2" onClick="opendisable();">
เปลี่ยนแปลงวันที่ใหม่ </td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#DEDFDE">
            <tr bgcolor="#CCCCCC">
              <td width="41%" bgcolor="#DEDFDE"><table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#DEDFDE">
                  <tr>
                    <td width="43%" valign="middle"><? //=dateInput1($rs[dateorder],"dateorder")?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <?
 
 
  		$d1=explode("-",$rs[dateorder]);
		
		if ($d1[2] ==''){$distdorder="disabled";} 
		if ($d1[1]==''){$distdorder1="disabled";}
		if ($d1[0]==''){$distdorder2="disabled";}
	//	if($checkdateorder==1 and $label_dateorder=='')
	//	{
	//	$distdorder_label="disabled";
	//	}
	//	else if($checkdateorder==0){$distdorder_label="disabled";}?>
  <select name="dateorder_day" <?=$distdorder?>> 
  <?
						echo "<option value=''> ไม่ระบุ </option>";
						for ($i=1;$i<=31;$i++){
						  $doi=sprintf("%02d",$i);
						if (intval($d1[2])== $i){
						echo "<option  value='$doi' SELECTED>" . $doi. "</option>";
						}else{
								echo "<option value='$doi'>" . $doi . "</option>";
								}
						}
				?>
</select>
<select name="dateorder_month" <?=$distdorder1?>>
  <?
				echo "<option value=''>ไม่ระบุ</option>";
				for ($i=1;$i<=12;$i++){
					$xi = sprintf("%02d",$i);
					if (intval($d1[1])== $xi){
				//		echo "<option value='$xi' SELECTED>$xi</option>";
						echo "<option value='$xi' SELECTED>$month[$i]</option>";
					}else{
				//		echo "<option value='$xi'>$xi</option>";
						echo "<option value='$xi'>$month[$i]</option>";
					}
				}
				?>
</select>
<select name="dateorder_year" id="dateorder_year" <?=$distdorder2?> >
  <?
				echo "<option value=''>ไม่ระบุ</option>";
				$thisyear = date("Y") + 543;
				$y1 = $thisyear - 80;
				$y2 = $thisyear ;
									
				for ($i=$y1;$i<=$y2;$i++){
					if ($d1[0]== $i){
						echo "<option  value='$i' SELECTED>$i</option>";
					}else{
						echo "<option value='$i'>$i</option>";
					}
				}
				?>
</select></td>
                    <td width="57%"><span class="style10">*รูปแบบการแสดงผลของวันที่คือ 12 ม.ค. 2551 ถ้า นอกเหนือจากตัวอย่างนี้ ให้ระบุในช่องส่วนแสดงผลใน ก.พ.7 </span></td>
                  </tr>
                </table>                </td>
              </tr>
            
            <tr bgcolor="#CCCCCC">
              <td bgcolor="#DEDFDE"><span class="style2">&nbsp;&nbsp;&nbsp;
                &nbsp;
                &nbsp;
                <input name="label_dateorder" type="text" value="<?=$rs[label_dateorder]?>" size="20" maxlength="100" >
<span class="style8">ส่วนแสดงผลใน ก.พ.7</span></span></td>
              </tr>
            
            
          </table></td>
        </tr>
      </table>
		 <? }?></td>
  </tr>
  
  <tr>
    <td align="right" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>

  <? /*
<tr valign="top"> 
	<td width="150" align="right">การเลื่อนขั้น</td>
	<td width="713"><input type="text" name="upgrade" size="40" value="<?=$rs[upgrade]?>"></td>
</tr>
	$xsql_s="SELECT * FROM salary WHERE id='$id'";
	$xquery=mysql_query($xsql_s);
	$xrs_s=mysql_fetch_array($xquery);
				$xsql_v=mysql_query("SELECT * FROM vitaya_stat WHERE id='$id' AND date_command='".$xrs_s[dateorder]."'");
				$xrs_v=mysql_fetch_array($xsql_v);
*/ 
			

?>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#333333">
  <tr valign="middle"> 
    <td align="center" colspan="2"><input type="submit" name="send" value="  บันทึก  "> <input type="hidden" NAME="remark" VALUE="<?=$remark?>"><input type="button" name="cancle" value="ยกเลิก" onClick="location.href='salary.php?action=edit&YY=<?=$YY?>&viewall=<?=$v?>' "></td>
  </tr>
  </table>
  </form>
  <? }?>

  <p>&nbsp;</p>
  <p>&nbsp;</p>
    </td></tr>
</table>
<? include("licence_inc.php");  ?>
</body>
</html>
<? $time_end = getmicrotime(); writetime2db($time_start,$time_end); ?>