<?php ######################  start Header ########################
/**
* @comment ไฟล์ถูกสร้างขึ้นมาสำหรับทดสอบ
* @projectCode 56EDUBKK01
* @tor 7.2.4
* @package core
* @author Suwat.K
* @access public/private
* @created 10/04/2014
*/
session_start();
/*            
include("../libary/function.php");
include("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
include ("checklogin.php");
include ("phpconfig.php");
include("alert.php");
*/        

require_once ("../../../config/phpconfig.php");
require_once("../../../config/config_hr.inc.php");
include("../../../common/common_competency.inc.php");
/*Conn2DB();*/
include ("../libary/function.php");
include ("timefunc.inc.php");
if ($_SERVER[REQUEST_METHOD] == "POST"){

}
?>
<?
$smonth = array("","ม.ค.", "ก.พ.", "มี.ค.", "เม.ย", "พ.ค", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
function  convert_date1($date001){  // convert  form format   2004-11-25  (YYYY-MM-DD)
				global $smonth ; 
				$syear = substr ("$date001", 0,4); // ปี
				if ($syear < 2300 ){  $syear = $syear + 543 ;  }
				$smm =  number_format(substr ("$date001", 5,2))  ; // เดือน
				$sday = (int)substr ("$date001", 8,2); // วัน
				$convert_date1 = "  $sday   ". $smonth[$smm] ." $syear  ";		
				return $convert_date1 ;
}
?>		
<html>
<head>
<title>ข้อมูลข้าราชการ</title>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
<script language="javascript" src="../../../common/js/jquery-1.8.2.js"></script>
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
				var url = "ajax_setkp7_historyaddress.php?runid=" + item1;
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
	if(document.form2.address.value.length == 0){
		alert("กรุณาระบุที่อยู่");
		document.form2.address.focus();
		return false;
	}else {
		return true;
	}
}	
function key_eng()
{
    var code;
    if (!e) var e = window.event;
    if (e.keyCode)
    {
        code = e.keyCode;
        if ((code >= 65&&code<=90)||(code >= 97&&code<=122)||(code==127))
        { return false;}
        else
        {  return true;}
    }
}
function regExp(){
	var eng_ex = new RegExp("[#@$!%^&*]");
	if(!($('#address').val()=='')){
		if($('#address').val().match(eng_ex)){
			alert("ไม่สามารถกรอกตัวอักขระพิเศษและภาษาอังกฤษได้!!");
			$('#address').val('');
		   $('#address').focus();
		   return false;
		}
    }
	
}
</script>
</head>
<body >
<?
$tbname = "hr_addhistoryaddress" ; 
# print_r($_SESSION) ; 
$general_id = $_SESSION[id] ; 
?>
<?
if($action != ""){
	add_log("ข้อมูลประวัติการเปลี่ยนแปลงที่อยู่",$general_id,$action);
}

if($action == "changeRow"){
	for($i=0;$i<count($runno);$i++){
		$sql		= " update $tbname set runno='".$runno[$i]."' where gen_id='".$general_id."' and runid='".$runid[$i]."' ";		
		$result 	= mysql_query($sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	}
	$xsql_h=mysql_query("SELECT * FROM $tbname WHERE gen_id='$general_id' ORDER BY runno DESC");
	$xrs_h=mysql_fetch_assoc($xsql_h);
		$sql_update="UPDATE general SET contact_add='$xrs_h[address]' WHERE id='$general_id'";
			
		$returnid = add_monitor_logbefore("general","id='$general_id'");
		$sql_query=mysql_query($sql_update);
		add_monitor_logafter("general","id='$general_id'",$returnid);

	echo "  <script language=\"JavaScript\">";
	 echo "opener.top.mainFrame.document.form1.contact_add.value=\"$xrs_h[address]\"; </script> ";	
}
//=================
if ($act=="del"){
	add_log("ข้อมูลประวัติการเปลี่ยนแปลงที่อยู่",$general_id,$act);
	
	$strSQL_DEL="SELECT * FROM $tbname WHERE gen_id='$general_id'";
	$Rs_Del=mysql_query($strSQL_DEL);
		$RS_DEL=mysql_num_rows($Rs_Del);
			if($RS_DEL == 1){
				echo "<script language=\"JavaScript\"> alert(\"ไม่สามารถลบข้อมูลได้เนื่องจะสร้างความเสียหายให้กับข้อมูล\");</script>";
			}else{
		$sql = " DELETE FROM $tbname WHERE  runid = $runid "; 
		$result = mysql_query($sql) ; 
		
			$str_delx="select max(kp7_active) as kp7_active from $tbname where gen_id='$general_id'";
			$result_delx=mysql_query($str_delx);
			$kp7_a="1";
			$rs_delx=mysql_fetch_array($result_delx);
				if($rs_delx[kp7_active] == 0 or $rs_delx[kp7_active] == NULL){
				$str_select_d="select * from $tbname where gen_id='$general_id' order by runno desc limit 0,1";
				$result_select_d=mysql_query($str_select_d);
				$rs_x1=mysql_fetch_array($result_select_d);
				$str_upDel="update $tbname set kp7_active='$kp7_a' where gen_id='".$rs_x1[gen_id]."' and runid='".$rs_x1[runid]."'";
				
				$returnid = add_monitor_logbefore("$tbname","gen_id='".$rs_x1[gen_id]."' and runid='".$rs_x1[runid]."'");
				@mysql_query($str_upDel);
				add_monitor_logafter("$tbname","gen_id='".$rs_x1[gen_id]."' and runid='".$rs_x1[runid]."'",$returnid);
				}			

		}
#####################################################update older record
$sql1 = "  SELECT * FROM `$tbname` WHERE `gen_id` = '$general_id' ORDER BY runno DESC";    
$result1 = mysql_query($sql1) ; 
$rs1 = mysql_fetch_assoc($result1) ; 
$sql2 = " UPDATE `general`   SET     `contact_add`='$rs1[address]' 
WHERE (`id`='$general_id')   
" ; 

$returnid = add_monitor_logbefore("general","id='$general_id'");
$result2 = mysql_query($sql2) ; 
add_monitor_logafter("general","id='$general_id'",$returnid);

	echo "  <script language=\"JavaScript\">";
	 echo "opener.top.mainFrame.document.form1.contact_add.value=\"$rs1[address]\"; </script> ";	
$act="";
} ############  if ($act=="del"){ 
?>
<?
if ($edit !="" and $runid != "" ){

$address  = trim($address) ; 

if($kp7 == 1){
$str_x1="select * from $tbname where gen_id='$general_id' and runid <>'$runid'";
	$result_x1=mysql_query($str_x1);
		while($rs_x1=mysql_fetch_assoc($result_x1)){
		$upkp7="0";
		$str_upx="update $tbname set kp7_active='$upkp7' where runid='".$rs_x1[runid]."' and gen_id='".$rs_x1[gen_id]."'";
			//echo $str_upx."<br>";
			@mysql_query($str_upx);
	}
$sql = " UPDATE `$tbname`  SET
 `address`='$address', `daterec`='$xdate', `kp7_active`='$kp7', `updatetime`= NOW()
WHERE (`runid`='$runid')   
" ; 

$returnid = add_monitor_logbefore("$tbname","runid='$runid'");
$result = mysql_query($sql) ; 
add_monitor_logafter("$tbname","runid='$runid'",$returnid);

}else{
$sql = " UPDATE `$tbname`  SET
 `address`='$address', `daterec`='$xdate', `kp7_active`='$kp7', `updatetime`= NOW()
WHERE (`runid`='$runid')   
" ; 
$returnid = add_monitor_logbefore("$tbname","runid='$runid'");
$result = mysql_query($sql) ; 
add_monitor_logafter("$tbname","runid='$runid'",$returnid);


}

$sql1 = "  SELECT * FROM `$tbname` WHERE `gen_id` = '$general_id'  ORDER BY runno DESC";    
$result1 = mysql_query($sql1) ; 
$rs1 = mysql_fetch_assoc($result1) ; 
$sql2 = " UPDATE `general`   SET     `contact_add`='$rs1[address]' 
WHERE (`id`='$general_id')   
" ; 

$returnid = add_monitor_logbefore("general","id='$general_id'");
$result2 = mysql_query($sql2) ; 
add_monitor_logafter("general","id='$general_id'",$returnid);

	echo "  <script language=\"JavaScript\">";
	 echo "opener.top.mainFrame.document.form1.contact_add.value=\"$rs1[address]\"; </script> ";		
} ############  if ($act=="del"){ 
?>
<?
if ($addnew  != ""){ 
	$address1 = trim($address) ; 
	$select_no="select max(runno) as runno from $tbname where gen_id='$general_id'";
$query_no=mysql_query($select_no);
$rs_no=mysql_fetch_array($query_no);
	$r_no=$rs_no['runno'];
	$runno_new=$r_no+1;
	if($kp7 == 1){
		$str_x2="select * from $tbname where gen_id='$general_id'";
		$result_x2=mysql_query($str_x2);
			while($rs_x2=mysql_fetch_assoc($result_x2)){
			$upkp="0";
			$str_upx2="update $tbname set kp7_active='$upkp' where runid='".$rs_x2[runid]."' and gen_id='".$rs_x2[gen_id]."'";
			$returnid = add_monitor_logbefore("$tbname","runid='".$rs_x2[runid]."' and gen_id='".$rs_x2[gen_id]."'");
			@mysql_query($str_upx2);
			add_monitor_logafter("$tbname","runid='".$rs_x2[runid]."' and gen_id='".$rs_x2[gen_id]."'",$returnid);
	}
	$sql = " 
	INSERT INTO `$tbname` ( `gen_id`,`address`  , `daterec`,`updatetime`,`kp7_active`,`runno`) 
	VALUES (   '$general_id','$address1',  '$xdate',NOW(), '$kp7','$runno_new')
	";  
	$returnid = add_monitor_logbefore("$tbname","");
	$result = mysql_query($sql) ; 
	$max_idx = mysql_insert_id();
	add_monitor_logafter("$tbname","runid='$max_idx' and gen_id='$general_id'",$returnid);


	}else{
		$sql = " 
	INSERT INTO `$tbname` ( `gen_id`,`address`  , `daterec`,`updatetime`,`kp7_active`,`runno`) 
	VALUES (   '$general_id','$address1',  '$xdate',NOW(), '$kp7','$runno_new')
	";  
	$returnid = add_monitor_logbefore("$tbname","");
	$result = mysql_query($sql) ; 
	$max_idx = mysql_insert_id();
	add_monitor_logafter("$tbname","runid='$max_idx' and gen_id='$general_id'",$returnid);


	}
	######################################################################  
	$sql1 = "  SELECT * FROM `$tbname` WHERE `gen_id` = '$general_id'  ORDER BY runno DESC";    
	$result1 = mysql_query($sql1) ; 
	$rs1 = mysql_fetch_assoc($result1) ; 
	$sql2 = " UPDATE `general`   SET     `contact_add`='$rs1[address]' 
	WHERE (`id`='$general_id')   
	" ; 
	
$returnid = add_monitor_logbefore("general","id='$general_id'");
$result2 = mysql_query($sql2) ; 
add_monitor_logafter("general","id='$general_id'",$returnid);

	echo "  <script language=\"JavaScript\">";
	 echo "opener.top.mainFrame.document.form1.contact_add.value=\"$rs1[address]\"; </script> ";		
} ########### END if ($addnew  != ""){ 
?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" background="bimg/bg1.gif" style="background-repeat: no-repeat; background-position:right bottom "><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="60" bgcolor="#2C2C9E"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="15%"><div align="center"><img src="bimg/hr.gif" width="64" height="64" /></div></td>
              <td width="85%"><B class="pheader">
                <?=($rs[runid]!=0?"แก้ไข":"เพิ่ม")?>ประวัติการเปลี่ยนแปลงที่อยู่</B></td>
            </tr>
        </table></td>
      </tr>
      <tr>

        <td>&nbsp;
		

		
		
		</td>
      </tr>
    </table>
<?
if ($act==""){ 
?>
<form name="form1" method="post" action="<?=$PHP_SELF?>">			
  <input type="hidden" name="action" value="changeRow">
   <input type="hidden" name="kp7" value="<?=$rs[runid];?>">
      <table width="98%" border="0" align="center" cellpadding="2" cellspacing="1">
        <tr class="gcaption"   align="center"  bgcolor="#A3B2CC"    >
          <td colspan="5" align="right" bgcolor="#A3B2CC"  ><!--<a href="?act=addnew"><img src="js/document_add.gif" width="24" height="24" border="0"></a>--></td>
        </tr>
        <tr class="gcaption"   align="center"  bgcolor="#A3B2CC"    >
          <td width="12%"  >ลำดับ</td>
          <td width="12%"  >ปีที่เปลี่ยนที่อยู่</td>
          <td width="41%">ที่อยู่</td>
          <td width="22%">สถานะการแสดงผลใน ก.พ.7 </td>
          <td width="13%">เครื่องมือ</td>
        </tr>
<?
	$c_month=date("Y");
$new_month=$c_month+543;
$xsql="SELECT * FROM hr_addhistoryaddress WHERE gen_id='$general_id'";
$xresult=mysql_query($xsql);
$xnum_row=mysql_num_rows($xresult);
	if($xnum_row<1){
		$xsql1="SELECT * FROM general WHERE id='$general_id'";
		$xresult1=mysql_query($xsql1);
			$xrs=mysql_fetch_assoc($xresult1);
			if($xrs[contact_add] != ""){
			$xsql2="INSERT INTO hr_addhistoryaddress(gen_id,address, daterec, kp7_active)VALUES('".$xrs[id]."','".$xrs[contact_add]."','$new_month','1')";
			$xrs2=mysql_query($xsql2);
			}
	}	
	$i=0;
$sql = " SELECT * FROM hr_addhistoryaddress WHERE gen_id='$general_id' ORDER BY runno ASC " ; 
$result = mysql_query($sql) ; 
$row=mysql_num_rows($result);
while($rs = mysql_fetch_assoc($result)){
$i++;
if ($bgcolor1 == "DDDDDD"){  $bgcolor1 = "EFEFEF"  ; } else {$bgcolor1 = "DDDDDD" ;}
/*
 runid  
 gen_id  prename_th  name_th  surname_th  secondname_th  
 
 prename_en  name_en  surname_en  secondname_en  
 
 daterec  updatetime  
*/
$daterec = $rs[daterec] ; 
# $daterec = convert_date1($rs[daterec])  ; 

?>
        <tr  bgcolor="#<?=$bgcolor1?>"  >
          <td align="center" > <select name="runno[]">
  			<?
			for($e=1;$e<=$row;$e++){
				$selected = ($e == $i) ? " selected " : "" ;
				echo "<option value=\"".$e."\" ".$selected.">".$e."</option>";
					}
			?>	
      </select></td>
	  <input type="hidden" name="runid[]" value="<?=$rs[runid]?>">
          <td align="center" > <?=$daterec?> </td>
          <td>&nbsp; <?=$rs[address]?></td>
          <td align="center"><? if($rs[kp7_active]=="1"){ echo "<img src=\"../../../images_sys/approve20.png\" alt='แสดงข้อมูลใน กพ7'>";}else{ echo "<img src=\"../../../images_sys/b_drop.png\" alt='ไม่แสดงข้อมูลใน กพ7'>";}?></td>
          <td align="center"> 

		  
            <input class="xbutton" style="width: 70;" type="button" value="Edit" onClick="location.href='?runid=<?=$rs[runid]?>&act=edit';" name="button2">
          
          <input class="xbutton"  style="width: 50;" type="button" value="Delete" onClick="if (confirm('คุณกำลังลบข้อมูล ในวันที่ <?=$rs[address]?>!!')) location.href='?act=del&runid=<?=$rs[runid]?>';" name="button3"></td>
        </tr >
        
<?
} ########## END while($rs = mysql_fetch_assoc($result)){ 
?>		
    </table>
	<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1">
	 <tr><td align="center"><input type="submit" name="Submit" value="บันทึกการเรียงลำดับการแสดงผลใน ก.พ.7"></td></tr>
	</table>
	</form>
<?
}  #  ##########  if ($act==""){ 
if ($act == "edit"){ 
?>
<form name="form1" method="post" action="?">
<?
$sql = " SELECT *  FROM $tbname WHERE  runid = $runid "; 
$result = mysql_query($sql) ; 
$rs = mysql_fetch_assoc($result) ; 
?>
  <table width="98%" border="0" align="center">
    <tr>
      <td colspan="2" bgcolor="#A3B2CC">&nbsp; <strong>แก้ไข</strong></td>
    </tr>
    <tr>
      <td width="14%" align="right">ปีเปลี่ยนที่อยู่</td>
      <td>
<?

#    $xdate = "2513-01-03";    == >ปฐิทิน ==> 10/12/2550   
$daterec = "$rs[daterec]";

$th_yy = date("Y")+543 ; 
$th_yy_60 = $th_yy - 60 ; 
?>	  

<select name="xdate"  >
<?   for ($ii = $th_yy ;  $ii > $th_yy_60 ; $ii-- ){   


if ($daterec == $ii ){
	$str_selected = " selected " ; 
}else{
	$str_selected = "  " ; 
} ## if ($xdate == $ii ){
?>
  <option value="<?=$ii?>" <?=$str_selected?> ><?=$ii?></option>
<?  } #### for ($ii = $th_yy ;  $ii <= $th_yy_60 ; $ii-- ){   ?>  
</select>
            
            
            
           <input name="runid" type="hidden" id="runid" value="<?=$runid?>"></td>
      </tr>
    
    <tr>
      <td align="right"><span class="textp"> </span><span class="textp">ที่อยู่</span></td>
      <td width="86%"><textarea name="address" id="address" onKeyPress="return key_eng();" onBlur="return regExp();" cols="70" rows="5" class="input_text"><?=$rs[address]?></textarea></td>
      </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td><input name="kp7" type="radio" value="1" <? if($rs[kp7_active]=="1"){ echo "checked";}?>>
แสดงผลใน ก.พ.7 &nbsp;
<input name="kp7" type="radio" value="0" <? if($rs[kp7_active]=="0"){ echo "checked";}?>>
ไม่แสดงผลใน ก.พ.7</td>
    </tr>
    
    <tr>
      <td colspan="2" align="center"><br>
        <input name="edit" type="submit" id="edit" value="บันทึก">
        &nbsp;
        <input type="button" name="Submit22" value="ย้อนกลับ" onClick="history.go(-1) "></td>
      </tr>
  </table>
</form>
<?
}  ########## END if ($act == "edit"){  
?>	
<?  if ($act == ""){   ?> 
<form name="form2" method="post" action="?" onSubmit="return check();">

  <table width="98%" border="0" align="center">
    <tr>
      <td colspan="2" bgcolor="#A3B2CC">&nbsp;<strong>เพิ่มใหม่</strong></td>
    </tr>
    <tr>
      <td width="13%" align="right">ปีเปลี่ยนที่อยู่</td>
      <td>
<?
$th_yy = date("Y")+543 ; 
$th_yy_60 = $th_yy - 60 ; 
?>
<select name="xdate"  >
<?   for ($ii = $th_yy ;  $ii > $th_yy_60 ; $ii-- ){   


if ($xdate == $ii ){
	$str_selected = " selected " ; 
}else{
	$str_selected = "  " ; 
} ## if ($xdate == $ii ){
?>
  <option value="<?=$ii?>" <?=$str_selected?> ><?=$ii?></option>
<?  } #### for ($ii = $th_yy ;  $ii <= $th_yy_60 ; $ii-- ){   ?>  
</select>
<input name="runid" type="hidden" id="runid" value="<?=$runid?>"></td>
      </tr>
    
    <tr>
      <td align="right"><span class="textp">ที่อยู่  </span></td>
      <td width="87%"><textarea name="address" id="address" onKeyPress="return key_eng();" onBlur="return regExp()" cols="70" rows="5" class="input_text"><?=$rs[address]?></textarea><!--<textarea name="address" cols="70" rows="5" class="input_text">
      </textarea>--></td>
      </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td><input name="kp7" type="radio" value="1" checked="checked">
แสดงผลใน ก.พ.7 &nbsp;
<input name="kp7" type="radio" value="0">
ไม่แสดงผลใน ก.พ.7</td>
    </tr>
    
    <tr>
      <td colspan="2" align="center"><br>
        <input name="addnew" type="submit" id="addnew" value="บันทึก">
        &nbsp;
        <input type="button" name="Submit22" value="ปิดหน้านี้" onClick="window.close(); "></td>
    </tr>
  </table>
</form>
<? } #######   if ($act == ""){   ?> 
<table width="98%" border="0" align="center">
  <tr>
    <td colspan="2"><strong>หมายเหตุ</strong></td>
    </tr>
  <tr>
    <td width="8%">&nbsp;</td>
    <td width="92%">เมื่อบันทึกข้อมูลระบบจะเรียกดึงข้อมูล หน้าบันทึกข้อมูลทั่วไป(หน้าก่อนนี้)ใหม่ หากมีการบันทึกข้อมูลในหน้าข้อมูลทั่วไป กรุณาบันทึกหน้าบันทึกข้อมูลทั่วไป(หน้าก่อนนี้) ก่อนบันทึก ประวัติการเปลี่ยนแปลงที่อยู่ </td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
