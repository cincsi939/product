<?php
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
<script type="text/javascript" src="../../../common/jquery/1.4/jquery.min.js"></script>
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
.style1 {color: #FF0000}
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
				var url = "ajax_setkp7_historyfathername.php?runid=" + item1;
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
	if(document.form2.xdate.value.length == 0){
		alert("กรุณาระบุวันที่เปลี่ยนชื่อ");
		document.form2.xdate.focus();
		return false;
	}else if(document.form2.father_prename.value.length == 0){
	alert("กรุณาระบุคำนำหน้าชื่อ");
		document.form2.father_prename.focus();
		return false;
	}else if(document.form2.father_name.value.length == 0){
	alert("กรุณาระบุชื่อ");
		document.form2.father_name.focus();
		return false;
	}else if(document.form2.father_surname.value.length == 0){
	alert("กรุณาระบุนามสกุล");
		document.form2.father_surname.focus();
		return false;
	}else {
		return true;
	}
}	
</script>
</head>
<body >
<?
$tbname = "hr_addhistoryfathername" ; 
# print_r($_SESSION) ; 
$general_id = $_SESSION[id] ; 
//echo "<pre>";print_r($_POST);die;
$prename_th=($prename_th!=0)?$prename_th:"";
if($father_prename&&$father_prename!=0){
	$strSQL="select * from $dbnamemaster.prename_th where PN_CODE='$father_prename' ";
	$result=@mysql_query($strSQL);
	$pre_result=@mysql_fetch_assoc($result);
	if($father_prename_label==""){
			$father_prename=$pre_result['prename_th'];
	}else{
			$father_prename=$father_prename_label;
	}
	//$father_prename=$pre_result['prename_th'];
	$father_prename_id=$pre_result['PN_CODE'];	
	$prename_en=$pre_result['prename_en'];	
	//echo "<pre>"; print_r($pre_result); die;
}else{
	$prename_th="";
	$prename_id="";
	$prename_en="";
}
?>
<?
	if($action != ""){
		add_log("ข้อมูลประวัติการเปลี่ยนชื่อบิดา",$general_id,$action);
	}

	if($action == "changeRow"){
	for($i=0;$i<count($runno);$i++){
		$sql		= " update $tbname set runno='".$runno[$i]."' where gen_id='".$general_id."' and runid='".$runid[$i]."' ";		
		$result 	= mysql_query($sql)or die("Query line ". __LINE__ ." error<hr>".mysql_error());
	}
	$xsql_h=mysql_query("SELECT * FROM $tbname WHERE gen_id='$general_id' ORDER BY runno DESC");
	$xrs_h=mysql_fetch_assoc($xsql_h);
		$sql_update="UPDATE general SET father_prename='".$xrs_h[father_prename]."',father_prename_id='".$xrs_h[father_prename_id]."', father_name='".$xrs_h[father_name]."', father_surname='".$xrs_h[father_surname]."', father_occ='".$xrs_h[father_occ]."' WHERE id='$general_id'";
		
		$returnid = add_monitor_logbefore("general","id='$general_id'");
		$sql_query=mysql_query($sql_update);
		add_monitor_logafter("general","id='$general_id'",$returnid);
		
		echo "  <script language=\"JavaScript\">
		opener.top.mainFrame.document.form1.father_prename.value=\"$xrs_h[father_prename]\"; 
	 	opener.top.mainFrame.document.form1.father_name.value=\"$xrs_h[father_name]\"; 
	 	opener.top.mainFrame.document.form1.father_surname.value=\"$xrs_h[father_surname]\"; 
	  	opener.top.mainFrame.document.form1.father_occ.value=\"$xrs_h[father_occ]\";
	 	</script>";	
}


if ($act=="del"){
	add_log("ข้อมูลประวัติการเปลี่ยนชื่อบิดา",$general_id,$act);
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
##############################################################
$sql1 = "  SELECT * FROM `$tbname` WHERE `gen_id` = '$general_id' ORDER BY runno DESC";    
$result1 = mysql_query($sql1) ; 
$rs1 = mysql_fetch_assoc($result1) ; 
$sql2 = " UPDATE `general`   SET  
 `father_prename`='$rs1[father_prename]',`father_prename_id`='$rs1[father_prename_id]',
 `father_name`='$rs1[father_name]',  `father_surname`='$rs1[father_surname]', `father_occ`='$rs1[father_occ]'
WHERE (`id`='$general_id')   
" ; 

$returnid = add_monitor_logbefore("general","id='$general_id'");
$result2 = mysql_query($sql2) ; 
add_monitor_logafter("general","id='$general_id'",$returnid);

		echo "  <script language=\"JavaScript\">
		opener.top.mainFrame.document.form1.father_prename.value=\"$rs1[father_prename]\"; 
	 	opener.top.mainFrame.document.form1.father_name.value=\"$rs1[father_name]\"; 
	 	opener.top.mainFrame.document.form1.father_surname.value=\"$rs1[father_surname]\"; 
	  	opener.top.mainFrame.document.form1.father_occ.value=\"$rs1[father_occ]\";
	 	</script>";	
$act="";
} ############  if ($act=="del"){ 
?>
<?
if ($edit !="" and $runid != "" ){
//$tmpdate = explode("/" , $xdate) ;
//$dd1 = $tmpdate[0] ; $mm1 = $tmpdate[1] ; $yy1 = $tmpdate[2] ; 
//if ($yy1 > 2350){ $yy1 -=  543 ;  } 
//
//$daterec = $yy1 ."-". $mm1  ."-". $dd1  ;  
$daterec=$xdate;

 if($kp7 == 1){
 $str_x1="select * from $tbname where gen_id='$general_id' and runid <>'$runid'";
	$result_x1=mysql_query($str_x1);
		while($rs_x1=mysql_fetch_assoc($result_x1)){
		$upkp7="0";
		$str_upx="update $tbname set kp7_active='$upkp7' where runid='".$rs_x1[runid]."' and gen_id='".$rs_x1[gen_id]."'";
			
			$returnid = add_monitor_logbefore("$tbname","runid='".$rs_x1[runid]."' and gen_id='".$rs_x1[gen_id]."'");
			@mysql_query($str_upx);
			add_monitor_logafter("$tbname","runid='".$rs_x1[runid]."' and gen_id='".$rs_x1[gen_id]."'",$returnid);
	}
$sql = " UPDATE `$tbname` 
SET `father_prename`='$father_prename',`father_prename_id`='$father_prename_id',`father_name`='$father_name',`father_surname`='$father_surname',`father_occ`='$father_occ',`father_daterec`='$daterec',`kp7_active`='$kp7',`updatetime`= NOW()
WHERE (`runid`='$runid')   
" ; 
$returnid = add_monitor_logbefore("$tbname","runid='$runid'");
$result = mysql_query($sql) ; 
add_monitor_logafter("$tbname","runid='$runid'",$returnid);


 }else{
 $sql = " UPDATE `$tbname` 
SET `father_prename`='$father_prename',`father_prename_id`='$father_prename_id',`father_name`='$father_name',`father_surname`='$father_surname',`father_occ`='$father_occ',`father_daterec`='$daterec',`kp7_active`='$kp7',`updatetime`= NOW()
WHERE (`runid`='$runid')   
" ; 
$returnid = add_monitor_logbefore("$tbname","runid='$runid'");
$result = mysql_query($sql) ; 
add_monitor_logafter("$tbname","runid='$runid'",$returnid);

 }


$sql1 = "  SELECT * FROM `$tbname` WHERE `gen_id` = '$general_id' ORDER BY runno DESC ";    
$result1 = mysql_query($sql1) ; 
$rs1 = mysql_fetch_assoc($result1) ; 
$sql2 = " UPDATE `general`   SET  
 `father_prename`='$rs1[father_prename]', `father_prename_id`='$rs1[father_prename_id]',`father_name`='$rs1[father_name]',
 `father_surname`='$rs1[father_surname]',`father_occ`='$rs1[father_occ]' WHERE (`id`='$general_id') " ; 
 
$returnid = add_monitor_logbefore("general","id='$general_id'");
$result2 = mysql_query($sql2) ; 
add_monitor_logafter("general","id='$general_id'",$returnid);
/*
echo " <pre> "; 
print_r($rs1) ; 
echo " </pre> "; 

echo $sql2 ; 
echo mysql_error() ; 
*/

		echo "  <script language=\"JavaScript\">
		opener.top.mainFrame.document.form1.father_prename.value=\"$rs1[father_prename]\"; 
	 	opener.top.mainFrame.document.form1.father_name.value=\"$rs1[father_name]\"; 
	 	opener.top.mainFrame.document.form1.father_surname.value=\"$rs1[father_surname]\"; 
	  	opener.top.mainFrame.document.form1.father_occ.value=\"$rs1[father_occ]\";
	 	</script>";		
} ############  if ($act=="edit"){ 
?>
<?
if ($addnew  != ""){ 
//$tmpdate = explode("/" , $xdate) ;
//$dd1 = $tmpdate[0] ; $mm1 = $tmpdate[1] ; $yy1 = $tmpdate[2] ; 
//if ($yy1 > 2350){ $yy1 -=  543 ;  } 
//$daterec = $yy1 ."-". $mm1  ."-". $dd1  ;  
$daterec=$xdate;

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
INSERT INTO `$tbname` ( `gen_id`,`father_prename`,`father_prename_id`,`father_name`,`father_surname`,
`father_daterec`,`updatetime`,`kp7_active`,`father_occ`,`runno`) 
VALUES (   '$general_id','$father_prename','$father_prename_id','$father_name','$father_surname','$daterec',NOW(),'$kp7','$father_occ','$runno_new')";  

$returnid = add_monitor_logbefore("$tbname","");
$result = mysql_query($sql) ; 
$max_idx = mysql_insert_id();
add_monitor_logafter("$tbname","runid='$max_idx' and gen_id='$general_id'",$returnid);

	}else{
	$sql = " 
INSERT INTO `$tbname` ( `gen_id`,`father_prename`,`father_prename_id`,`father_name`,`father_surname`,
`father_daterec`,`updatetime`,`kp7_active`,`father_occ`,`runno`) 
VALUES (   '$general_id','$father_prename','$father_prename_id','$father_name','$father_surname','$daterec',NOW(),'$kp7','$father_occ','$runno_new')";  

$returnid = add_monitor_logbefore("$tbname","");
$result = mysql_query($sql) ; 
$max_idx = mysql_insert_id();
add_monitor_logafter("$tbname","runid='$max_idx' and gen_id='$general_id'",$returnid);

	}

$sql1 = "SELECT * FROM `$tbname` WHERE `gen_id` = '$general_id' ORDER BY runno DESC";    
$result1 = mysql_query($sql1) ; 
$rs1 = mysql_fetch_assoc($result1) ; 
$sql2 = " UPDATE `general`   SET  
 `father_prename`='$rs1[father_prename]',`father_prename_id`='$rs1[father_prename_id]',`father_name`='$rs1[father_name]',
 `father_surname`='$rs1[father_surname]',`father_occ`='$rs1[father_occ]' WHERE (`id`='$general_id') " ; 


$returnid = add_monitor_logbefore("general","id='$general_id'");
$result2 = mysql_query($sql2) ; 
add_monitor_logafter("general","id='$general_id'",$returnid);


		echo "  <script language=\"JavaScript\">
		opener.top.mainFrame.document.form1.father_prename.value=\"$rs1[father_prename]\"; 
	 	opener.top.mainFrame.document.form1.father_name.value=\"$rs1[father_name]\"; 
	 	opener.top.mainFrame.document.form1.father_surname.value=\"$rs1[father_surname]\"; 
	  	opener.top.mainFrame.document.form1.father_occ.value=\"$rs1[father_occ]\";
	 	</script>";	
} ########## if ($addnew  != ""){  
?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" background="bimg/bg1.gif" style="background-repeat: no-repeat; background-position:right bottom "><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="60" bgcolor="#2C2C9E"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="15%"><div align="center"><img src="bimg/hr.gif" width="64" height="64" /></div></td>
              <td width="85%"><B class="pheader">เพิ่ม ประวัติการเปลี่ยนแปลงคำนำหน้าชื่อ ชื่อ นามสกุล และอาชีพของบิดา</B></td>
            </tr>
        </table></td>
      </tr>
      <tr>

        <td>&nbsp;		</td>
      </tr>
    </table>
<?
if ($act==""){ 
?>
<form name="form444" method="post" action="<?=$PHP_SELF?>">			
  <input type="hidden" name="action" value="changeRow">
   <input type="hidden" name="kp7" value="<?=$rs[runid];?>">
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1">
  <tr class="gcaption"   align="center"  bgcolor="#A3B2CC"    >
    <td width="5%" bgcolor="#A3B2CC"  >ลำดับ</td>
    <td width="11%" bgcolor="#A3B2CC"  >ปีที่เปลี่ยนชื่อ</td>
    <td width="12%" bgcolor="#A3B2CC">คำนำหน้าชื่อ</td>
    <td width="13%" bgcolor="#A3B2CC">ชื่อ</td>
    <td width="15%" bgcolor="#A3B2CC">นามสกุล</td>
    <td width="15%" bgcolor="#A3B2CC">อาชีพ</td>
    <td width="16%" bgcolor="#A3B2CC">สถานะการแสดงผลใน ก.พ.7</td>
    <td width="13%" bgcolor="#A3B2CC">เครื่องมือ</td>
  </tr>
  <?
  		$c_date=date("Y-m-d");
  		$xsql="SELECT * FROM hr_addhistoryfathername WHERE gen_id='$general_id'";
		$xrs=mysql_query($xsql);
		$xnum_row=mysql_num_rows($xrs);
			if($xnum_row < 1){
				$xsql1="SELECT * FROM general WHERE id='$general_id'";
					$xrs1=mysql_query($xsql1);
						$rs1=mysql_fetch_assoc($xrs1);
							if($rs1[father_name] != ""){
								$sql_insert="INSERT INTO hr_addhistoryfathername(gen_id, father_prename, father_name, father_surname, father_daterec, kp7_active)VALUES('".$rs1[id]."', '".$rs1[father_prename]."', '".$rs1[father_name]."', '".$rs1[father_surname]."', '$c_date', '1')";
								$query_insert=mysql_query($sql_insert);
							
							}
			
			}
	$i=0;		
$sql = " SELECT * FROM hr_addhistoryfathername WHERE gen_id='$general_id' ORDER BY runno ASC " ; 
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
$daterec = $rs[father_daterec] ; 
//$daterec = convert_date1($rs[father_daterec])  ; 

?>
  <tr  bgcolor="#<?=$bgcolor1?>"  >
    <td align="center" >
	<select name="runno[]">
  			<?
			for($e=1;$e<=$row;$e++){
				$selected = ($e == $i) ? " selected " : "" ;
				echo "<option value=\"".$e."\" ".$selected.">".$e."</option>";
					}
			?>	
      </select>	</td>
	<input type="hidden" name="runid[]" value="<?=$rs[runid]?>">
    <td align="center" ><?=$daterec?>    </td>
    <td>&nbsp;<?=$rs[father_prename]?></td>
    <td>&nbsp;<?=$rs[father_name]?></td>
    <td>&nbsp;<?=$rs[father_surname]?></td>
    <td>&nbsp; <?=$rs[father_occ]?></td>
    <td align="center"><? if($rs[kp7_active]=="1"){  $dis_delete="disabled"; echo "<img src=\"../../../images_sys/approve20.png\" alt='แสดงข้อมูลใน กพ7'>";}else{ echo "<img src=\"../../../images_sys/b_drop.png\" alt='ไม่แสดงข้อมูลใน กพ7'>";  $dis_delete="";}?></td>
    <td align="center"><input class="xbutton" style="width: 70;" type="button" value="Edit" onClick="location.href='?runid=<?=$rs[runid]?>&act=edit';" name="button2">
        <input class="xbutton"  style="width: 50;" type="button" value="Delete" onClick="if (confirm('คุณกำลังลบข้อมูล ในวันที่ <?=$father_daterec?>!!')) location.href='?act=del&runid=<?=$rs[runid]?>';" name="button3"  <?=$dis_delete?>></td>
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
}else{  ##########  if ($act==""){ 
?>
<form name="formvvvv" method="post" action="?">
<?
$sql = " SELECT *  FROM $tbname WHERE  runid = $runid "; 
$result = mysql_query($sql) ; 
$rs = mysql_fetch_assoc($result) ; 
?>
  <table width="98%" border="0" align="center">
    <tr>
      <td colspan="6" bgcolor="#A3B2CC">&nbsp; <strong>แก้ไข</strong></td>
    </tr>
    <tr>
      <td width="7%" align="right">ปีที่เปลี่ยนชื่อ</td>
      <td colspan="5">
<?
#    $xdate = "2513-01-03";    == >ปฐิทิน ==> 10/12/2550   
$daterec = "$rs[father_daterec]";

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
						  <option value="<?=$ii?>" <?=$str_selected?> >
							<?=$ii?>
				  </option>
						  <?  } #### for ($ii = $th_yy ;  $ii <= $th_yy_60 ; $ii-- ){   ?>
			  </select>
			  
           <input name="runid" type="hidden" id="runid" value="<?=$runid?>">		   </td>
      </tr>
    <tr class="gcaption">
      <td align="right">&nbsp;</td>
      <td width="19%" align="center">คำนำหน้าชื่อ</td>
      <td width="20%" align="center">ชื่อ</td>
      <td width="21%" align="center">นามสกุล</td>
      
      <td width="21%" align="center">อาชีพ</td>
    </tr>
    <tr>
      <td align="right"><span class="textp">(ไทย) </span></td>
      <td><select name="father_prename"  style="width:140px;" >
        <option value="">ไม่ระบุ</option>
        <?		
		$strSQL="select prename_th as prename , PN_CODE ,short_prename_th as sprename from $dbnamemaster.prename_th WHERE prename_th !=''AND PN_CODE !='' AND active = 'on' group by PN_CODE  order by orderby , prename_th ";		
		$select1  = mysql_query($strSQL);
		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC)){
			if($rselect1[sprename] != ""){
				$xprename = "$rselect1[prename]($rselect1[sprename])";	
			}else{
				$xprename = "$rselect1[prename]";	
			}
			
		if( ($rs[father_prename] == $rselect1[prename]) || ($rs[father_prename_id] == $rselect1[PN_CODE] && ($rs[father_prename_id]) && ($rselect1[PN_CODE])) )		
		{ 			
			$PN_CODE_CONVETOR="$rselect1[PN_CODE]";
			echo "<option value='$rselect1[PN_CODE]' SELECTED>$xprename</option>";
		}else
			{
			echo "<option value='$rselect1[PN_CODE]' >$xprename</option>";
			}
		}//end while
		?>
      </select></td>
      <td><input name="father_name" id="father_name" type="text" class="input_text" value="<?=$rs[father_name]?>" size="20" onKeyPress="isThaichar(this.value,'father_name','')" onKeyUp="isThaichar(this.value,'father_name','')" onBlur="isThaichar(this.value,'father_name','full')"></td>
      <td><input name="father_surname" id="father_surname" type="text" class="input_text" value="<?=$rs[father_surname]?>" size="20" ></td><!--onKeyPress="isThaichar(this.value,'father_surname','')" onKeyUp="isThaichar(this.value,'father_surname','')" onBlur="isThaichar(this.value,'father_surname','full')"-->
      <td><input name="father_occ" type="text" class="input_text" value="<?=$rs[father_occ]?>" size="20"></td>
    </tr>
     <tr>
      <td align="right"></td>
      <td colspan="4">
      		<input name="father_prename_label" type="text" class="input_text" value="<?=$rs[father_prename]?>" size="23" > 
            <span class="style1">หากท่านบันทึกในช่องแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span>
      </td>
      </tr>
    <tr>
      <td colspan="6" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="center">
	  <?
		$sql = " SELECT * FROM $tbname WHERE gen_id='$general_id' AND kp7_active=1 ORDER BY runno ASC" ; 
		$result = mysql_query($sql) ; 
		$row=mysql_num_rows($result);
		if($rs[kp7_active]=="1" && $row==1 ){ $kp7_st_active="disabled"; }else{ $kp7_st_active=""; } 	  
		
	  ?>  
	  	<input name="kp7" type="radio" value="1" <? if($rs[kp7_active]=="1"){ echo "checked";}?>>
แสดงผลใน ก.พ.7 &nbsp;
		<input name="kp7" type="radio" value="0" <? if($rs[kp7_active]=="0"){ echo "checked";} echo  $kp7_disabled;?>>
ไม่แสดงผลใน ก.พ.7</td>
    </tr>
    <tr>
      <td colspan="6" align="center"><br>
        <input name="edit" type="submit" id="edit" value="บันทึก">
        &nbsp;
        <input type="submit" name="Submit2" value="ย้อนกลับ"></td>
    </tr>
  </table>
</form>
<?
}  ########## END   if ($act==""){ 
?>	
<?  if ($act == ""){   ?> 
<form name="form2" method="post" action="?" onSubmit="return check();">

  <table width="98%" border="0" align="center">
    <tr>
      <td colspan="6" bgcolor="#A3B2CC">&nbsp;<strong>เพิ่มใหม่</strong></td>
    </tr>
    <tr>
      <td width="7%" align="right">ปีที่เปลี่ยนชื่อ</td>
      <td colspan="5">
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
          <option value="<?=$ii?>" <?=$str_selected?> >
            <?=$ii?>
            </option>
          <?  } #### for ($ii = $th_yy ;  $ii <= $th_yy_60 ; $ii-- ){   ?>
        </select>
		
		   <input name="runid" type="hidden" id="runid" value="<?=$runid?>">		   </td>
      </tr>
    <tr class="gcaption">
      <td align="right">&nbsp;</td>
      <td width="19%" align="center">คำนำหน้าชื่อ</td>
      <td width="20%" align="center">ชื่อ</td>
      <td width="21%" align="center">นามสกุล</td>
      
      <td width="21%" align="center">อาชีพ</td>
    </tr>
    <tr>
      <td align="right"><span class="style1">*</span><span class="textp">(ไทย) </span></td>
      <td><select name="father_prename"  style="width:140px;" >
        <option value="">ไม่ระบุ</option>
        <?
		$strSQL="select prename_th as prename , PN_CODE,short_prename_th as sprename  from $dbnamemaster.prename_th WHERE prename_th !='' AND PN_CODE !='' AND active = 'on' group by PN_CODE  order by orderby , prename_th ";		
		$select1  = mysql_query($strSQL);
		while ($rselect1=mysql_fetch_array($select1,MYSQL_ASSOC)){
			
			if($rselect1[sprename] != ""){
				$xprename = "$rselect1[prename]($rselect1[sprename])";	
			}else{
				$xprename = "$rselect1[prename]";	
			}

		if( ($rs[father_prename] == $rselect1[prename]) || ($rs[prename_id] == $rselect1[PN_CODE] && ($rs[prename_id]) && ($rselect1[PN_CODE])) )		
		{ 			
			$PN_CODE_CONVETOR="$rselect1[PN_CODE]";
			echo "<option value='$rselect1[PN_CODE]' SELECTED>$xprename</option>";
		}else
			{
			echo "<option value='$rselect1[PN_CODE]' >$xprename</option>";
			}
		}//end while
		?>
      </select></td>
      <td><input name="father_name" id="father_name" type="text" class="input_text" value="<?=$rs[father_name]?>" size="20" onKeyPress="isThaichar(this.value,'father_name','')" onKeyUp="isThaichar(this.value,'father_name','')" onBlur="isThaichar(this.value,'father_name','full')"></td>
      <td><input name="father_surname" id="father_surname" type="text" class="input_text" value="<?=$rs[father_surname]?>" size="20"></td><!-- onKeyPress="isThaichar(this.value,'father_surname','')" onKeyUp="isThaichar(this.value,'father_surname','')" onBlur="isThaichar(this.value,'father_surname','full')"-->
      <td><input name="father_occ" type="text" class="input_text" value="<?=$rs[father_occ]?>" size="20"></td>
    </tr>
    <tr>
      <td align="right"></td>
      <td colspan="4">
      		<input name="father_prename_label" type="text" class="input_text" value="<?=$rs[father_prename]?>" size="23" > 
            <span class="style1">หากท่านบันทึกในช่องแสดงผล กพ.7 ระบบจะนำข้อมูลนี้แสดงผลใน กพ.7 แทน</span>
      </td>
      </tr>
    <tr>
      <td colspan="6" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="center">
	  <?
		$sql = " SELECT * FROM $tbname WHERE gen_id='$general_id' AND kp7_active=1 ORDER BY runno ASC" ; 
		$result = mysql_query($sql) ; 
		$row=mysql_num_rows($result);
		if($row==0 ){ $kp7_st_active="disabled"; }else{ $kp7_st_active=""; } 	  
	  ?> 	  
<input name="kp7" type="radio" value="1" checked="checked">
แสดงผลใน ก.พ.7 &nbsp;
<input name="kp7" type="radio" value="0" <?= $kp7_st_active?>>
ไม่แสดงผลใน ก.พ.7</td>
    </tr>
    <tr>
      <td colspan="6" align="center"><br>
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
    <td width="92%">เมื่อบันทึกข้อมูลระบบจะเรียกดึงข้อมูล หน้าบันทึกข้อมูลทั่วไป(หน้าก่อนนี้)ใหม่ หากมีการบันทึกข้อมูลในหน้าข้อมูลทั่วไป กรุณาบันทึกหน้าบันทึกข้อมูลทั่วไป(หน้าก่อนนี้) ก่อนบันทึก ประวัติการเปลี่ยนแปลงคำนำหน้าชื่อ นามสกุล และ ชื่อรอง  </td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
<script>
function isThaichar(str,obj,type){  
    var orgi_text="()ๅภถุึคตจขชๆไำพะัีรนยบลฃฟหกดเ้่าสวงผปแอิืทมใฝ๑๒๓๔ู฿๕๖๗๘๙๐ฎฑธํ๊ณฯญฐฅฤฆฏโฌ็๋ษศซฉฮฺ์ฒฬฦ";  
    var str_length=str.length;  
    var str_length_end=str_length-1;  
    var isThai=true;  
    var Char_At="";  
    for(i=0;i<str_length;i++){  
        Char_At=str.charAt(i);  
        if(orgi_text.indexOf(Char_At)==-1){  
            isThai=false;  
        }     
    }  
    if(str_length>=1){  
        if(isThai==false){  
			$('#'+obj).val(str.substr(0,str_length_end));
        }  
    }

	if(type=='full' && isThai==false){
		alert('รองรับการกรอกอักษรภาษาไทยเท่านั้น');
		$('#'+obj).val('');
		$('#'+obj).focus();
	}
    return isThai; // ถ้าเป็น true แสดงว่าเป็นภาษาไทยทั้งหมด  
}
</script>